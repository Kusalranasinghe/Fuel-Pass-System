<?php
include 'database.php';

if(!isset($_GET['vehicle_id'])){
    die("Invalid QR Code");
}

$vehicle_id = $_GET['vehicle_id'];

// Get vehicle + quota
$stmt = $conn->prepare("
    SELECT v.*, fq.max_litters
    FROM vehicles v
    JOIN fuel_quota fq ON v.v_type = fq.v_type
    WHERE v.id = ?
");
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$vehicle = $stmt->get_result()->fetch_assoc();

if(!$vehicle){
    die("Vehicle not found");
}
?>

<h2>🚗 Fuel Verification</h2>

<p><strong>Vehicle Number:</strong> <?php echo $vehicle['v_number']; ?></p>
<p><strong>Vehicle Type:</strong> <?php echo $vehicle['v_type']; ?></p>
<p><strong>Max Weekly Fuel:</strong> <?php echo $vehicle['max_litters']; ?> L</p>

<hr>

<form action="take_fuel.php" method="POST">
    <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
    <input type="number" name="fuel_amount" placeholder="Enter liters" required min="1" max="<?php echo $vehicle['max_litters']; ?>">
    <button type="submit" name="take_fuel">✅ Approve Fuel</button>
</form>