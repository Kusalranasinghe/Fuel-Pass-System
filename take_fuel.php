<?php
session_start();
include 'database.php';

// Check if vehicle is logged in
if(!isset($_SESSION['vehicle_id'])){
    header("Location: login.php");
    exit;
}

$vehicle_id = $_SESSION['vehicle_id'];

if(isset($_POST['fuel_amount'])){
    $fuel_amount = (float)$_POST['fuel_amount'];

    // Fetch vehicle quota and total fuel taken this week
    $stmt = $conn->prepare("
        SELECT v.v_type, fq.max_litters
        FROM vehicles v
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

    // Check if requested amount is available
    if($fuel_amount > $remaining){
        $_SESSION['error'] = "You cannot take more than your remaining quota ($remaining liters).";
        header("Location: vehicle_dashboard.php");
        exit;
    }

    // Insert fuel transaction
    $stmt3 = $conn->prepare("
        INSERT INTO fuel_transactions (vehicle_id, fuel_taken, trans_date)
        VALUES (?, ?, NOW())
    ");
    $stmt3->bind_param("id", $vehicle_id, $fuel_amount);
    if($stmt3->execute()){
        $_SESSION['success'] = "Fuel taken successfully: $fuel_amount liters.";
    } else {
        $_SESSION['error'] = "Error taking fuel. Try again.";
    }

    header("Location: vehicle_dashboard.php");
    exit;
} else {
    header("Location: vehicle_dashboard.php");
    exit;
}