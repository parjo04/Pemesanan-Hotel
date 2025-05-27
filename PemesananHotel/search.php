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

      <div class="hotel-card">
        <img src="images/cordela.jpg" alt="Cordela Hotel">
        <div class="hotel-name">CORDELA HOTEL</div>
        <div class="alamat">Jl.Yudanegara Kota Tasikmalaya</div>
        <div class="rating">Rating:<br><span class="stars">★★★★☆</span> 4.0</div>
        <a href="cordela.php" class="pesan-btn">Pesan</a>
      </div>

      <div class="hotel-card">
        <img src="images/horison.jpg" alt="Horison Hotel">
        <div class="hotel-name">HORISON HOTEL</div>
        <div class="alamat">Jl.Yudanegara Kota Tasikmalaya</div>
        <div class="rating">Rating:<br><span class="stars">★★★★★</span> 5.0</div>
        <a href="horison.php" class="pesan-btn">Pesan</a>
      </div>

      <div class="hotel-card">
        <img src="images/santika.jpg" alt="Santika Hotel">
        <div class="hotel-name">SANTIKA HOTEL</div>
        <div class="alamat">Jl.Yudanegara Kota Tasikmalaya</div>
        <div class="rating">Rating:<br><span class="stars">★★★☆☆</span> 3.0</div>
        <a href="santika.php" class="pesan-btn">Pesan</a>
      </div>

      <div class="hotel-card">
        <img src="images/city.jpg" alt="City Hotel">
        <div class="hotel-name">CITY HOTEL</div>
        <div class="alamat">Jl.Sukalaya Kota Tasikmalaya</div>
        <div class="rating">Rating:<br><span class="stars">★★★★☆</span> 4.0</div>
        <a href="city.php" class="pesan-btn">Pesan</a>
      </div>

    </div>
  </div>
</body>
</html>