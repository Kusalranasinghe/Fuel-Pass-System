<?php
session_start();

// show errors (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'phpqrcode/qrlib.php';

// TEMP: if no session, use test ID
$vehicle_id = $_SESSION['vehicle_id'] ?? 1;

// QR data
$data = "Vehicle ID: " . $vehicle_id;

// generate QR
QRcode::png($data);