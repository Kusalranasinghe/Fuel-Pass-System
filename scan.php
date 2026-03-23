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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fuel Verification</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #00bfa5, #1de9b6);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.container {
    background: #fff;
    padding: 30px 35px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    max-width: 400px;
    width: 100%;
    text-align: center;
}
h2 {
    color: #00796b;
    margin-bottom: 25px;
}
p {
    font-size: 16px;
    margin: 8px 0;
}
hr {
    border: none;
    border-top: 1px solid #ccc;
    margin: 20px 0;
}
input[type="number"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}
input[type="number"]:focus {
    border-color: #00796b;
    box-shadow: 0 0 5px #00796b;
    outline: none;
}
button {
    width: 100%;
    padding: 12px;
    background-color: #00796b;
    color: #fff;
    font-size: 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}
button:hover {
    background-color: #004d40;
    transform: scale(1.05);
}
a.back {
    display: inline-block;
    margin-top: 15px;
    color: #00796b;
    text-decoration: none;
}
a.back:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<div class="container">
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

<a class="back" href="vehicle_dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>