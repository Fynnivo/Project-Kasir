<?php
@ob_start();
session_start();
if (isset($_POST['register'])) {
    require 'config.php';

    $nama = strip_tags($_POST['nama']);
    $email = strip_tags($_POST['email']);
    $user = strip_tags($_POST['user']);
    $pass = strip_tags($_POST['pass']);

    if (empty($nama) || empty($email) || empty($user) || empty($pass)) {
        echo '<script>alert("Semua field wajib diisi!");history.go(-1);</script>';
        exit;
    }

    // Cek apakah username sudah ada
    $sql_check = 'SELECT user FROM login WHERE user = ?';
    $row_check = $config->prepare($sql_check);
    $row_check->execute([$user]);
    if ($row_check->rowCount() > 0) {
        echo '<script>alert("Username sudah terdaftar!");history.go(-1);</script>';
        exit;
    }

    // Tambahkan data ke database
    $sql_member = 'INSERT INTO member (nama, email) VALUES (?, ?)';
    $stmt_member = $config->prepare($sql_member);
    if (!$stmt_member->execute([$nama, $email])) {
        print_r($stmt_member->errorInfo());
        exit;
    }
    $id_member = $config->lastInsertId();

    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
    $sql_login = 'INSERT INTO login (id_member, user, pass) VALUES (?, ?, ?)';
    $stmt_login = $config->prepare($sql_login);
    if (!$stmt_login->execute([$id_member, $user, $hashed_pass])) {
        print_r($stmt_login->errorInfo());
        exit;
    }

    echo '<script>alert("Registrasi berhasil! Silakan login.");window.location="login.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register - POS</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-md-5 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="h4 text-gray-900 mb-4"><b>Register</b></h4>
                            </div>
                            <form class="form-register" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nama"
                                        placeholder="Nama Lengkap" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="user"
                                        placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="pass"
                                        placeholder="Password" required>
                                </div>
                                <button class="btn btn-primary btn-block" name="register" type="submit"><i
                                        class="fa fa-user-plus"></i> Register</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Sudah punya akun? Login di sini!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="sb-admin/js/sb-admin-2.min.js"></script>
</body>
</html>
