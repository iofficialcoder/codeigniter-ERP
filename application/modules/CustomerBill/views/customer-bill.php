<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Customer Bill</h3>
                </div>
                <?php echo form_open_multipart('CustomerBill/addBill'); ?>
                <div class="box-body">
                    <?php $msg = $this->session->flashdata('message'); if(!empty($msg)): ?>
                    <div class="alert alert-dismissible alert-success">
                        <?php echo $msg; ?>
                    </div>
                    <?php endif; ?>

                    <div class="form-group col-md-6">
                        <label for="user_name">Select Item</label>
                        <select name="item_id" class="form-control">
                            <!-- Populate with items from the database -->
                            <option value="">Select Item Any One</option>
                            <?php foreach ($item_master as $item): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['item_name']; ?></option>
                            <?php endforeach; ?>


                        </select>
                        <?php echo form_error('item_id', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="bill_no">Bill Number</label>
                        <?php echo form_input(['name' => 'bill_no', 'class' => 'form-control', 'placeholder' => 'Enter Bill Number']); ?>
                        <?php echo form_error('bill_no', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="booking_date">Booking Date</label>
                        <?php echo form_input(['type' => 'date', 'name' => 'booking_date', 'class' => 'form-control']); ?>
                        <?php echo form_error('booking_date', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_name">Customer Name</label>
                        <?php echo form_input(['name' => 'customer_name', 'class' => 'form-control', 'placeholder' => 'Enter Customer Name']); ?>
                        <?php echo form_error('customer_name', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_mobile">Customer Mobile No.</label>
                        <?php echo form_input(['name' => 'customer_mobile', 'class' => 'form-control', 'placeholder' => 'Enter Mobile Number']); ?>
                        <?php echo form_error('customer_mobile', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <?php echo form_textarea(['name' => 'address', 'class' => 'form-control', 'placeholder' => 'Enter Address', 'rows' => 1]); ?>
                        <?php echo form_error('address', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="total_amount">Total Amount</label>
                        <?php echo form_input(['name' => 'total_amount', 'class' => 'form-control', 'placeholder' => 'Enter Total Amount', 'id' => 'total_amount']); ?>
                        <?php echo form_error('total_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="advance_amount">Advance Amount</label>
                        <?php echo form_input(['name' => 'advance_amount', 'class' => 'form-control', 'placeholder' => 'Enter Advance Amount', 'id' => 'advance_amount']); ?>
                        <?php echo form_error('advance_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="due_amount">Due Amount</label>
                        <?php echo form_input(['name' => 'due_amount', 'class' => 'form-control', 'placeholder' => 'Due Amount', 'readonly' => true, 'id' => 'due_amount']); ?>
                        <?php echo form_error('due_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_image">Upload Customer Image</label>
                        <?php echo form_input(['type' => 'file', 'name' => 'customer_image', 'class' => 'form-control']); ?>
                        <?php echo form_error('customer_image', '<div class="text-danger">', '</div>'); ?>
                    </div>
                </div>

                <div class="box-footer">
                    <?php echo form_submit('', 'Add Item', ['class' => 'btn btn-primary']); ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<script>
// Auto-calculate Due Amount
document.getElementById('total_amount').addEventListener('input', calculateDueAmount);
document.getElementById('advance_amount').addEventListener('input', calculateDueAmount);

function calculateDueAmount() {
    const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
    const advanceAmount = parseFloat(document.getElementById('advance_amount').value) || 0;
    document.getElementById('due_amount').value = totalAmount - advanceAmount;
}
</script>