<?php 
include 'db_connect.php'; 
session_start();

// Redirect jika sudah login sebagai admin
if (isset($_SESSION['admin'])) {
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email/nomor ponsel dan password harus diisi.";
    } else {
        // Debug: Tampilkan input untuk pengecekan
        // var_dump($email, $password);
        
        $sql = "SELECT id, nama_lengkap, email, password FROM Users WHERE (email=? OR nomor_ponsel=?) AND user_type='admin'";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Error prepare: " . $conn->error);
        }
        
        $stmt->bind_param('ss', $email, $email);
        
        if (!$stmt->execute()) {
            die("Error execute: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        // Debug: Tampilkan jumlah hasil query
        // echo "Jumlah hasil: " . $result->num_rows;
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Debug: Tampilkan data admin dan hash password
            // var_dump($admin);
            
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = [
                    'id' => $admin['id'],
                    'email' => htmlspecialchars($admin['email']),
                    'nama_lengkap' => htmlspecialchars($admin['nama_lengkap'])
                ];
                header('Location: admin_dashboard.php');
                exit;
            } else {
                // Debug: Password tidak cocok
                $error = "Password salah.";
            }
        } else {
            $error = "Akun Admin tidak ditemukan.";
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('Hotel.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #f36;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        button:hover {
            background-color: #d22b5d;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="email" placeholder="Nomor Ponsel atau Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">MASUK</button>
        </form>
    </div>
</body>
</html>