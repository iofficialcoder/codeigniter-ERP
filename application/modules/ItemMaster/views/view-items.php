<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Display success or error message -->
            <?php $msg = $this->session->flashdata('message'); if (!empty($msg)): ?>
            <div class="alert alert-dismissible alert-success">
                <?php echo $msg; ?>
            </div>
            <?php endif; ?>

            <!-- Display the list of items -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">View Items</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Item Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo $item['item_name']; ?></td>
                                <!-- <td><?php echo $item['item_price']; ?></td> -->
                                <td style="color: green"><?php echo '₹' . number_format($item['item_price'], 2); ?></td>
                                <td>
                                    <?php if (!empty($item['item_photo'])): ?>
                                    <img style="object-fit: cover;" src="<?php echo base_url($item['item_photo']); ?>"
                                        alt="<?php echo $item['item_name']; ?>" width="100" height="100">
                                    <?php else: ?>
                                    No Photo
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Add buttons for Edit/Delete if needed -->
                                    <a href="<?php echo site_url('ItemMaster/editItem/'.$item['id']); ?>"
                                        class="btn btn-warning">Edit</a>
                                    <a href="<?php echo site_url('ItemMaster/deleteItem/'.$item['id']); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    <a href="<?php echo site_url('ItemMaster/viewItem/'.$item['id']); ?>"
                                        class="btn btn-info">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3">No items found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>