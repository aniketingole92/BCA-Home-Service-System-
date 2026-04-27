<?php 
include_once "./scripts/checklogin.php";
include_once "./scripts/DB.php";
include_once "./include/header.php";

if (!check("admin")) {
    header('Location: logout.php');
    exit();
}

// Get user ID from URL
if (!isset($_GET['id'])) {
    header('Location: admin.php?tab=users');
    exit();
}

$user_id = $_GET['id'];

// Fetch user details
$stmt = DB::query("SELECT * FROM users WHERE id = ?", [$user_id]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if ($user === false) {
    header('Location: admin.php?tab=users&msg=not_found');
    exit();
}

// Fetch all bookings for this user
$stmt = DB::query(
    "SELECT b.*, p.name as provider_name, p.profession FROM bookings b 
     JOIN providers p ON b.provider_id = p.id 
     WHERE b.user_id = ? 
     ORDER BY b.date DESC",
    [$user_id]
);
$bookings = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3>Bookings for <?= htmlspecialchars($user->full_name); ?></h3>
            <p class="text-muted">Email: <?= htmlspecialchars($user->email); ?> | Phone: <?= htmlspecialchars($user->phone); ?></p>
            <hr>
        </div>
    </div>

    <?php if (count($bookings) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Service Provider</th>
                    <th>Service Type</th>
                    <th>Booking Date</th>
                    <th>Time</th>
                    <th>Contact</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><strong>#<?= $booking->id; ?></strong></td>
                    <td><?= htmlspecialchars($booking->provider_name); ?></td>
                    <td><?= htmlspecialchars($booking->profession); ?></td>
                    <td><?= date('d-M-Y', strtotime($booking->date)); ?></td>
                    <td><?php echo isset($booking->time) ? date('h:i A', strtotime($booking->time)) : 'N/A'; ?></td>
                    <td><?= htmlspecialchars($booking->contact); ?></td>
                    <td><?= ucfirst($booking->payment); ?></td>
                    <td>
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
                    </td>
                    <td>
                        <a href="admin_booking_details.php?id=<?= $booking->id; ?>" class="btn btn-sm btn-info">View</a>
                        <a href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Completed" class="btn btn-sm btn-success">Complete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        <p>This user has no bookings yet.</p>
    </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="admin_user_profile.php?id=<?= $user->id; ?>" class="btn btn-primary">Back to Profile</a>
        <a href="admin.php?tab=users" class="btn btn-secondary">Back to Users</a>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
