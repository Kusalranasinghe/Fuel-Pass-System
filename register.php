<?php
include 'database.php'; // your DB connection

if (isset($_POST['submit'])) {
    // 1. Get user data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nic = $_POST['nic'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];
    

    // 2. Insert user data
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, nic, telephone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $nic, $telephone, $address);

    if ($stmt->execute()) {
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

        if ($stmt2->execute()) {
            echo "User and Vehicle registered successfully!";
        } else {
            echo "Vehicle registration failed: " . $stmt2->error;
        }

    } else {
        echo "User registration failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Pass Registration</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #00bfa5, #1de9b6);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Form Container */
        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00796b;
        }

        /* Section Headings */
        h3 {
            color: #00796b;
            font-size: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #26a69a;
            padding-bottom: 5px;
        }

        /* Input Fields */
        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="email"]:focus {
            border-color: #00796b;
            box-shadow: 0 0 5px #00796b;
            outline: none;
        }

        /* Submit Button */
        button[type="submit"] {
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

        button[type="submit"]:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        /* Sections as Cards */
        .section {
            background-color: #e0f2f1;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Fuel Pass Registration</h2>

        <!-- User Details -->
        <div class="section">
            <h3>User Details</h3>
            <form action="register.php" method="POST">
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
                <input type="text" name="nic" placeholder="NIC" required>
                <input type="text" name="telephone" placeholder="Telephone">
                <input type="text" name="address" placeholder="Address">
        </div>

        <!-- Vehicle Details -->
        <div class="section">
            <h3>Vehicle Details</h3>
            <input type="text" name="vehicle_type" placeholder="Vehicle Type" required>
            <input type="text" name="vehicle_number" placeholder="Vehicle Number" required>
            <input type="text" name="chasi_number" placeholder="Chasi Number" required>
            <input type="text" name="fuel_type" placeholder="Fuel Type" required>
            <button type="submit" name="submit">Register</button>
            </form>
        </div>

    </div>

</body>

</html>