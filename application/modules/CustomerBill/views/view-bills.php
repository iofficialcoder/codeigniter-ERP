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
                                <th>S.No.</th>
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

                            <?php 
                            $serialNumber = 1;
                            foreach ($customer_bills as $bill): ?>
                            <tr>
                                <td><?php echo $serialNumber++; ?></td>
                                <td><?php echo $bill['bill_no']; ?></td>
                                <td><?php echo $bill['customer_name']; ?></td>
                                <td><?php echo $bill['customer_mobile']; ?></td>
                                <td><?php echo $bill['address']; ?></td>
                                <td><?php echo '₹' . number_format($bill['total_amount'], 2); ?></td>
                                <td style="color:green"><?php echo '₹' . number_format($bill['advance_amount'], 2); ?>
                                </td>
                                <td style="color: red"><?php echo '₹' . number_format($bill['due_amount'], 2); ?></td>
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
                                    <a href="<?php echo base_url('CustomerBill/editBill/'.$bill['id']); ?>"
                                        class="btn btn-warning">Edit</a>
                                    <a href="<?php echo base_url('CustomerBill/deleteBill/'.$bill['id']); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this bill?');">Delete</a>
                                    <!-- <a href="<?php echo site_url('ItemMaster/viewCustomer/'.$bill['id']); ?>"
                                        class="btn btn-info">View</a> -->
                                    <a href="javascript:void(0);" class="btn btn-info view-bill-btn"
                                        data-bill='<?php echo json_encode($bill); ?>'>View</a>

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

<!-- Modal -->
<div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog" aria-labelledby="viewBillModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBillModalLabel">Bill Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Bill details will be loaded here -->
                <p><strong>Bill No:</strong> <span id="billNo"></span></p>
                <p><strong>Customer Name:</strong> <span id="customerName"></span></p>
                <p><strong>Mobile No.:</strong> <span id="customerMobile"></span></p>
                <p><strong>Address:</strong> <span id="address"></span></p>
                <p><strong>Total Amount:</strong> <span id="totalAmount"></span></p>
                <p><strong>Advance Amount:</strong> <span id="advanceAmount"></span></p>
                <p><strong>Due Amount:</strong> <span id="dueAmount"></span></p>
                <p><strong>Customer Image:</strong> <img id="customerImage" src="" alt="Customer Image" width="100"></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const viewButtons = document.querySelectorAll(".view-bill-btn");

    viewButtons.forEach(button => {
        button.addEventListener("click", function() {
            const billData = JSON.parse(this.getAttribute("data-bill"));

            // Populate modal fields
            document.getElementById("billNo").textContent = billData.bill_no;
            document.getElementById("customerName").textContent = billData.customer_name;
            document.getElementById("customerMobile").textContent = billData.customer_mobile;
            document.getElementById("address").textContent = billData.address;
            document.getElementById("totalAmount").textContent = '₹' + parseFloat(billData
                .total_amount).toFixed(2);
            document.getElementById("advanceAmount").textContent = '₹' + parseFloat(billData
                .advance_amount).toFixed(2);
            document.getElementById("dueAmount").textContent = '₹' + parseFloat(billData
                .due_amount).toFixed(2);

            const customerImage = document.getElementById("customerImage");
            if (billData.customer_image) {
                // Ensure base_url is included for the image source
                customerImage.src = `<?php echo base_url(); ?>${billData.customer_image}`;
                customerImage.style.display = "block";
            } else {
                customerImage.style.display = "none";
            }

            // Show modal
            $("#viewBillModal").modal("show");
        });
    });
});
</script>