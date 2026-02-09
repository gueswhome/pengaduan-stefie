<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">
    <div class="card shadow rounded-4" style="width:100%; max-width:420px">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-2">Login Siswa</h4>
            <p class="text-center text-muted mb-4">
                Masukkan NIS dan Password
            </p>

            <form action="proses_login_siswa.php" method="POST">
                <div class="mb-3">
                    <input type="text"
                           name="nis"
                           class="form-control"
                           placeholder="NIS"
                           required>
                </div>

                <div class="mb-3">
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password"
                           required>
                </div>

                <button class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="../index.php" class="text-decoration-none">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
