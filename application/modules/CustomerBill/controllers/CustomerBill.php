<?php
class CustomerBill extends MY_Controller{
  public function __construct() {
    parent::__construct();
    $this->load->model('Customer_Model');
    $this->load->model('../../ItemMaster/models/Item_Model');  // Assuming you already have an Item_Model for fetching items
    $this->load->helper('form');
    $this->load->library('form_validation');
}

public function create()
{
    $this->load->model('../../ItemMaster/models/Item_model'); // Load the model
    $data['item_master'] = $this->Item_model->get_items(); // Fetch items from the model
    $this->load->view('CustomerBill', $data); // Pass data to view
}

public function addBillPage() {
  // Fetch items for the dropdown
  $data['item_master'] = $this->Item_Model->getAllItems();
  $data['content_view'] = 'CustomerBill/customer-bill';
  $this->templates->admin($data);
}

public function addBill() {
  $this->form_validation->set_rules('item_id', 'Item', 'required');
  $this->form_validation->set_rules('bill_no', 'Bill Number', 'required');
  $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

  if ($this->form_validation->run()) {
      // Retrieve item details
      $item_id = $this->input->post('item_id');
      $item = $this->Item_Model->getItemById($item_id);

      $data = [
          'item_id' => $item_id,
          'item_name' => $item['item_name'], // fetched from the database
          'bill_no' => $this->input->post('bill_no'),
          'booking_date' => $this->input->post('booking_date'),
          'customer_name' => $this->input->post('customer_name'),
          'customer_mobile' => $this->input->post('customer_mobile'),
          'address' => $this->input->post('address'),
          'total_amount' => $this->input->post('total_amount'),
          'advance_amount' => $this->input->post('advance_amount'),
          'due_amount' => $this->input->post('total_amount') - $this->input->post('advance_amount'),
      ];

      // Handle file upload
      if (!empty($_FILES['customer_image']['name'])) {
          $config['upload_path'] = './uploads/customers/';
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['file_name'] = time() . '_' . $_FILES['customer_image']['name'];

          $this->load->library('upload', $config);

          if ($this->upload->do_upload('customer_image')) {
              $uploadData = $this->upload->data();
              $data['customer_image'] = 'uploads/customers/' . $uploadData['file_name'];
          } else {
              $this->session->set_flashdata('message', $this->upload->display_errors());
              redirect('CustomerBill/addBillPage');
          }
      }

      // Insert the bill data
      if ($this->Customer_Model->addBill($data)) {
          $this->session->set_flashdata('message', 'Bill added successfully!');
      } else {
          $this->session->set_flashdata('message', 'Failed to add bill.');
      }
      redirect('CustomerBill/addBillPage');
  } else {
      $this->addBillPage();
  }
}

// Display the Edit Bill page
public function editBill($bill_id)
{
    // Fetch the bill details by ID
    $data['bill'] = $this->Customer_Model->getBillById($bill_id);
    
    // If the bill is not found, show an error or redirect
    if (empty($data['bill'])) {
        $this->session->set_flashdata('message', 'Bill not found.');
        return redirect('CustomerBill/viewBills');
    }
    
    // Fetch items for the dropdown
    $data['item_master'] = $this->Item_Model->getAllItems();
    
    // Load the edit view
    $data['content_view'] = 'CustomerBill/edit-bill';
    $this->templates->admin($data);
}

// Upload the customer image
public function upload_customer_image()
{
    $config['upload_path'] = './uploads/customers/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 2048;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('customer_image')) {
        $upload_data = $this->upload->data();
        return 'customers/' . $upload_data['file_name'];
    } else {
        return false;
    }
}

// Update the customer bill
public function updateBill($bill_id) {
  $this->load->model('Customer_Model');
  $this->load->model('Item_Model'); // Load Item Model

  // Set validation rules
  $this->form_validation->set_rules('item_id', 'Item', 'required');
  $this->form_validation->set_rules('bill_no', 'Bill Number', 'required');
  $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
  $this->form_validation->set_rules('customer_mobile', 'Customer Mobile No.', 'required');
  $this->form_validation->set_rules('address', 'Address', 'required');
  $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
  $this->form_validation->set_rules('advance_amount', 'Advance Amount', 'required');

  // Check if validation passes
  if ($this->form_validation->run() == FALSE) {
      // If validation fails, reload the form with validation errors
      $this->editBill($bill_id);
  } else {
      // Get the selected item ID
      $item_id = $this->input->post('item_id');
      
      // Fetch item name based on item_id
      $item = $this->Item_Model->getItemById($item_id);
      $item_name = $item ? $item['item_name'] : '';

      // Prepare data for update
      $data = [
          'item_id' => $item_id,
          'item_name' => $item_name, // Store the item_name as well
          'bill_no' => $this->input->post('bill_no'),
          'booking_date' => $this->input->post('booking_date'),
          'customer_name' => $this->input->post('customer_name'),
          'customer_mobile' => $this->input->post('customer_mobile'),
          'address' => $this->input->post('address'),
          'total_amount' => $this->input->post('total_amount'),
          'advance_amount' => $this->input->post('advance_amount'),
          'due_amount' => $this->input->post('due_amount'),
          'customer_image' => $this->input->post('existing_customer_image') // Handle image if needed
      ];

      // Handle the customer image upload if a new image is uploaded
      if (!empty($_FILES['customers']['name'])) {
          $image_path = $this->upload_customer_image();
          if ($image_path) {
              $data['customers'] = $image_path;
          }
      }

      // Update the bill in the database
      $updated = $this->Customer_Model->updateBill($bill_id, $data);

      if ($updated) {
          $this->session->set_flashdata('message', 'Bill updated successfully.');
      } else {
          $this->session->set_flashdata('message', 'Failed to update the bill.');
      }

      // Redirect to the view page or any other page as needed
      redirect('CustomerBill/viewBills');
  }
}


