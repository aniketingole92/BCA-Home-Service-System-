<?php 
include_once "./scripts/checklogin.php";
include_once "./scripts/DB.php";
include_once "./include/header.php";

if (!check("admin")) {
    header('Location: logout.php');
    exit();
}

// Get booking ID from URL
if (!isset($_GET['id'])) {
    header('Location: admin.php?tab=bookings');
    exit();
}

$booking_id = $_GET['id'];

// Fetch booking details
$stmt = DB::query(
    "SELECT b.*, p.name as provider_name, p.profession, u.full_name as user_name, u.email FROM bookings b 
     LEFT JOIN providers p ON b.provider_id = p.id 
     LEFT JOIN users u ON b.user_id = u.id 
     WHERE b.id = ?",
    [$booking_id]
);
$booking = $stmt->fetch(PDO::FETCH_OBJ);

if ($booking === false) {
    header('Location: admin.php?tab=bookings&msg=not_found');
    exit();
}

?>

<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Booking #<?= $booking->id; ?> - Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">CUSTOMER INFORMATION</h6>
                            <p>
                                <strong>Name:</strong> <?= htmlspecialchars($booking->fname . ' ' . $booking->lname); ?><br>
                                <strong>Email:</strong> <?= htmlspecialchars($booking->email ?? 'N/A'); ?><br>
                                <strong>Phone:</strong> <?= htmlspecialchars($booking->contact); ?><br>
                                <strong>Address:</strong> <?= htmlspecialchars($booking->adder); ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">SERVICE PROVIDER</h6>
                            <p>
                                <strong>Provider:</strong> <?= htmlspecialchars($booking->provider_name); ?><br>
                                <strong>Service Type:</strong> <?= htmlspecialchars($booking->profession); ?><br>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">BOOKING DETAILS</h6>
                            <p>
                                <strong>Date:</strong> <?= date('d-M-Y', strtotime($booking->date)); ?><br>
                                <strong>Time:</strong> <?php echo isset($booking->time) ? date('h:i A', strtotime($booking->time)) : 'N/A'; ?><br>
                                <strong>Payment Mode:</strong> <?= ucfirst($booking->payment); ?><br>
                                <strong>Status:</strong> 
                                <?php 
                                $status = isset($booking->status) ? $booking->status : 'Pending';
                                if ($status == 'Pending') {
                                    echo '<span class="badge badge-warning">' . $status . '</span>';
                                } elseif ($status == 'Approved') {
                                    echo '<span class="badge badge-info">' . $status . '</span>';
                                } elseif ($status == 'Completed') {
                                    echo '<span class="badge badge-success">' . $status . '</span>';
                                } elseif ($status == 'Cancelled') {
                                    echo '<span class="badge badge-danger">' . $status . '</span>';
                                }
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">ADDITIONAL INFORMATION</h6>
                            <p>
                                <strong>Queries/Notes:</strong><br>
                                <span style="white-space: pre-wrap;"><?= htmlspecialchars($booking->queries ?? 'None'); ?></span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted">ACTIONS</h6>
                    <div class="btn-group btn-block" role="group">
                        <a href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Pending" class="btn btn-warning">Mark Pending</a>
                        <a href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Approved" class="btn btn-info">Approve</a>
                        <a href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Completed" class="btn btn-success">Complete</a>
                        <a href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Cancelled" class="btn btn-danger">Cancel</a>
                    </div>

                    <div style="margin-top: 15px;">
                        <a href="admin.php?tab=bookings" class="btn btn-secondary btn-block">Back to Bookings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
