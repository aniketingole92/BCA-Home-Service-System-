<?php
require_once 'config/database.php';
include 'includes/header.php';

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_customers FROM customers");
$total_customers = $stmt->fetch()['total_customers'];

$stmt = $pdo->query("SELECT COUNT(*) as total_requirements FROM requirements");
$total_requirements = $stmt->fetch()['total_requirements'];

$stmt = $pdo->query("SELECT COUNT(*) as pending FROM requirements WHERE status = 'Pending'");
$pending = $stmt->fetch()['pending'];

$stmt = $pdo->query("SELECT COUNT(*) as completed FROM requirements WHERE status = 'Completed'");
$completed = $stmt->fetch()['completed'];

// Get recent requirements
$stmt = $pdo->query("
    SELECT r.*, c.name as customer_name 
    FROM requirements r 
    JOIN customers c ON r.customer_id = c.id 
    ORDER BY r.created_at DESC 
    LIMIT 5
");
$recent_requirements = $stmt->fetchAll();
?>

<div class="card">
    <h2>📊 Dashboard</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 10px;">Total Customers</h3>
            <h2 style="font-size: 36px;"><?php echo $total_customers; ?></h2>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 10px;">Total Requirements</h3>
            <h2 style="font-size: 36px;"><?php echo $total_requirements; ?></h2>
        </div>
        
        <div style="background: linear-gradient(135deg, #ffd166 0%, #ffb347 100%); color: white; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 10px;">Pending</h3>
            <h2 style="font-size: 36px;"><?php echo $pending; ?></h2>
        </div>
        
        <div style="background: linear-gradient(135deg, #6b8cff 0%, #4a6bff 100%); color: white; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 10px;">Completed</h3>
            <h2 style="font-size: 36px;"><?php echo $completed; ?></h2>
        </div>
    </div>
    
    <h3 style="margin: 30px 0 20px;">Recent Requirements</h3>
    
    <?php if(count($recent_requirements) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recent_requirements as $req): ?>
            <tr>
                <td><?php echo htmlspecialchars($req['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($req['product_name']); ?></td>
                <td><?php echo $req['quantity']; ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $req['status'])); ?>">
                        <?php echo $req['status']; ?>
                    </span>
                </td>
                <td><?php echo date('d-m-Y', strtotime($req['requirement_date'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No recent requirements found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>