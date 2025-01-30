<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Item</h3>
                </div>
                <?php echo form_open_multipart('ItemMaster/addItem'); ?>
                <div class="box-body">
                    <?php $msg = $this->session->flashdata('message'); if(!empty($msg)): ?>
                    <div class="alert alert-dismissible alert-success">
                        <?php echo $msg; ?>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="user_name">Item Name</label>
                        <?php echo form_input(['name' => 'user_name', 'class' => 'form-control', 'id' => 'user_name', 'placeholder' => 'Enter Item Name']); ?>
                        <?php echo form_error('user_name', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="item_price">Item Price</label>
                        <?php echo form_input(['type' => 'number', 'min' => '0.00', 'step' => '0.01', 'name' => 'item_price', 'class' => 'form-control', 'id' => 'item_price', 'placeholder' => 'Enter Item Price']); ?>
                        <?php echo form_error('item_price', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="item_photo">Upload Item Photo</label>
                        <?php echo form_input(['type' => 'file', 'name' => 'item_photo', 'class' => 'form-control', 'id' => 'item_photo']); ?>
                        <?php echo form_error('item_photo', '<div class="text-danger">', '</div>'); ?>
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