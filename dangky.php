<?php
include 'database.php';

$MaSV = '0123456789'; 

if (isset($_GET['MaHP'])) {
    $MaHP = $_GET['MaHP'];

    $sqlCheck = "SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV'";
    $result = $conn->query($sqlCheck);

    if ($result->num_rows == 0) {
        $conn->query("INSERT INTO DangKy (NgayDK, MaSV) VALUES (CURDATE(), '$MaSV')");
        $MaDK = $conn->insert_id;
    } else {
        $row = $result->fetch_assoc();
        $MaDK = $row['MaDK'];
    }

    $sqlCheckHP = "SELECT * FROM ChiTietDangKy WHERE MaDK = '$MaDK' AND MaHP = '$MaHP'";
    $resultHP = $conn->query($sqlCheckHP);

    if ($resultHP->num_rows == 0) {
        $conn->query("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')");
    }
    header("Location: dangKy.php");
}
if (isset($_GET['delete'])) {
    $MaHP = $_GET['delete'];
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaHP = '$MaHP' AND MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV')");
    header("Location: dangKy.php");
}

if (isset($_POST['clear'])) {
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV')");
    header("Location: dangKy.php");
}

$sql = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi 
        FROM ChiTietDangKy ctdk
        JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
        JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
        WHERE dk.MaSV = '$MaSV'";
$result = $conn->query($sql);

$soHocPhan = $result->num_rows;
$tongTinChi = 0;
while ($row = $result->fetch_assoc()) {
    $tongTinChi += $row['SoTinChi'];
}
$result->data_seek(0);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Học Phần</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .nav-link { color: white; }
        .nav-link.active { font-weight: bold; }
        .table th, .table td { text-align: left; }
        .highlight { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Test1</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Sinh Viên</a></li>
                    <li class="nav-item"><a class="nav-link" href="HocPhan.php">Học Phần</a></li>
                    <li class="nav-item"><a class="nav-link active" href="DangKy.php">Đăng Ký (<?= $soHocPhan ?>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="fw-bold">Đăng Ký Học Phần</h2>

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Chỉ Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['MaHP']) ?></td>
                        <td><?= htmlspecialchars($row['TenHP']) ?></td>
                        <td><?= htmlspecialchars($row['SoTinChi']) ?></td>
                        <td><a href="dangKy.php?delete=<?= $row['MaHP'] ?>" class="text-danger">Xóa</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="highlight">Số học phần: <?= $soHocPhan ?></p>
        <p class="highlight">Tổng số tín chỉ: <?= $tongTinChi ?></p>

        <form method="post">
            <button type="submit" name="clear" class="btn btn-warning">Xóa Đăng Ký</button>
            <button type="submit" name="save" class="btn btn-success">Lưu Đăng Ký</button>
        </form>
    </div>
</body>
</html>
