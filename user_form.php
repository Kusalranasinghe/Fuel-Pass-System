<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Details</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Body background and centering */
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(to right, #e0f7fa, #f9f9f9);
}

/* Card container */
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

/* Heading */
h2 {
    color: #00796b;
    margin-bottom: 25px;
    font-size: 26px;
}

/* Input fields */
input[type="text"] {
    width: 100%;
    padding: 14px 20px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 50px;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}
input[type="text"]:focus {
    border-color: #00796b;
    box-shadow: 0 0 8px rgba(0,121,107,0.3);
}

/* Button */
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

/* Optional helper text */
p.helper {
    margin-top: 15px;
    font-size: 14px;
    color: #555;
}

/* Input icons (optional, makes it more user-friendly) */
.input-icon {
    position: relative;
}
.input-icon input {
    padding-left: 45px;
}
.input-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #26a69a;
    font-size: 18px;
}
</style>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container">
    <h2>User Details</h2>
    <form action="vehicle_form.php" method="POST">
        <div class="input-icon">
            <i class="fas fa-user"></i>
            <input type="text" name="fname" placeholder="First Name" required>
        </div>
        <div class="input-icon">
            <i class="fas fa-user"></i>
            <input type="text" name="lname" placeholder="Last Name" required>
        </div>
        <div class="input-icon">
            <i class="fas fa-id-card"></i>
            <input type="text" name="nic" placeholder="NIC" required>
        </div>
        <div class="input-icon">
            <i class="fas fa-phone"></i>
            <input type="text" name="telephone" placeholder="Telephone">
        </div>
        <div class="input-icon">
            <i class="fas fa-home"></i>
            <input type="text" name="address" placeholder="Address">
        </div>
        <button type="submit" name="next">Next →</button>
        <p class="helper">Please fill all required fields.</p>
    </form>
</div>

</body>
</html>