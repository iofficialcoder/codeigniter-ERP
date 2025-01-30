<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Updata Item</h3>
                </div>

                <div class="box-body">

                    <?php echo form_open_multipart('ItemMaster/updateItem/' . $item['id']); ?>

                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <?php echo form_input(['name' => 'item_name', 'class' => 'form-control', 'id' => 'item_name', 'value' => $item['item_name'], 'placeholder' => 'Enter Item Name']); ?>
                    </div>

                    <div class="form-group">
                        <label for="item_price">Item Price</label>
                        <?php echo form_input(['type' => 'number', 'min' => '0.00', 'step' => '0.01', 'name' => 'item_price', 'class' => 'form-control', 'id' => 'item_price', 'value' => $item['item_price'], 'placeholder' => 'Enter Item Price']); ?>
                        <?php echo form_error('item_price', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="item_photo">Upload Item Photo</label>
                        <?php echo form_input(['type' => 'file', 'name' => 'item_photo', 'class' => 'form-control']); ?>
                        <img style="object-fit: cover;" src="<?php echo base_url($item['item_photo']); ?>" width="100"
                            height="100" alt="Current Image">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">


                    <?php echo form_submit('submit', 'Update Item', ['class' => 'btn btn-primary']); ?>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
</section>