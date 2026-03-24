<?php
session_start();
include 'database.php';

// Save user data to session
if(isset($_POST['next'])){
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['nic'] = $_POST['nic'];
    $_SESSION['telephone'] = $_POST['telephone'];
    $_SESSION['address'] = $_POST['address'];
}

// Final submit
if(isset($_POST['register'])){

    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $nic = $_SESSION['nic'];
    $telephone = $_SESSION['telephone'];
    $address = $_SESSION['address'];

    $stmt = $conn->prepare("INSERT INTO users (fname, lname, nic, telephone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $nic, $telephone, $address);
    $stmt->execute();

    $user_id = $stmt->insert_id;

    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_number = $_POST['vehicle_number'];
    $chasi_number = $_POST['chasi_number'];
    $fuel_type = $_POST['fuel_type'];
    $password = $_POST['password'];

    $stmt2 = $conn->prepare("INSERT INTO vehicles (u_id, v_type, v_number, c_number, fuel_type, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("isssss", $user_id, $vehicle_type, $vehicle_number, $chasi_number, $fuel_type, $password);
    $stmt2->execute();

    echo "<script>
        alert('Registration successful.');
        window.location.href='login.php';
      </script>";

    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vehicle Details</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
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

.container {
    background: #fff;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    width: 90%;
    max-width: 400px;
    text-align: center;
    transition: transform 0.3s ease;
}
.container:hover {
    transform: translateY(-5px);
}

h2 {
    color: #00796b;
    margin-bottom: 25px;
    font-size: 26px;
}

.input-icon {
    position: relative;
}
.input-icon input,
.input-icon select {
    width: 100%;
    padding: 14px 20px 14px 45px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 50px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
    appearance: none;
    background: #fff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><polygon points="0,0 16,0 8,8" fill="%2326a69a"/></svg>') no-repeat right 15px center;
    background-size: 12px;
}
.input-icon select:focus,
.input-icon input:focus {
    border-color: #00796b;
    box-shadow: 0 0 8px rgba(0,121,107,0.3);
}
.input-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #26a69a;
    font-size: 18px;
}

button {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #00796b, #26a69a);
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}
button:hover {
    background: linear-gradient(135deg, #004d40, #26a69a);
    transform: translateY(-3px);
}
</style>
</head>
<body>

<div class="container">
<h2>Vehicle Details</h2>

<form method="POST">
    <div class="input-icon">
        <i class="fas fa-car"></i>
        <select name="vehicle_type" required>
            <option value="" disabled selected>Select Vehicle Type</option>
            <option value="Car">Car</option>
            <option value="Van">Van</option>
            <option value="Motorbike">Motorbike</option>
            <option value="Truck">Truck</option>
            <option value="Bus">Bus</option>
        </select>
    </div>
    <div class="input-icon">
        <i class="fas fa-hashtag"></i>
        <input type="text" name="vehicle_number" placeholder="Vehicle Number" required>
    </div>
    <div class="input-icon">
        <i class="fas fa-cogs"></i>
        <input type="text" name="chasi_number" placeholder="Chasi Number" required>
    </div>
    <div class="input-icon">
        <i class="fas fa-gas-pump"></i>
        <select name="fuel_type" required>
            <option value="" disabled selected>Select Fuel Type</option>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
        </select>
    </div>
    <div class="input-icon">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" name="register">Register</button>
</form>

</div>
</body>
</html>