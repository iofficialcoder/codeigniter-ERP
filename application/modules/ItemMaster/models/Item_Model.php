<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Item_Model extends CI_Model{
    public function __construct(){
      parent::__construct();
    }

    public function get_items() {
        $query = $this->db->get('item_master'); // Query the item_master table
        print_r($query->result_array());
        return $query->result_array(); // Return the result as an array
    }
    //add user to database query
    public function addUserQuery($data){
      return $this->db->insert('item_master', $data);
    }

    public function makeUserSeniorQuery($data){
      return $this->db->insert('senior', $data);
    }
    public function addItem($data){
        return $this->db->insert('item_master', $data);
    }

    public function getAllItems() {
        $this->db->select('*');
        $this->db->from('item_master'); // Make sure the table name is correct
        $result = $this->db->get();
        return $result->result_array(); // Return the result as an array
    }

    public function getItemById($item_id) {
        $this->db->select('*');
        $this->db->from('item_master');
        $this->db->where('id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();  // Return the item details
        } else {
            return null;
        }
    }

    public function updateItem($item_id, $data) {
        // echo "</pre>";
        // echo print_r( $item_id);
        // exit;
        $this->db->where('id', $item_id);
        return $this->db->update('item_master', $data);

		if ($this->db->affected_rows() > 0) {
		return true;
		}
		 else { 
		return false;
		}
    }

    // public function getItemById($item_id) {
    //     return $this->db->get_where('items', ['item_id' => $item_id])->row_array();
    // }
    public function deleteItem($item_id) {
        $this->db->where('id', $item_id);
        return $this->db->delete('item_master');  // Returns true if delete was successful
        if ($this->db->affected_rows() > 0) {
            return true;
        } else { 
            return false;
        }
    }

    public function seniorJuniorExist($chkSenior, $checkJunior){
      $this->db->select('*');
      $this->db->from('senior');
      $this->db->where('senior_id =', $chkSenior);
      $this->db->where('junior_id =', $checkJunior);

      $this->db->or_where('senior_id =', $checkJunior);
      $this->db->where('junior_id =', $chkSenior);

      $result = $this->db->get();

      if ($result->num_rows() > 0) {
        return $result->row();
      }
    }

    public function countEmployees() {
      $query = $this->db->get('item_master');
      return $query->num_rows();
  }

    public function getAllUser(){
      $this->db->select('*');
      $this->db->from('item_master');
      $this->db->where('user_role !=', 'Administrator');
      $result = $this->db->get();
      return $result->result_array();
    }

    function deleteUser($id)
  {
    $this->db->where("user_id", $id);
    $this->db->delete("item_master");
    return true;
  }

    public function getAllSenior(){
      $this->db->select('*');
      $this->db->from('senior');
      $result = $this->db->get();
      return $result->result_array();
    }
  }
?>