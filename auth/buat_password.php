<?php
session_start();

if (!isset($_SESSION['nis'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">
    <div class="card shadow rounded-4" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-2">Buat Password</h4>
            <p class="text-center text-muted mb-4">
                Password ini akan digunakan untuk login berikutnya
            </p>

            <form action="simpan_password.php" method="POST">
                <div class="mb-3">
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password"
                           required>
                </div>

                <div class="mb-3">
                    <input type="password"
                           name="konfirmasi"
                           class="form-control"
                           placeholder="Konfirmasi Password"
                           required>
                </div>

                <button class="btn btn-primary w-100">
                    Simpan Password
                </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>
