<?php
include 'database.php'; // your DB connection

if(isset($_POST['submit'])){
    // 1. Get user data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nic = $_POST['nic'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];

    // 2. Insert user data
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, nic, telephone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $nic, $telephone, $address);

    if($stmt->execute()){
        // 3. Get last inserted user ID
        $user_id = $stmt->insert_id;

        // 4. Get vehicle data
        $vehicle_type = $_POST['vehicle_type'];
        $vehicle_number = $_POST['vehicle_number'];
        $chasi_number = $_POST['chasi_number'];
        $fuel_type = $_POST['fuel_type'];

        // 5. Insert vehicle data
        $stmt2 = $conn->prepare("INSERT INTO vehicles (u_id, v_type, v_number, c_number, fuel_type) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("issss", $user_id, $vehicle_type, $vehicle_number, $chasi_number, $fuel_type);

        if($stmt2->execute()){
            echo "User and Vehicle registered successfully!";
        } else {
            echo "Vehicle registration failed: ".$stmt2->error;
        }

    } else {
        echo "User registration failed: ".$stmt->error;
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
    <form action="register.php" method="POST">
    <h3>User Details</h3>
    <input type="text" name="fname" placeholder="First Name" required>
    <input type="text" name="lname" placeholder="Last Name" required>
    <input type="text" name="nic" placeholder="NIC" required>
    <input type="text" name="telephone" placeholder="Telephone">
    <input type="text" name="address" placeholder="Address">

    <h3>Vehicle Details</h3>
    <input type="text" name="vehicle_type" placeholder="Vehicle Type" required>
    <input type="text" name="vehicle_number" placeholder="Vehicle Number" required>
    <input type="text" name="chasi_number" placeholder="Chasi Number" required>
    <input type="text" name="fuel_type" placeholder="Fuel Type" required>

    <button type="submit" name="submit">Register</button>
</form>
</body>
</html>

