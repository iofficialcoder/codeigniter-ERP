<?php
class CustomerBill extends MY_Controller
{
  public function __construct()
  {
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

  public function addBillPage()
  {
    // Fetch items for the dropdown
    $data['item_master']  = $this->Item_Model->getAllItems();
    $data['content_view'] = 'CustomerBill/customer-bill';
    $this->templates->admin($data);
  }

  public function addBill()
  {
    $this->form_validation->set_rules('item_id', 'Item', 'required');
    $this->form_validation->set_rules('bill_no', 'Bill Number', 'required');
    $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

    if ($this->form_validation->run()) {
      // Retrieve item details
      $item_id = $this->input->post('item_id');
      $item    = $this->Item_Model->getItemById($item_id);

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
        $config['upload_path']   = './uploads/customers/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name']     = time() . '_' . $_FILES['customer_image']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('customer_image')) {
          $uploadData             = $this->upload->data();
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
    $config['upload_path']   = './uploads/customers/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size']      = 2048;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('customer_image')) {
      $upload_data = $this->upload->data();
      return 'customers/' . $upload_data['file_name'];
    } else {
      return false;
    }
  }

  // Update the customer bill
  public function updateBill($bill_id)
  {
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
      $item      = $this->Item_Model->getItemById($item_id);
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

  public function viewBills()
  {
    // Fetch all items from the database
    $data['customer_bills'] = $this->Customer_Model->getAllItems();

    // Load the view with the data
    $data['content_view'] = 'CustomerBill/view-bills'; // This will be the view you create
    $this->templates->admin($data);
  }

  public function deleteBill($bill_id)
  {
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

}
?>