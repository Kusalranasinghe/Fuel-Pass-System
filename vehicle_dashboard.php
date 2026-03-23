<?php
session_start();
include 'database.php';

if(!isset($_SESSION['vehicle_id'])){
    header("Location: login.php");
    exit;
}

$vehicle_id = $_SESSION['vehicle_id'];

$stmt = $conn->prepare("
    SELECT v.*, u.fname, u.lname, u.nic, u.telephone, u.address
    FROM vehicles v
    JOIN users u ON v.u_id = u.id
    WHERE v.id = ?
");
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();
?>

<h2>Vehicle Dashboard</h2>
<h3>Vehicle Information:</h3>
<ul>
    <li>Vehicle Number: <?php echo $vehicle['v_number']; ?></li>
    <li>Vehicle Type: <?php echo $vehicle['v_type']; ?></li>
    <li>Chasi Number: <?php echo $vehicle['c_number']; ?></li>
    <li>Fuel Type: <?php echo $vehicle['fuel_type']; ?></li>
</ul>

<h3>Owner Information:</h3>
<ul>
    <li>Name: <?php echo $vehicle['fname'].' '.$vehicle['lname']; ?></li>
    <li>NIC: <?php echo $vehicle['nic']; ?></li>
    <li>Telephone: <?php echo $vehicle['telephone']; ?></li>
    <li>Address: <?php echo $vehicle['address']; ?></li>
</ul>