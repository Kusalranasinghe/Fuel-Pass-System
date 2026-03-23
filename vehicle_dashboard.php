<?php
session_start();
include 'database.php';

if(!isset($_SESSION['vehicle_id'])){
    header("Location: login.php");
    exit;
}

$vehicle_id = $_SESSION['vehicle_id'];

// Fetch vehicle info + owner info + quota
$stmt = $conn->prepare("
    SELECT v.*, u.fname, u.lname, fq.max_litters
    FROM vehicles v
    JOIN users u ON v.u_id = u.id
    JOIN fuel_quota fq ON v.v_type = fq.v_type
    WHERE v.id = ?
");
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$vehicle = $stmt->get_result()->fetch_assoc();

// Calculate total fuel taken this week
$week_start = date('Y-m-d 00:00:00', strtotime('monday this week'));
$week_end   = date('Y-m-d 23:59:59', strtotime('sunday this week'));

$stmt2 = $conn->prepare("
    SELECT SUM(fuel_taken) as total_taken
    FROM fuel_transactions
    WHERE vehicle_id = ? AND trans_date BETWEEN ? AND ?
");
$stmt2->bind_param("iss", $vehicle_id, $week_start, $week_end);
$stmt2->execute();
$total_taken = $stmt2->get_result()->fetch_assoc()['total_taken'] ?? 0;

$remaining = $vehicle['max_litters'] - $total_taken;
?>

<h2>Vehicle Dashboard</h2>
<p><strong>Vehicle Number:</strong> <?php echo $vehicle['v_number']; ?></p>
<p><strong>Vehicle Type:</strong> <?php echo $vehicle['v_type']; ?></p>
<p><strong>Owner:</strong> <?php echo $vehicle['fname'].' '.$vehicle['lname']; ?></p>

<h3>Fuel Quota</h3>
<p>Max Weekly Fuel: <?php echo $vehicle['max_litters']; ?> liters</p>
<p>Fuel Taken This Week: <?php echo $total_taken; ?> liters</p>
<p>Remaining Fuel: <?php echo $remaining; ?> liters</p>

<?php if($remaining > 0): ?>
<form action="take_fuel.php" method="POST">
    <input type="number" name="fuel_amount" max="<?php echo $remaining; ?>" min="1" required placeholder="Enter liters">
    <button type="submit">Take Fuel</button>
    <button onclick="window.location.href='logout.php'">Logout</button>
</form>
<?php else: ?>
<p>You have reached your weekly fuel quota.</p>
<?php endif; ?>