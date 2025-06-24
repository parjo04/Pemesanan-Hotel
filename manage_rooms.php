<?php
// Aktifkan laporan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Sambungkan ke database
require 'db_connect.php';

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil data admin
$admin_username = $_SESSION['admin'];
$query_admin = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($query_admin);
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$admin_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$admin_data) {
    die("Data admin tidak ditemukan");
}

// Handle Delete Action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $success_msg = "Kamar berhasil dihapus!";
    } else {
        $error_msg = "Gagal menghapus kamar: " . $conn->error;
    }
    $stmt->close();
    header("Location: manage_rooms.php?success=" . urlencode($success_msg ?? '') . "&error=" . urlencode($error_msg ?? ''));
    exit();
}

// Handle Update Status
if (isset($_POST['update_room'])) {
    $room_id = $_POST['room_id'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;
    
    $stmt = $conn->prepare("UPDATE rooms SET is_available = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_available, $room_id);
    if ($stmt->execute()) {
        $success_msg = "Status kamar berhasil diperbarui!";
    } else {
        $error_msg = "Gagal memperbarui status kamar: " . $conn->error;
    }
    $stmt->close();
    header("Location: manage_rooms.php?success=" . urlencode($success_msg ?? '') . "&error=" . urlencode($error_msg ?? ''));
    exit();
}

// Ambil data kamar dengan informasi hotel
$query = "SELECT 
            r.id,
            h.nama AS hotel,
            r.room_type AS tipe_kamar,
            r.available_rooms AS jumlah_kamar,
            r.price AS harga,
            r.is_available,
            r.max_guests,
            r.has_ac,
            r.has_tv,
            r.has_wifi,
            r.has_breakfast
          FROM rooms r
          JOIN hotels h ON r.hotel_id = h.id
          ORDER BY h.nama, r.room_type";

$result = $conn->query($query);

// Format mata uang
function formatCurrency($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kamar | PURQON.COM</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f5f5f5; 
            color: #333;
        }
        .header { 
            background-color: #333; 
            color: white; 
            padding: 15px 20px; 
            display: flex; 
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
        }
        .container { 
            max-width: 1200px; 
            margin: 20px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 5px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        .logout { 
            color: white; 
            text-decoration: none;
            background-color: #555;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            margin-left: 15px;
        }
        .logout:hover {
            background-color: #333;
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .room-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .room-card h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .room-info {
            margin-bottom: 10px;
        }
        .room-info strong {
            display: inline-block;
            width: 120px;
        }
        .room-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .btn {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #4CAF50;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-toggle {
            background-color: #2196F3;
        }
        .admin-info {
            display: flex;
            align-items: center;
        }
        .page-title {
            border-bottom: 2px solid #555;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-btn:hover {
            background-color: #333;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        .facility-icon {
            display: inline-block;
            margin-right: 10px;
            font-size: 16px;
        }
        .available {
            color: #4CAF50;
            font-weight: bold;
        }
        .unavailable {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>ADMIN</h1>
            <h2>PURQON.COM</h2>
        </div>
        <div class="admin-info">
            <span><?= htmlspecialchars($admin_data['full_name']) ?></span>
            <a href="admin_logout.php" class="logout">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="page-title">
            <h2>Kelola Kamar</h2>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        
        <div class="room-grid">
            <?php 
            if ($result && $result->num_rows > 0) {
                while ($room = $result->fetch_assoc()): 
                    $status_class = $room['is_available'] ? 'available' : 'unavailable';
                    $status_text = $room['is_available'] ? 'Tersedia' : 'Tidak Tersedia';
            ?>
            <div class="room-card">
                <h3><?= htmlspecialchars($room['hotel']) ?></h3>
                <div class="room-info">
                    <strong>Tipe Kamar:</strong> <?= htmlspecialchars($room['tipe_kamar']) ?>
                </div>
                <div class="room-info">
                    <strong>Jumlah Kamar:</strong> <?= htmlspecialchars($room['jumlah_kamar']) ?>
                </div>
                <div class="room-info">
                    <strong>Harga:</strong> <?= formatCurrency($room['harga']) ?>
                </div>
                <div class="room-info">
                    <strong>Status:</strong> <span class="<?= $status_class ?>"><?= $status_text ?></span>
                </div>
                <div class="room-info">
                    <strong>Fasilitas:</strong>
                    <div>
                        <?php if ($room['has_ac']): ?>
                            <span class="facility-icon">AC</span>
                        <?php endif; ?>
                        <?php if ($room['has_tv']): ?>
                            <span class="facility-icon">TV</span>
                        <?php endif; ?>
                        <?php if ($room['has_wifi']): ?>
                            <span class="facility-icon">WiFi</span>
                        <?php endif; ?>
                        <?php if ($room['has_breakfast']): ?>
                            <span class="facility-icon">Sarapan</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="room-actions">
                    <form method="POST" action="manage_rooms.php" style="display: inline;">
                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                        <input type="hidden" name="is_available" value="<?= $room['is_available'] ? 0 : 1 ?>">
                        <button type="submit" name="update_room" class="btn btn-toggle">
                            <?= $room['is_available'] ? 'Tandai Tidak Tersedia' : 'Tandai Tersedia' ?>
                        </button>
                    </form>
                    <div>
                        <a href="edit_room.php?id=<?= $room['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="manage_rooms.php?delete_id=<?= $room['id'] ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">Hapus</a>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            } else {
                echo "<p>Tidak ada data kamar</p>";
            }
            ?>
        </div>
        
        <a href="add_room.php" class="btn btn-edit" style="margin-top: 20px;">Tambah Kamar Baru</a>
        <a href="admin_dashboard.php" class="back-btn">Kembali</a>
    </div>
</body>
</html>