<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Purqon - Pesan Hotel</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fff;
    }

    .topbar {
      background: #000;
      color: #fff;
      padding: 5px 20px;
      font-size: 14px;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      border-bottom: 1px solid #ccc;
    }

    .navbar h1 {
      margin: 0;
      color: #000;
      font-size: 20px;
    }

    .navbar h1 span {
      color: #f36;
    }

    .navbar .buttons a {
      padding: 8px 14px;
      text-decoration: none;
      margin-left: 10px;
      border-radius: 5px;
      font-size: 12px;
    }

    .btn-login {
      border: 1px solid #f36;
      color: #f36;
    }

    .btn-register {
      background: #f36;
      color: #fff;
    }

    .banner {
      width: 100%;
      height: 250px;
      background: url('Hotel.jpg') center center/cover no-repeat;
    }

    .hotel-section {
      background: #fff;
      padding: 30px;
    }

    .hotel-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
      justify-items: center;
    }

    .hotel-card {
      border: 5px solid #f36;
      border-radius: 40px;
      width: 300px;
      padding: 20px;
      text-align: center;
    }

    .hotel-card img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .hotel-name {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 5px;
    }

    .alamat {
      font-size: 12px;
      color: #333;
      margin-bottom: 10px;
    }

    .rating {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .stars {
      color: gold;
    }

    .pesan-btn {
      display: inline-block;
      background: #f36;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="topbar">&nbsp;</div>

  <div class="navbar">
    <h1><strong>PURQON.<span>COM</span></strong></h1>
    <div class="buttons">
      <a href="login.php" class="btn-login">Masuk</a>
      <a href="register.php" class="btn-register">Daftar</a>
    </div>
  </div>

  <div class="banner"></div>

  <div class="hotel-section">
    <div class="hotel-grid">
      <?php
      $hotels = [
          ['name' => 'CORDELA HOTEL', 'image' => 'images/cordela.jpg', 'file' => 'cordela.php', 'address' => 'Jl.Yudanegara Kota Tasikmalaya', 'rating' => 4.0],
          ['name' => 'HORISON HOTEL', 'image' => 'images/horison.jpg', 'file' => 'horison.php', 'address' => 'Jl.Yudanegara Kota Tasikmalaya', 'rating' => 5.0],
          ['name' => 'SANTIKA HOTEL', 'image' => 'images/santika.jpg', 'file' => 'santika.php', 'address' => 'Jl.Yudanegara Kota Tasikmalaya', 'rating' => 3.0],
          ['name' => 'CITY HOTEL', 'image' => 'images/city.jpg', 'file' => 'city.php', 'address' => 'Jl.Sukalaya Kota Tasikmalaya', 'rating' => 4.0]
      ];

      foreach ($hotels as $hotel): ?>
          <div class="hotel-card">
              <img src="<?= $hotel['image'] ?>" alt="<?= $hotel['name'] ?>">
              <div class="hotel-name"><?= $hotel['name'] ?></div>
              <div class="alamat"><?= $hotel['address'] ?></div>
              <div class="rating">Rating:<br><span class="stars">
                  <?php 
                  $full_stars = floor($hotel['rating']);
                  $half_star = ($hotel['rating'] - $full_stars) >= 0.5 ? 1 : 0;
                  for ($i=0; $i < $full_stars; $i++) echo '★';
                  if ($half_star) echo '½';
                  ?>
              </span> <?= $hotel['rating'] ?></div>
              <a href="<?= isset($_SESSION['user']) ? $hotel['file'] : 'login.php?redirect=' . urlencode($hotel['file']) ?>" class="pesan-btn">Pesan</a>
          </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>