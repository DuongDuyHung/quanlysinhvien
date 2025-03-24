<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];

    // Kiểm tra xem sinh viên có tồn tại trong database không
    $result = $conn->query("SELECT * FROM SinhVien WHERE MaSV = '$MaSV'");

    if ($result->num_rows > 0) {
        // Nếu hợp lệ, chuyển hướng đến trang học phần
        header("Location: HocPhan.php?MaSV=$MaSV");
        exit();
    } else {
        $error = "Mã sinh viên không hợp lệ!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="index.php">Test1</a>
        <div>
            <a class="text-white" href="dangnhap.php">Đăng Nhập</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="mb-3">ĐĂNG NHẬP</h2>
        
        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="dangnhap.php" method="post">
            <div class="mb-3">
                <label class="fw-bold">MaSV</label>
                <input type="text" name="MaSV" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
        <a href="index.php" class="d-block mt-3">Back to List</a>
    </div>
</body>
</html>
