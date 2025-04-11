<?php 
include 'Includes/dbcon.php';
session_start();

// Rediriger l'utilisateur s'il est déjà connecté
if (isset($_SESSION['userId'])) {
    header("Location: ClassTeacher/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>Code Camp BD - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-login">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form class="user" method="POST" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-block" value="Login" name="login">
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['login'])) {
                                        $username = htmlspecialchars($_POST['username']);
                                        $password = $_POST['password'];

                                        // Préparer une requête sécurisée
                                        $stmt = $conn->prepare("SELECT * FROM tblclassteacher WHERE emailAddress = ?");
                                        $stmt->bind_param("s", $username);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            $user = $result->fetch_assoc();

                                            // Vérifier le mot de passe
                                            if (password_verify($password, $user['password'])) {
                                                $_SESSION['userId'] = $user['Id'];
                                                $_SESSION['firstName'] = $user['firstName'];
                                                $_SESSION['lastName'] = $user['lastName'];
                                                $_SESSION['emailAddress'] = $user['emailAddress'];
                                                $_SESSION['classId'] = $user['classId'];
                                                $_SESSION['classArmId'] = $user['classArmId'];

                                                echo "<script>window.location.href='ClassTeacher/index.php';</script>";
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>Invalid Password!</div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger' role='alert'>Invalid Username!</div>";
                                        }
                                        $stmt->close();
                                    }
                                    ?>
                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="classTeacherLogin.php">Class Teacher Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>
