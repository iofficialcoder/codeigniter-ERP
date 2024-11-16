<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Updata Customer Bill</h3>
                </div>

                <div class="box-body">

                    <?php echo form_open_multipart('CustomerBill/updateBill/' . $bill['id']); ?>

                    <div class="form-group col-md-6">
                        <label for="user_name">Select Item</label>
                        <select name="item_id" class="form-control">
                            <option value="">Select Item</option>
                            <?php foreach ($item_master as $item): ?>
                            <option value="<?php echo $item['id']; ?>"
                                <?php echo ($bill['item_id'] == $item['id']) ? 'selected' : ''; ?>>
                                <?php echo $item['item_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('item_id', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="bill_no">Bill Number</label>
                        <?php echo form_input(['name' => 'bill_no', 'class' => 'form-control', 'value' => $bill['bill_no'], 'placeholder' => 'Enter Bill Number']); ?>
                        <?php echo form_error('bill_no', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="booking_date">Booking Date</label>
                        <?php echo form_input(['type' => 'date', 'name' => 'booking_date', 'class' => 'form-control', 'value' => $bill['booking_date']]); ?>
                        <?php echo form_error('booking_date', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_name">Customer Name</label>
                        <?php echo form_input(['name' => 'customer_name', 'class' => 'form-control', 'placeholder' => 'Enter Customer Name', 'value' => $bill['customer_name']]); ?>
                        <?php echo form_error('customer_name', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_mobile">Customer Mobile No.</label>
                        <?php echo form_input(['name' => 'customer_mobile', 'class' => 'form-control', 'placeholder' => 'Enter Mobile Number', 'value' => $bill['customer_mobile']]); ?>
                        <?php echo form_error('customer_mobile', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <?php echo form_textarea(['name' => 'address', 'class' => 'form-control', 'placeholder' => 'Enter Address', 'rows' => 1, 'value' => $bill['address']]); ?>
                        <?php echo form_error('address', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="total_amount">Total Amount</label>
                        <?php echo form_input(['name' => 'total_amount', 'class' => 'form-control', 'placeholder' => 'Enter Total Amount', 'id' => 'total_amount', 'value' => $bill['total_amount'],]); ?>
                        <?php echo form_error('total_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="advance_amount">Advance Amount</label>
                        <?php echo form_input(['name' => 'advance_amount', 'class' => 'form-control', 'placeholder' => 'Enter Advance Amount', 'id' => 'advance_amount', 'value' => $bill['advance_amount'],]); ?>
                        <?php echo form_error('advance_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="due_amount">Due Amount</label>
                        <?php echo form_input(['name' => 'due_amount', 'class' => 'form-control', 'placeholder' => 'Due Amount', 'readonly' => true, 'id' => 'due_amount', 'value' => $bill['due_amount'],]); ?>
                        <?php echo form_error('due_amount', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="customer_image">Customer Image</label>
                        <input type="file" name="customer_image" class="form-control">
                        <input type="hidden" name="existing_customer_image"
                            value="<?php echo $bill['customer_image']; ?>">

                        <img style="object-fit: cover;" src="<?php echo base_url($bill['customer_image']); ?>"
                            width="100" height="100" alt="Current Image">
                    </div>


                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Update Bill</button>

                    <?php echo form_close(); ?>


                </div>
            </div>
        </div>
    </div>
</section>