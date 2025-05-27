<?php
include 'db_connect.php';
session_start();

$hotel_data = [
    'name' => 'santika Hotel Tasikmalaya',
    'image' => 'images/santika.jpg',
    'address' => 'Jl. Yudanegara, Tasikmalaya',
    'rating' => 3,
    'price' =>  601120,
    'id' => 3
];

if (isset($_POST['book_now'])) {
    $stmt_room = $conn->prepare("SELECT id FROM rooms WHERE hotel_id = ? LIMIT 1");
    $stmt_room->bind_param("i", $hotel_data['id']);
    $stmt_room->execute();
    $result_room = $stmt_room->get_result();
    $room = $result_room->fetch_assoc();
    $stmt_room->close();

    if ($room) {
        header("Location: booking_form.php?hotel_id={$hotel_data['id']}&room_id={$room['id']}");
        exit;
    } else {
        echo "<script>alert('Kamar belum tersedia tetapi tetap diarahkan ke form.');</script>";
        header("Location: booking_form.php?hotel_id={$hotel_data['id']}");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title><?php echo $hotel_data['name']; ?></title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9ff;
    }
    .top-bar {
      background-color: #fff;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 3px solid #000;
    }
    .logo {
      display: flex;
      flex-direction: column;
      font-size: 16px;
    }
    .logo strong {
      font-weight: bold;
    }
    .top-buttons {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 4px;
    }
    .top-buttons .row {
      display: flex;
      gap: 8px;
    }
    .btn {
      text-decoration: none;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 6px;
      font-size: 14px;
      transition: 0.2s ease;
    }
    .btn.login {
      background: #fff;
      color: #f36;
      border: 1px solid #f36;
    }
    .btn.daftar {
      background-color: #f36;
      color: #fff;
      border: none;
    }
    .btn.admin {
      background-color: #d22b5d;
      color: #fff;
      border: none;
    }

    .detail-container {
      max-width: 960px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    .hotel-header {
      display: flex;
      gap: 20px;
    }
    .hotel-header img {
      width: 400px;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
    }
    .hotel-info h1 {
      margin-top: 0;
      font-size: 28px;
      color: #333;
    }
    .stars {
      color: gold;
    }
    .location-info {
      display: flex;
      align-items: center;
      gap: 5px;
      color: #555;
      font-size: 14px;
      margin-bottom: 20px;
    }
    .price-box {
      background-color: #f9f9f9;
      border: 1px solid #eee;
      padding: 15px;
      border-radius: 8px;
      text-align: right;
    }
    .price-value {
      font-size: 24px;
      font-weight: bold;
      color: #f36;
    }
    .book-button {
      background-color: #f36;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      text-align: center;
    }
    .book-button:hover {
      background-color: #d22b5d;
    }
    .section-title {
      font-size: 20px;
      margin-top: 30px;
      margin-bottom: 15px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }
    .related-hotels {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .related-hotel-card {
      border: 1px solid #eee;
      border-radius: 8px;
      overflow: hidden;
      text-align: center;
    }
    .related-hotel-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .book-link {
      display: inline-block;
      background-color: #f36;
      color: white;
      padding: 8px 15px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
    }
    .book-link:hover {
      background-color: #d22b5d;
    }
  </style>
</head>
<body>
  <div class="top-bar">
    <div class="logo">
      <strong style="color:#000">PURQON<span style="color:#f36">.COM</span></strong>
      <div style="font-size: 12px; color:#333;">Pesan Hotel</div>
    </div>
    <div class="top-buttons">
      <div class="row">
        <?php if (isset($_SESSION['user'])): ?>
          <span style="margin-right: 10px;">Halo, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
          <a href="logout.php" class="btn login" style="background:#f36; color:#fff;">Logout</a>
        <?php else: ?>
          <a href="login.php" class="btn login">Masuk</a>
          <a href="register.php" class="btn daftar">Daftar</a>
        <?php endif; ?>
      </div>
      <a href="admin_login.php" class="btn admin">Admin</a>
    </div>
  </div>

  <div class="detail-container">
    <div class="hotel-header">
      <img src="<?= htmlspecialchars($hotel_data['image']) ?>" alt="<?= htmlspecialchars($hotel_data['name']) ?>">
      <div class="hotel-info">
        <h1><?= htmlspecialchars($hotel_data['name']) ?></h1>
        <div class="stars">
          <?php
          $full_stars = floor($hotel_data['rating']);
          $half_star = ($hotel_data['rating'] - $full_stars) >= 0.5 ? 1 : 0;
          for ($i=0; $i < $full_stars; $i++) echo '★';
          if ($half_star) echo '½';
          ?>
          (<?= $hotel_data['rating'] ?>)
        </div>
        <div class="location-info">
          <img src="images/location-icon.png" alt="Lokasi" />
          <span><?= htmlspecialchars($hotel_data['address']) ?></span>
          &nbsp;&nbsp;
          <a href="https://goo.gl/maps/TsJ9sxfvnQo4tM8W8" target="_blank" style="color:#f36; text-decoration:underline;">Lihat di peta</a>
        </div>
        <div class="price-box">
          <div class="price-value">Rp <?= number_format($hotel_data['price'], 0, ',', '.') ?></div>
        </div>
        <form method="POST" action="">
          <button type="submit" name="book_now" class="book-button">Pesan Sekarang</button>
        </form>
      </div>
    </div>

    <div class="section-title">Hotel Lainnya di Tasikmalaya</div>
    <div class="related-hotels">
      <?php
      $other_hotels = [
        ['id' => 2, 'name' => 'Horison Hotel Tasikmalaya', 'image' => 'images/horison.jpg', 'file' => 'horison.php'],
        ['id' => 1, 'name' => 'Cordela Hotel Tasikmalaya', 'image' => 'images/cordela.jpg', 'file' => 'cordela.php'],
        ['id' => 4, 'name' => 'City Hotel Tasikmalaya', 'image' => 'images/city.jpg', 'file' => 'city.php']
      ];
      foreach ($other_hotels as $hotel): ?>
        <div class="related-hotel-card">
          <img src="<?= $hotel['image'] ?>" alt="<?= $hotel['name'] ?>">
          <div class="info">
            <div class="hotel-name"><?= $hotel['name'] ?></div>
            <a href="<?= $hotel['file'] ?>" class="book-link">Pesan</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
