<?php
require_once 'config/database.php';
include 'includes/header.php';

$sql = "SELECT * FROM customers ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$customers = $stmt->fetchAll();
?>

<div class="card">
    <h2>👥 All Customers</h2>
    
    <?php if(count($customers) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Added On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $customer): ?>
            <tr>
                <td><?php echo $customer['id']; ?></td>
                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                <td><?php echo htmlspecialchars($customer['address']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($customer['created_at'])); ?></td>
                <td>
                    <a href="edit_customer.php?id=<?php echo $customer['id']; ?>" style="color: #667eea; text-decoration: none;">Edit</a>
                    <a href="delete_customer.php?id=<?php echo $customer['id']; ?>" style="color: #dc3545; text-decoration: none; margin-left: 10px;" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No customers found. <a href="add_customer.php">Add your first customer</a></p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>