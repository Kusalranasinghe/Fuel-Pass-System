<?php
session_start();
include 'database.php';

if(isset($_POST['take_fuel'])){
    $vehicle_id = $_POST['vehicle_id'];
    $fuel_amount = $_POST['fuel_amount'];

    // Get vehicle quota
    $stmt = $conn->prepare("SELECT v.*, fq.max_litters FROM vehicles v JOIN fuel_quota fq ON v.v_type=fq.v_type WHERE v.id=?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $vehicle = $stmt->get_result()->fetch_assoc();

    if(!$vehicle){
        die("Vehicle not found");
    }

    // Check remaining fuel (you can create a fuel_log table to track weekly usage)
    $stmt2 = $conn->prepare("SELECT SUM(fuel_amount) AS total FROM fuel_log WHERE vehicle_id=? AND WEEK(log_date)=WEEK(NOW())");
    $stmt2->bind_param("i", $vehicle_id);
    $stmt2->execute();
    $res = $stmt2->get_result()->fetch_assoc();
    $used = $res['total'] ?? 0;
    $remaining = $vehicle['max_litters'] - $used;

    if($fuel_amount > $remaining){
        die("You cannot take more than remaining fuel: $remaining L");
    }

    // Insert fuel log
    $stmt3 = $conn->prepare("INSERT INTO fuel_log (vehicle_id, fuel_amount, log_date) VALUES (?, ?, NOW())");
    $stmt3->bind_param("ii", $vehicle_id, $fuel_amount);
    $stmt3->execute();

    echo "✅ Fuel approved! You took $fuel_amount L. Remaining this week: ".($remaining - $fuel_amount)." L";
}
?>