// public function addBill() {
//   $this->form_validation->set_rules('bill_no', 'Bill Number', 'required');
//   $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
//   // Add more validation rules as required

//   if ($this->form_validation->run()) {
//       $data = [
//           'item_name' => $this->input->post('item_name'),
//           'item_id' => $this->input->post('item_id'),
//           'bill_no' => $this->input->post('bill_no'),
//           'booking_date' => $this->input->post('booking_date'),
//           'customer_name' => $this->input->post('customer_name'),
//           'customer_mobile' => $this->input->post('customer_mobile'),
//           'address' => $this->input->post('address'),
//           'total_amount' => $this->input->post('total_amount'),
//           'advance_amount' => $this->input->post('advance_amount'),
//           'due_amount' => $this->input->post('total_amount') - $this->input->post('advance_amount'),
//       ];

//       // Handle customer image upload
//       if (!empty($_FILES['customer_image']['name'])) {
//           $config['upload_path'] = './uploads/customers/';
//           $config['allowed_types'] = 'jpg|jpeg|png|gif';
//           $config['file_name'] = time() . '_' . $_FILES['customer_image']['name'];
//           $this->load->library('upload', $config);

//           if ($this->upload->do_upload('customer_image')) {
//               $uploadData = $this->upload->data();
//               $data['customer_image'] = 'uploads/customers/' . $uploadData['file_name'];
//           } else {
//               $this->session->set_flashdata('message', $this->upload->display_errors());
//               redirect('CustomerBill/addBillPage');
//           }
//       }

//       if ($this->Customer_Model->addBill($data)) {
//           $this->session->set_flashdata('message', 'Bill added successfully!');
//       } else {
//           $this->session->set_flashdata('message', 'Failed to add bill.');
//       }
//       redirect('CustomerBill/addBillPage');
//   } else {
//       $this->addBillPage();
//   }
// }

  public function addUserPage(){
    $data['content_view'] = 'CustomerBill/customer-bill';
    $this->templates->admin($data);
  }

  public function addItemPage() {
    $data['content_view'] = 'CustomerBill/customer-bill';
    $this->templates->admin($data);
}
public function addItem() {
    $this->form_validation->set_rules('user_name', 'Item Name', 'required');

    if ($this->form_validation->run()) {
        $data = [
            'item_name' => $this->input->post('user_name'),
        ];

        // Handle file upload for item photo
        if (!empty($_FILES['item_photo']['name'])) {
            $config['upload_path'] = './uploads/items/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time() . '_' . $_FILES['item_photo']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('item_photo')) {
                $uploadData = $this->upload->data();
                $data['item_photo'] = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('CustomerBill/addItemPage');
            }
        }

        if ($this->Item_Model->addItem($data)) {
            $this->session->set_flashdata('message', 'Item added successfully!');
        } else {
            $this->session->set_flashdata('message', 'Failed to add item.');
        }
        redirect('CustomerBill/addItemPage');
    } else {
        $this->addItemPage();
    }
}

public function viewBills() {
    // Fetch all items from the database
    $data['customer_bills'] = $this->Customer_Model->getAllItems();

    // Load the view with the data
    $data['content_view'] = 'CustomerBill/view-bills'; // This will be the view you create
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
        return redirect('CustomerBill/viewItems');
    }
    
    // Load the edit view
    $data['content_view'] = 'CustomerBill/edit-item';
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
        $data = ['item_name' => $this->input->post('item_name')];

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
                redirect('CustomerBill/editItem/' . $item_id);
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

        redirect('CustomerBill/viewItems');
    } else {
        // Reload the edit page with validation errors
        $this->editItem($item_id);
    }
}

public function deleteBill($bill_id) {
    // Check if the item exists before trying to delete
    $bill = $this->Customer_Model->getItemById($bill_id);

    if ($bill) {
        // Delete the item from the database
        if ($this->Customer_Model->deleteBill($bill_id)) {
            // Delete the photo file if it exists
            $photo_path = './uploads/customers/' . $bill['customer_image'];
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
    return redirect('CustomerBill/viewBills');
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
    $data['content_view'] = 'CustomerBill/customer-bill';
    $this->templates->admin($data);
  }

  public function makeUserSeniorPage(){
    $data = null;
    $data['get_all_user'] = $this->User_Model->getAllUser($data);
    $data['content_view'] = 'CustomerBill/make-user-senior-view';
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
      return redirect('CustomerBill/addItemPage');
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



  public function save() {
    $this->load->model('Customer_Model');
    
    // Load form data
    $data = [
        'item_id' => $this->input->post('item_id'),
        'bill_no' => $this->input->post('bill_no'),
        'booking_date' => $this->input->post('booking_date'),
        'customer_name' => $this->input->post('customer_name'),
        'customer_mobile' => $this->input->post('customer_mobile'),
        'address' => $this->input->post('address'),
        'total_amount' => $this->input->post('total_amount'),
        'advance_amount' => $this->input->post('advance_amount'),
    ];
    $data['due_amount'] = $data['total_amount'] - $data['advance_amount'];

    // Handle file upload
    if (!empty($_FILES['customer_image']['name'])) {
        $config['upload_path'] = './uploads/customers/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('customer_image')) {
            $data['customer_image'] = $this->upload->data('file_name');
        }
    }

    $this->CustomerBillModel->insert_bill($data);
    redirect('customer_bill/success');
}
}
?>