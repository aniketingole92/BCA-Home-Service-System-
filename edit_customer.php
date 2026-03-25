<?php
require_once 'config/database.php';
include 'includes/header.php';

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "UPDATE customers SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$name, $email, $phone, $address, $id])) {
        $success = "Customer updated successfully!";
    } else {
        $error = "Error updating customer!";
    }
}

// Get customer data
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

if(!$customer) {
    header('Location: view_customers.php');
    exit;
}
?>

<div class="card">
    <h2>✏️ Edit Customer</h2>
    
    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Customer Name *</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($customer['address']); ?></textarea>
        </div>
        
        <button type="submit" class="btn">Update Customer</button>
        <a href="view_customers.php" style="margin-left: 10px;">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>