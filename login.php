<?php
session_start();
include 'database.php';

$error = "";

if(isset($_POST['login'])){
    $v_number = $_POST['v_number'];   // keep as string
    $password = $_POST['password'];

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

    // Only ONE parameter
    $stmt->bind_param("s", $v_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $vehicle = $result->fetch_assoc();

        // ✅ Password check
        if($password == $vehicle['password']){
            $_SESSION['vehicle_id'] = $vehicle['id'];
            $_SESSION['v_number'] = $vehicle['v_number'];

            header("Location: vehicle_dashboard.php");
            exit;
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "❌ Vehicle not found!";
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
    background: #fff;
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

input {
    width: 100%;
    padding: 12px 15px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 50px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}

input:focus {
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
    transition: 0.3s;
}

button:hover {
    background: linear-gradient(135deg, #004d40, #26a69a);
    transform: translateY(-3px);
}

/* Error message */
.error {
    background: #ffcdd2;
    color: #b71c1c;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
}

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

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="v_number" placeholder="Vehicle Number" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Enter your vehicle number & password</p>
</div>

</body>
</html>