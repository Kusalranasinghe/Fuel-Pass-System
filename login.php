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
<title>Vehicle Login - Fuel Pass System</title>
<style>
    /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to right, #e0f7fa, #f9f9f9);
    }

    .login-container {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        width: 90%;
        max-width: 400px;
        text-align: center;
    }

    h3 {
        color: #00796b;
        margin-bottom: 20px;
        font-size: 24px;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px 15px;
        margin: 15px 0;
        border: 1px solid #ccc;
        border-radius: 50px;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #00796b;
        box-shadow: 0 0 8px rgba(0,121,107,0.3);
    }

    button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #00796b, #26a69a);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #004d40, #26a69a);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    /* Optional footer or small text */
    .login-container p {
        margin-top: 20px;
        color: #555;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="login-container">
    <h3>Vehicle Login</h3>
    <form action="login.php" method="POST">
        <input type="text" name="v_number" placeholder="Vehicle Number" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Enter your vehicle number to access the dashboard.</p>
</div>

</body>
</html>