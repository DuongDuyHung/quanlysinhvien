<?php
include 'database.php';
$result = $conn->query("SELECT * FROM HocPhan");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Học Phần</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="fw-bold">TRANG HỌC PHẦN</h2>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['MaHP']) ?></td>
                        <td><?= htmlspecialchars($row['TenHP']) ?></td>
                        <td><?= htmlspecialchars($row['SoTinChi']) ?></td>
                        <td>
                            <a href="dangky.php?MaHP=<?= $row['MaHP'] ?>" class="btn btn-primary">Đăng Ký</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php" class="back-link">Back to List</a>
    </div>
</body>
</html>
