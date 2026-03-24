<?php
session_start();
include 'database.php';

$message = "";
$type = "";

if(isset($_POST['take_fuel'])){
    $vehicle_id = $_POST['vehicle_id'];
    $fuel_amount = $_POST['fuel_amount'];

    // Get vehicle quota
    $stmt = $conn->prepare("SELECT v.*, fq.max_litters FROM vehicles v JOIN fuel_quota fq ON v.v_type=fq.v_type WHERE v.id=?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $vehicle = $stmt->get_result()->fetch_assoc();

    if(!$vehicle){
        $message = "❌ Vehicle not found";
        $type = "error";
    } else {
        // Weekly usage
        $stmt2 = $conn->prepare("SELECT SUM(fuel_amount) AS total FROM fuel_log WHERE vehicle_id=? AND WEEK(log_date)=WEEK(NOW())");
        $stmt2->bind_param("i", $vehicle_id);
        $stmt2->execute();
        $res = $stmt2->get_result()->fetch_assoc();

        $used = $res['total'] ?? 0;
        $remaining = $vehicle['max_litters'] - $used;

        if($fuel_amount > $remaining){
            $message = "⚠️ Max allowed: $remaining L only";
            $type = "error";
        } else {
            // Insert fuel log
            $stmt3 = $conn->prepare("INSERT INTO fuel_log (vehicle_id, fuel_amount, log_date) VALUES (?, ?, NOW())");
            $stmt3->bind_param("ii", $vehicle_id, $fuel_amount);
            $stmt3->execute();

            $new_remaining = $remaining - $fuel_amount;

            $message = "✅ Fuel Approved! <br>You took <b>$fuel_amount L</b><br>Remaining: <b>$new_remaining L</b>";
            $type = "success";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fuel Approval</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #00bfa5, #1de9b6);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Card */
.container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 350px;
    text-align: center;
}

/* Title */
h2 {
    color: #00796b;
    margin-bottom: 20px;
}

/* Message */
.message {
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 16px;
}

.success {
    background: #c8e6c9;
    color: #1b5e20;
}

.error {
    background: #ffcdd2;
    color: #b71c1c;
}

/* Button */
.btn {
    display: inline-block;
    padding: 10px 15px;
    background: #00796b;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn:hover {
    background: #004d40;
}

/* Small text */
small {
    color: #555;
}
</style>

</head>
<body>

<div class="container">
    <h2>Fuel Status</h2>

    <?php if($message): ?>
        <div class="message <?php echo $type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <a href="vehicle_dashboard.php" class="btn">⬅ Back to Dashboard</a>
    <br><br>
    <small>Fuel Pass System - Sri Lanka</small>
</div>

</body>
</html>