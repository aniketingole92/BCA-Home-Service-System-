<?php

include_once "./include/header.php";
include_once "./scripts/DB.php";
require_once "./scripts/session.php";

if (!isset($_GET['provider'])) {
    header('Location: index.php');
    exit();
}

$provider = DB::query("SELECT * FROM providers WHERE id=?", [$_GET['provider']])->fetch(PDO::FETCH_OBJ);

if ($provider === false) {
    header('Location: index.php');
    exit();
}


// Check if user is logged in
$is_logged_in = isset($_SESSION['user']) && $_SESSION['user_type'] == 'customer';
$user = $is_logged_in ? $_SESSION['user'] : null;

?>

<div class="container" style="margin-top: 30px;">
    <div class="card text-center">
        <div class="card-header">
            <h3>Details about <?= $provider->name; ?></h3>
        </div>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col">
                    <img style="height: 250px"
                        src="images/<?= $provider->photo; ?>">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td>
                        <?= $provider->name; ?>
                    </td>
                    <th>Profession</th>
                    <td>
                        <?= $provider->profession;?>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <?= $provider->adder1; ?>,
                        <?= $provider->adder2; ?>
                    </td>
                    <th>City</th>
                    <td>
                        <?= $provider->city; ?>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>


<div class="container" style="margin-bottom: 60px;margin-top: 20px;">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3 class="text-center">Book Appointment from <?= $provider->name; ?>
                </h3>
            </div>
            <hr>

            <form action="scripts/bookhall.php" method="post">
                <input type="hidden" name="provider"
                    value="<?= $provider->id; ?>">
                
                <?php if ($is_logged_in): ?>
                <div class="alert alert-success">
                    <strong>Welcome back, <?php echo htmlspecialchars($user->full_name); ?>!</strong> 
                    Your information will be automatically saved.
                </div>
                
                <div class="form-group">
                    <label for="">First Name</label>
                    <input id="fname" name="fname" type="text" class="form-control" 
                           value="<?php echo htmlspecialchars(explode(' ', $user->full_name)[0]); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="">Last Name</label>
                    <input id="lname" name="lname" type="text" class="form-control" 
                           value="<?php echo htmlspecialchars(end(explode(' ', $user->full_name))); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input id="contact" name="contact" type="text" class="form-control" 
                           value="<?php echo htmlspecialchars($user->phone); ?>"
                           minlength="10" maxlength="10"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" 
                           required>
                </div>

                <div class="form-group">
                    <label for="">Address</label>
                    <input id="adder" name="adder" type="text" class="form-control" 
                           value="<?php echo htmlspecialchars($user->address); ?>"
                           maxlength="255" required>
                </div>

                <?php else: ?>
                
                <div class="alert alert-info">
                    <strong>Note:</strong> <a href="login.php?type=user">Login as a customer</a> to auto-fill your information.
                </div>
                
                <div class="form-group">
                    <label for="">First Name</label>
                    <input id="fname" name="fname" type="text" class="form-control" placeholder="First Name" required>
                </div>

                <div class="form-group">
                    <label for="">Last Name</label>
                    <input id="lname" name="lname" type="text" class="form-control" placeholder="Last Name" required>
                </div>

                <div class="form-group">
                    <label for="">Contact No.</label>
                    <input id="contact" name="contact" type="text" class="form-control" placeholder="Contact No."
                        minlength="10" maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                </div>

                <div class="form-group">
                    <label for="">Address</label>
                    <input id="adder" name="adder" type="text" class="form-control" placeholder="Address"
                        maxlength="255" required>
                </div>

                <?php endif; ?>

                <div class="form-group">
                    <label for="">Date</label>
                    <input class="form-control" type="date" name="date" id="date" 
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Time</label>
                    <input class="form-control" type="time" name="time" id="time" required>
                </div>

                <div class="form-group">
                    <label for="">Payment Mode</label>
                    <select class="form-control" name="payment" id="payment" required>
                        <option value="cash">Cash</option>
                        <option value="card">Debit Card</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Problem / Additional Notes</label>
                    <textarea id="queries" name="queries" class="form-control" maxlength="255"
                        placeholder="Any specific requirements or queries..."></textarea>
                </div>

                <button style="margin-top: 30px" class="btn btn-block btn-primary" type="submit" name="book"
                    id="book">Book Appointment
                    </button>

                    
            </form>

        </div>
    </div>
</div>

<?php include_once "include/footer.php";
<?php include_once "msg/booking.php";