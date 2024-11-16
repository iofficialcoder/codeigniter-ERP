<?php
class Dashboard extends MY_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('User/User_Model');
    $this->load->model('ToDo/ToDo_Model');
  }

  public function index(){
    $data = null;
    $data['get_all_user'] = $this->User_Model->getAllUser($data);
    $data['get_all_senior'] = $this->User_Model->getAllSenior($data);
    $data['content_view'] = 'Dashboard/dashboard-view';
    $data['countEmployees'] = $this->User_Model->countEmployees();
    $data['countTasks'] = $this->ToDo_Model->countTasks();
    $data['countTasksDone'] = $this->ToDo_Model->countTasksDone();
    $data['countTasksPending'] = $this->ToDo_Model->countTasksPending();
    $data['countTasksAssigned'] = $this->ToDo_Model->countTasksAssigned();
    $this->templates->admin($data);
  }
}
?>
