<?php
require_once 'config/database.php';
include 'includes/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$name, $email, $phone, $address])) {
        $success = "Customer added successfully!";
    } else {
        $error = "Error adding customer!";
    }
}
?>

<div class="card">
    <h2>➕ Add New Customer</h2>
    
    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Customer Name *</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn">Add Customer</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>