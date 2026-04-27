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

?>

<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>User Profile</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Full Name</th>
                            <td><?= htmlspecialchars($user->full_name); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user->email); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= htmlspecialchars($user->phone); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?= htmlspecialchars($user->address); ?></td>
                        </tr>
                        <tr>
                            <th>Member Since</th>
                            <td><?= date('d-M-Y H:i', strtotime($user->created_at)); ?></td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td><?= date('d-M-Y H:i', strtotime($user->updated_at)); ?></td>
                        </tr>
                    </table>
                    <hr>
                    <a href="admin_edit_user.php?id=<?= $user->id; ?>" class="btn btn-warning btn-sm btn-block">Edit User</a>
                    <a href="admin_user_bookings.php?id=<?= $user->id; ?>" class="btn btn-info btn-sm btn-block" style="margin-top: 5px;">View Bookings</a>
                    <a href="scripts/admin_delete_user.php?id=<?= $user->id; ?>" class="btn btn-danger btn-sm btn-block" style="margin-top: 5px;" 
                       onclick="return confirm('Are you sure? This will delete all user data and bookings.');">Delete User</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <?php
                    // Fetch booking statistics
                    $stats = DB::query(
                        "SELECT status, COUNT(*) as count FROM bookings WHERE user_id = ? GROUP BY status",
                        [$user_id]
                    )->fetchAll(PDO::FETCH_OBJ);
                    
                    $total = 0;
                    $pending = 0;
                    $approved = 0;
                    $completed = 0;
                    $cancelled = 0;
                    
                    foreach ($stats as $stat) {
                        $total += $stat->count;
                        if ($stat->status == 'Pending') $pending = $stat->count;
                        elseif ($stat->status == 'Approved') $approved = $stat->count;
                        elseif ($stat->status == 'Completed') $completed = $stat->count;
                        elseif ($stat->status == 'Cancelled') $cancelled = $stat->count;
                    }
                    ?>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <h4><?= $total; ?></h4>
                            <small>Total Bookings</small>
                        </div>
                        <div class="col-4">
                            <h4 style="color: #ffc107;"><?= $pending; ?></h4>
                            <small>Pending</small>
                        </div>
                        <div class="col-4">
                            <h4 style="color: #28a745;"><?= $completed; ?></h4>
                            <small>Completed</small>
                        </div>
                    </div>
                    
                    <hr style="margin: 15px 0;">
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 style="color: #17a2b8;"><?= $approved; ?></h4>
                            <small>Approved</small>
                        </div>
                        <div class="col-4">
                            <h4 style="color: #dc3545;"><?= $cancelled; ?></h4>
                            <small>Cancelled</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
