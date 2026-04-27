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

<div class="container" style="margin-top: 30px; max-width: 700px; margin-bottom: 60px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3 class="text-center">Edit User Profile</h3>
            </div>
            <hr>

            <?php 
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                if ($msg == 'success') {
                    echo '<div class="alert alert-success alert-dismissible fade show">
                            User updated successfully! <a href="admin.php?tab=users">Back to Users</a>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                          </div>';
                } elseif ($msg == 'invalid_phone') {
                    echo '<div class="alert alert-danger alert-dismissible fade show">
                            Invalid phone number.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                          </div>';
                } elseif ($msg == 'failed') {
                    echo '<div class="alert alert-danger alert-dismissible fade show">
                            Failed to update user. Please try again.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                          </div>';
                }
            }
            ?>

            <form action="scripts/admin_edit_user.php" method="post">
                <input type="hidden" name="user_id" value="<?= $user->id; ?>">

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" name="full_name" type="text" class="form-control" 
                           value="<?= htmlspecialchars($user->full_name); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" class="form-control" 
                           value="<?= htmlspecialchars($user->email); ?>" 
                           disabled>
                    <small class="text-muted">Email cannot be changed</small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone" name="phone" type="text" class="form-control" 
                           value="<?= htmlspecialchars($user->phone); ?>" 
                           minlength="10" maxlength="10"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                           required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3" required>
<?= htmlspecialchars($user->address); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name="update_user">Save Changes</button>
                    <a href="admin_user_profile.php?id=<?= $user->id; ?>" class="btn btn-secondary btn-block" style="margin-top: 5px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
