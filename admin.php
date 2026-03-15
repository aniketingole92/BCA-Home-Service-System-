<?php
    include_once "scripts/checklogin.php";
    include_once "scripts/DB.php";
    include_once "include/header.php";

    if (!check("admin")) {
        header('Location: logout.php');
        exit();
    }

    // Determine which tab to show
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'bookings';

    include_once "msg/admin.php";
?>

<style>
    .admin-tabs {
        background-color: #f8f9fa;
        border-bottom: 3px solid #007bff;
        margin-bottom: 30px;
    }

    .admin-tabs a {
        color: #333;
        padding: 12px 20px;
        display: inline-block;
        text-decoration: none;
        border-bottom: 3px solid transparent;
        font-weight: 500;
    }

    .admin-tabs a.active {
        color: #007bff;
        border-bottom-color: #007bff;
    }

    .admin-tabs a:hover {
        background-color: #e9ecef;
    }

    .user-card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 10px;
        border-left: 4px solid #007bff;
    }

    .user-card strong {
        color: #007bff;
    }
</style>

<!-- TAB NAVIGATION -->
<div class="container" style="margin-top: 30px;">
    <div class="admin-tabs">
        <a href="admin.php?tab=bookings" class="<?php echo ($tab == 'bookings') ? 'active' : ''; ?>">
            📅 Manage Bookings
        </a>
        <a href="admin.php?tab=users" class="<?php echo ($tab == 'users') ? 'active' : ''; ?>">
            👥 Manage Users
        </a>
    </div>
</div>

<!-- BOOKINGS TAB -->
<?php if ($tab == 'bookings'): ?>
<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Bookings Management </h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Provider</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT b.*, p.name AS provider_name FROM bookings AS b 
                        LEFT JOIN providers AS p ON b.provider_id = p.id 
                        ORDER BY b.date DESC";
                $bookings = DB::query($sql)->fetchAll(PDO::FETCH_OBJ);
                
                foreach ($bookings as $booking):
                ?>
                <tr>
                    <td><strong>#<?= $booking->id; ?></strong></td>
                    <td><?= htmlspecialchars($booking->fname . ' ' . $booking->lname); ?></td>
                    <td><?= htmlspecialchars($booking->contact); ?></td>
                    <td><?= date('d-M-Y', strtotime($booking->date)); ?></td>
                    <td><?php echo isset($booking->time) ? date('h:i A', strtotime($booking->time)) : 'N/A'; ?></td>
                    <td><?= htmlspecialchars($booking->provider_name); ?></td>
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
                        <a class="btn btn-sm btn-info" href="admin_booking_details.php?id=<?= $booking->id; ?>">View</a>
                        <a class="btn btn-sm btn-warning" href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Approved">Approve</a>
                        <a class="btn btn-sm btn-success" href="scripts/admin_update_booking.php?id=<?= $booking->id; ?>&status=Completed">Complete</a>
                        <a class="btn btn-sm btn-danger" href="deletebooking.php?id=<?= $booking->id; ?>" onclick="return confirm('Delete this booking?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- USERS TAB -->
<?php elseif ($tab == 'users'): ?>
<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Registered Users </h2>
    
    <?php
    $sql = "SELECT u.*, COUNT(b.id) as booking_count FROM users u 
            LEFT JOIN bookings b ON u.id = b.user_id 
            GROUP BY u.id 
            ORDER BY u.created_at DESC";
    
    $users = DB::query($sql)->fetchAll(PDO::FETCH_OBJ);
    
    if (count($users) > 0):
    ?>
    <div style="margin-bottom: 60px;">
        <?php foreach ($users as $user): ?>
        <div class="user-card">
            <div class="row">
                <div class="col-md-8">
                    <strong>Name:</strong> <?= htmlspecialchars($user->full_name); ?> <br>
                    <strong>Email:</strong> <?= htmlspecialchars($user->email); ?> <br>
                    <strong>Phone:</strong> <?= htmlspecialchars($user->phone); ?> <br>
                    <strong>Address:</strong> <?= htmlspecialchars($user->address); ?> <br>
                    <strong>Total Bookings:</strong> <span class="badge badge-primary"><?= $user->booking_count; ?></span> <br>
                    <strong>Member Since:</strong> <?= date('d-M-Y', strtotime($user->created_at)); ?>
                </div>
                <div class="col-md-4 text-right">
                    <a href="admin_user_profile.php?id=<?= $user->id; ?>" class="btn btn-info btn-sm">View Profile</a>
                    <a href="admin_user_bookings.php?id=<?= $user->id; ?>" class="btn btn-primary btn-sm">View Bookings</a>
                    <a href="scripts/admin_edit_user.php?id=<?= $user->id; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="scripts/admin_delete_user.php?id=<?= $user->id; ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this user? All their bookings will be deleted.');">Delete</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        No registered users found.
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
