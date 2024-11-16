<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Display success or error message -->
            <?php $msg = $this->session->flashdata('message'); if (!empty($msg)): ?>
            <div class="alert alert-dismissible alert-success">
                <?php echo $msg; ?>
            </div>
            <?php endif; ?>

            <!-- Display the list of customer bills -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Customer Bills</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bill No.</th>
                                <th>Customer Name</th>
                                <th>Mobile No.</th>
                                <th>Address</th>
                                <th>Total Amount</th>
                                <th>Advance Amount</th>
                                <th>Due Amount</th>
                                <th>Customer Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($customer_bills)): ?>
                            <?php foreach ($customer_bills as $bill): ?>
                            <tr>
                                <td><?php echo $bill['bill_no']; ?></td>
                                <td><?php echo $bill['customer_name']; ?></td>
                                <td><?php echo $bill['customer_mobile']; ?></td>
                                <td><?php echo $bill['address']; ?></td>
                                <td><?php echo $bill['total_amount']; ?></td>
                                <td style="color:green"><?php echo $bill['advance_amount']; ?></td>
                                <td style="color: red"><?php echo $bill['due_amount']; ?></td>
                                <td>
                                    <?php if (!empty($bill['customer_image'])): ?>
                                    <img style="object-fit: cover;"
                                        src="<?php echo base_url($bill['customer_image']); ?>"
                                        alt="<?php echo $bill['customer_name']; ?>" width="100" height="100">
                                    <?php else: ?>
                                    No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('CustomerBill/editBill/'.$bill['id']); ?>"
                                        class="btn btn-warning">Edit</a>
                                    <a href="<?php echo site_url('CustomerBill/deleteBill/'.$bill['id']); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this bill?');">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="9">No bills found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>