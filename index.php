<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fuel Pass System</title>
<style>
    /* Reset some default styles */
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
        background: linear-gradient(to right, #f9f9f9, #e0f7fa);
    }

    .container {
        text-align: center;
        background: #ffffff;
        padding: 50px 40px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        width: 90%;
        max-width: 400px;
    }

    h1 {
        color: #00796b;
        margin-bottom: 20px;
        font-size: 28px;
    }

    p {
        color: #555;
        margin-bottom: 40px;
        font-size: 16px;
    }

    .btn {
        display: inline-block;
        width: 150px;
        margin: 10px;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #00796b, #26a69a);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn:hover {
        background: linear-gradient(135deg, #004d40, #26a69a);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    /* Add a subtle Sri Lanka flag-inspired accent */
    .accent {
        display: inline-block;
        width: 300px;
        height: 5px;
        background: linear-gradient(to right, #ffcc00, #de2910, #007e3a);
        margin: 20px 0;
        border-radius: 3px;
    }

</style>
</head>
<body>

<div class="container">
    <h1>Fuel Pass System</h1>
    
    <div class="accent"></div>
    <p>Manage vehicle fuel quotas and take fuel easily with your QR code.</p>
    <button class="btn" onclick="window.location.href='user_form.php'">Register</button>
    <button class="btn" onclick="window.location.href='login.php'">Login</button>
</div>

</body>
</html>