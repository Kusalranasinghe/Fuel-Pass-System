<?php
session_start();
include 'database.php';

if(isset($_POST['login'])){
    $v_number = (int)$_POST['v_number'];  // cast to integer

    // Prepare query
    $stmt = $conn->prepare("
        SELECT v.*, u.fname, u.lname, u.nic, u.telephone, u.address
        FROM vehicles v
        JOIN users u ON v.u_id = u.id
        WHERE v.v_number = ?
    ");

    if(!$stmt){
        die("Prepare failed: ".$conn->error);
    }

    $stmt->bind_param("i", $v_number);  // integer type
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $vehicle = $result->fetch_assoc();
        $_SESSION['vehicle_id'] = $vehicle['id'];
        $_SESSION['v_number'] = $vehicle['v_number'];
        header("Location: vehicle_dashboard.php");
        exit;
    } else {
        echo "Vehicle not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="POST">
    <h3>Vehicle Login</h3>
    <input type="text" name="v_number" placeholder="Vehicle Number" required>
    <button type="submit" name="login">Login</button>
</form>
</body>
</html>