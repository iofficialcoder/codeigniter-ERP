<?php
class ItemMaster extends MY_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('Item_Model');
    if ($this->session->userdata('user_role') != 'Administrator') {
      die('you have no access on this page......go away');
    }
  }

  public function addUserPage(){
    $data['content_view'] = 'ItemMaster/item-master';
    $this->templates->admin($data);
  }

  public function addItemPage() {
    $data['content_view'] = 'ItemMaster/item-master';
    $this->templates->admin($data);
}
public function addItem() {
    $this->form_validation->set_rules('user_name', 'Item Name', 'required');

    if ($this->form_validation->run()) {
        $data = [
            'item_name' => $this->input->post('user_name'),
            'item_price' => $this->input->post('item_price'),
        ];

        // Handle file upload for item photo
        if (!empty($_FILES['item_photo']['name'])) {
            $config['upload_path'] = './uploads/items/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time() . '_' . $_FILES['item_photo']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('item_photo')) {
                $uploadData = $this->upload->data();
                $data['item_photo'] = 'uploads/items/' .$uploadData['file_name'];
            } else {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('ItemMaster/addItemPage');
            }
        }

        if ($this->Item_Model->addItem($data)) {
            $this->session->set_flashdata('message', 'Item added successfully!');
        } else {
            $this->session->set_flashdata('message', 'Failed to add item.');
        }
        redirect('ItemMaster/addItemPage');
    } else {
        $this->addItemPage();
    }
}

public function viewItems() {
    // Fetch all items from the database
    $data['items'] = $this->Item_Model->getAllItems();

    // Load the view with the data
    $data['content_view'] = 'ItemMaster/view-items'; // This will be the view you create
    $this->templates->admin($data);
}

public function editItem($item_id) {
    // Fetch the item details by ID
    $data['item'] = $this->Item_Model->getItemById($item_id);

        // echo "</pre>";
        // echo print_r($data['item']);
        // echo exit;

    
    // If item is not found, show an error or redirect
    if (empty($data['item'])) {
        $this->session->set_flashdata('message', 'Item not found.');
        return redirect('ItemMaster/viewItems');
    }
    
    // Load the edit view
    $data['content_view'] = 'ItemMaster/edit-item';
    $this->templates->admin($data);
}

public function upload_item_photo() {
    $config['upload_path'] = './uploads/items/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 2048;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('item_photo')) {
        $upload_data = $this->upload->data();
        return 'items/' . $upload_data['file_name'];
    } else {
        return false;
    }
}

public function updateItem($item_id) {
    $this->load->model('Item_Model');
    
    // Retrieve the existing item details, including the current image
    $item = $this->Item_Model->getItemById($item_id);
    
    // Set validation rules
    $this->form_validation->set_rules('item_name', 'Item Name', 'required');
    
    if ($this->form_validation->run()) {
        $data = [
          'item_name' => $this->input->post('item_name'),
          'item_price' => $this->input->post('item_price')
        ];


        // Check if a new image is uploaded
        if (!empty($_FILES['item_photo']['name'])) {
            // Load upload library configuration
            $config['upload_path'] = './uploads/items/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time() . '_' . $_FILES['item_photo']['name'];
            $this->load->library('upload', $config);

            // If upload is successful, delete old image and save new image
            if ($this->upload->do_upload('item_photo')) {
                // Delete the old image file if it exists
                if (!empty($item['item_photo']) && file_exists('./' . $item['item_photo'])) {
                    unlink('./' . $item['item_photo']);
                }

                // Get the uploaded file path and save it
                $uploadData = $this->upload->data();
                $data['item_photo'] = 'uploads/items/' . $uploadData['file_name'];
            } else {
                // Handle upload errors
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('message', 'Image upload failed: ' . $error);
                redirect('ItemMaster/editItem/' . $item_id);
                return;
            }
        } else {
            // If no new image is uploaded, keep the old image path
            $data['item_photo'] = $item['item_photo'];
        }

        // Update item data in the database
        if ($this->Item_Model->updateItem($item_id, $data)) {
            $this->session->set_flashdata('message', 'Item updated successfully.');
        } else {
            $this->session->set_flashdata('message', 'Failed to update item.');
        }

        redirect('ItemMaster/viewItems');
    } else {
        // Reload the edit page with validation errors
        $this->editItem($item_id);
    }
}

