<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../../login.php");
    exit();
}
require_once '../../config/database.php';

$id_penjual = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM ternak WHERE id_penjual = ?");
$query->bind_param("i", $id_penjual);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ternak Saya - SIPERA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Daftar Ternak Milik Anda</h2>
        <table class="table table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Usia</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Status Kesehatan</th>
                    <th>Foto</th>
                    <th>Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= ucfirst($row['jenis']) ?></td>
                    <td><?= $row['usia'] ?> bln</td>
                    <td><?= $row['berat'] ?> kg</td>
                    <td>Rp<?= number_format($row['harga']) ?></td>
                    <td><?= $row['status_kesehatan'] ?></td>
                    <td>
                        <?php if ($row['foto']): ?>
                            <a href="../../public/<?= $row['foto'] ?>" target="_blank">Lihat</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['sertifikat']): ?>
                            <a href="../../public/<?= $row['sertifikat'] ?>" target="_blank">Lihat</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
