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
    SELECT SUM(fuel_amount) AS total_taken
    FROM fuel_log
    WHERE vehicle_id = ? AND log_date BETWEEN ? AND ?
");

if(!$stmt2){
    die("Prepare failed: " . $conn->error);
}

$stmt2->bind_param("iss", $vehicle_id, $week_start, $week_end);
$stmt2->execute();
$result = $stmt2->get_result();
$row = $result->fetch_assoc();
$total_taken = $row['total_taken'] ?? 0;

$remaining = $vehicle['max_litters'] - $total_taken;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #00bfa5, #26a69a);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin-top: 40px;
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #00796b;
            margin-bottom: 25px;
        }

        .section {
            background-color: #e0f2f1;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .section h3 {
            margin-bottom: 15px;
            border-bottom: 2px solid #26a69a;
            padding-bottom: 5px;
            color: #004d40;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        form input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form input[type="number"]:focus {
            outline: none;
            border-color: #00796b;
            box-shadow: 0 0 5px #00796b;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        form button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        .qr-section {
            text-align: center;
            margin-top: 20px;
        }

        .qr-section img {
            border: 5px solid #26a69a;
            border-radius: 10px;
            padding: 5px;
            background-color: #ffffff;
        }

        .warning {
            color: #c62828;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Vehicle Dashboard</h2>

    <!-- Vehicle Info Section -->
    <div class="section">
        <h3>Vehicle Info</h3>
        <p><strong>Vehicle Number:</strong> <?php echo $vehicle['v_number']; ?></p>
        <p><strong>Vehicle Type:</strong> <?php echo $vehicle['v_type']; ?></p>
        <p><strong>Owner:</strong> <?php echo $vehicle['fname'].' '.$vehicle['lname']; ?></p>
    </div>

    <!-- Fuel Quota Section -->
    <div class="section">
        <h3>Fuel Quota</h3>
        <p>Max Weekly Fuel: <?php echo $vehicle['max_litters']; ?> liters</p>
        <p>Fuel Taken This Week: <?php echo $total_taken; ?> liters</p>
        <p>Remaining Fuel: <?php echo $remaining; ?> liters</p>

        <?php if($remaining > 0): ?>
            <p class="warning">⚠️ You have <?php echo $remaining; ?> liters remaining for this week.</p>
        <?php else: ?>
            <p class="warning">⚠️ You have reached your weekly fuel quota.</p>
        <?php endif; ?>
    </div>

    <!-- QR Code Section -->
    <?php if($remaining > 0): 
        $data = "http://172.20.10.5/Fuel-Pass System/scan.php?vehicle_id=".$vehicle_id;
    ?>
    <div class="qr-section">
        <h3>Your QR Code</h3>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($data); ?>" alt="QR Code">
        <p>Scan this QR code at the fuel station to approve fuel.</p>
    </div>
    <?php endif; ?>
</div>

</body>
</html>