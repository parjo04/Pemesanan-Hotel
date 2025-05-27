<?php
include 'db_connect.php';
session_start();

// Validasi input
$hotel_id = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : 0;
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;

// Ambil data hotel
$stmt_hotel = $conn->prepare("SELECT nama, alamat FROM hotels WHERE id = ?");
$stmt_hotel->bind_param("i", $hotel_id);
$stmt_hotel->execute();
$result_hotel = $stmt_hotel->get_result();
$hotel = $result_hotel->fetch_assoc();
$stmt_hotel->close();

// Ambil data kamar
$stmt_room = $conn->prepare("SELECT room_type, available_rooms FROM rooms WHERE id = ?");
$stmt_room->bind_param("i", $room_id);
$stmt_room->execute();
$result_room = $stmt_room->get_result();
$room = $result_room->fetch_assoc();
$stmt_room->close();

// Proses form booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($room && $room['available_rooms'] > 0) {
        $stmt_update = $conn->prepare("UPDATE rooms SET available_rooms = available_rooms - 1 WHERE id = ?");
        $stmt_update->bind_param("i", $room_id);
        $stmt_update->execute();
        $stmt_update->close();

        echo "<script>alert('Booking berhasil!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Kamar tidak tersedia!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Booking - <?= htmlspecialchars($hotel['name']) ?></title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9ff;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-top: 0;
      color: #333;
      text-align: center;
    }
    label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
      color: #444;
    }
    input[type="text"], input[type="email"], input[type="number"], select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    button {
      background-color: #f36;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 20px;
      width: 100%;
    }
    button:hover {
      background-color: #d22b5d;
    }
    .info-box {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-top: 20px;
      border: 1px solid #eee;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Form Booking</h2>
    <div class="info-box">
      <strong>Hotel:</strong> <?= htmlspecialchars($hotel['nama']) ?><br>
      <strong>Alamat:</strong> <?= htmlspecialchars($hotel['alamat']) ?><br>
      <strong>Tipe Kamar:</strong> <?= htmlspecialchars($room['room_type']) ?><br>
      <strong>Kamar Tersedia:</strong> <?= htmlspecialchars($room['available_rooms']) ?>
    </div>

    <form method="POST">
      <label>Nama Lengkap</label>
      <input type="text" name="full_name" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Jumlah Tamu</label>
      <input type="number" name="guests" min="1" required>

      <label>Tanggal Check-in</label>
      <input type="date" name="checkin" required>

      <label>Tanggal Check-out</label>
      <input type="date" name="checkout" required>

      <button type="submit">Konfirmasi Booking</button>
    </form>
  </div>
</body>
</html>