public function deleteItem($item_id) {
    // Check if the item exists before trying to delete
    $item = $this->Item_Model->getItemById($item_id);

    if ($item) {
        // Delete the item from the database
        if ($this->Item_Model->deleteItem($item_id)) {
            // Delete the photo file if it exists
            $photo_path = './uploads/items/' . $item['item_photo'];
            if (file_exists($photo_path)) {
                unlink($photo_path);  // Delete the photo file
            }

            $this->session->set_flashdata('message', 'Item deleted successfully.');
        } else {
            $this->session->set_flashdata('message', 'Failed to delete item.');
        }
    } else {
        $this->session->set_flashdata('message', 'Item not found.');
    }

    // Redirect back to the items list page
    return redirect('ItemMaster/viewItems');
}

  public function deleteUserRec(){
    $id=$this->input->get('user_id');
    $response=$this->User_Model->deleteUser($id);
      if($response==true){
        if ($this->User_Model->deleteUser($id)) {
          $this->session->set_flashdata('message', 'User has been deleted');
  
        } else {
          $this->session->set_flashdata('message', 'Something went wrong');
        }
        return redirect('User/viewUserPage');
    } else {
      echo "Error";
    }
  }

  public function viewUserPage(){
    $data = null;
    $data['get_all_user'] = $this->User_Model->getAllUser($data);
    $data['get_all_senior'] = $this->User_Model->getAllSenior($data);
    $data['content_view'] = 'ItemMaster/item-master';
    $this->templates->admin($data);
  }

  public function makeUserSeniorPage(){
    $data = null;
    $data['get_all_user'] = $this->User_Model->getAllUser($data);
    $data['content_view'] = 'ItemMaster/make-user-senior-view';
    $this->templates->admin($data);
  }

  public function addUser(){
    $this->form_validation->set_rules('user_name', 'Employee Name', 'required');
    $this->form_validation->set_rules('user_role', 'Employee Role', 'required');
    $this->form_validation->set_rules('user_email', 'Email address', 'required');
    $this->form_validation->set_rules('user_password', 'Password', 'required');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      $data['user_password'] = md5($this->input->post('user_password'));

      if ($this->Item_Model->addUserQuery($data)) {
        $this->session->set_flashdata('message', 'Your Submission Saved Succesfully into the Database');

      } else {
        $this->session->set_flashdata('message', 'Your Submission Not Saved Successfull');
      }
      return redirect('ItemMaster/addItemPage');
    } else{
        $this->addItemPage();
    }
  }


  public function makeUserSenior(){
    $data['senior_id'] = $this->input->post('senior_id');
    $datajunior = $this->input->post('junior_id');


    $countJunior = count($datajunior);
    //print_r($this->User_Model->makeUserSeniorQuery($data));

    for ($i=0; $i < $countJunior; $i++) {
      $chkSenior = $this->input->post('senior_id');;
      $checkJunior = $datajunior[$i];
      $chkExistence = $this->User_Model->seniorJuniorExist($chkSenior, $checkJunior);

      if($chkExistence){
        $this->session->set_flashdata('errmessage', 'Your Submission Not Saved Succesfully into the Database');
        return redirect('User/makeUserSeniorPage');
      }else{
        for ($i=0; $i < $countJunior; $i++) {
          $data['junior_id'] = $datajunior[$i];
          $this->User_Model->makeUserSeniorQuery($data);
        }
      }
    }



    // for ($i=0; $i < $countJunior; $i++) {
    //   $data['junior_id'] = $datajunior[$i];
    //   $this->User_Model->makeUserSeniorQuery($data);
    // }

     $this->session->set_flashdata('message', 'Your Submission Saved Succesfully into the Database');
     return redirect('User/makeUserSeniorPage');

    // if ($this->User_Model->makeUserSeniorQuery($data)) {
    //   $this->session->set_flashdata('message', 'Your Submission Saved Succesfully into the Database');
    // }
    //return redirect('User/makeUserSeniorPage');


  }
}
?>