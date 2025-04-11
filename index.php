<?php 
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Student Attendance System</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-login" style="background-image: url('img/logo/background.jpg');">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 class="text-center">DRSP SYSTEME</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <h1 class="h4 text-gray-900 mb-4">CONNEXION</h1>
                                    </div>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="ClassTeacher">ClassTeacher</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['login'])) {
                                        $userType = $_POST['userType'];
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];

                                        if ($userType === "Administrator") {
                                            $stmt = $conn->prepare("SELECT * FROM tbladmin WHERE emailAddress = ?");
                                            $stmt->bind_param("s", $username);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($row = $result->fetch_assoc()) {
                                                if (password_verify($password, $row['password'])) {
                                                    $_SESSION['userId'] = $row['Id'];
                                                    $_SESSION['firstName'] = $row['firstName'];
                                                    $_SESSION['lastName'] = $row['lastName'];
                                                    $_SESSION['emailAddress'] = $row['emailAddress'];
                                                    header("Location: Admin/index.php");
                                                    exit();
                                                }
                                            }
                                        } elseif ($userType === "ClassTeacher") {
                                            $stmt = $conn->prepare("SELECT * FROM tblclassteacher WHERE emailAddress = ?");
                                            $stmt->bind_param("s", $username);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($row = $result->fetch_assoc()) {
                                                if (password_verify($password, $row['password'])) {
                                                    $_SESSION['userId'] = $row['Id'];
                                                    $_SESSION['firstName'] = $row['firstName'];
                                                    $_SESSION['lastName'] = $row['lastName'];
                                                    $_SESSION['emailAddress'] = $row['emailAddress'];
                                                    $_SESSION['classId'] = $row['classId'];
                                                    $_SESSION['classArmId'] = $row['classArmId'];
                                                    // header("Location: Admin/index.php");
                                                    header("Location: ClassTeacher/index.php");
                                                    exit();
                                                }
                                            }
                                        }

                                        echo "<div class='alert alert-danger' role='alert'>
                                        Invalid login credentials!
                                        </div>";
                                    }
                                    ?>
                                    <hr>
                                    <a href="register.php" class="btn btn-facebook btn-block">
                                        <i class="fab"></i> Create an Account
                                    </a>
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
