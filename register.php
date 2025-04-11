<?php
include 'Includes/dbcon.php'; // Connexion à la base de données
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Account - Student Attendance System</title>
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
                                <div class="register-form">
                                    <h5 class="text-center">STUDENT ATTENDANCE SYSTEM</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <h1 class="h4 text-gray-900 mb-4">Create Account</h1>
                                    </div>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Role--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="ClassTeacher">Class Teacher</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="firstName" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="lastName" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" required name="email" placeholder="Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" required name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" required name="confirmPassword" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group" id="teacherFields" style="display: none;">
                                            <input type="text" class="form-control" name="classId" placeholder="Class ID (For Teachers Only)">
                                        </div>
                                        <div class="form-group" id="teacherFieldsArm" style="display: none;">
                                            <input type="text" class="form-control" name="classArmId" placeholder="Class Arm ID (For Teachers Only)">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-block" value="Register" name="register">
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['register'])) {
                                        $userType = $_POST['userType'];
                                        $firstName = $_POST['firstName'];
                                        $lastName = $_POST['lastName'];
                                        $email = $_POST['email'];
                                        $password = $_POST['password'];
                                        $confirmPassword = $_POST['confirmPassword'];
                                        $classId = $_POST['classId'] ?? null;
                                        $classArmId = $_POST['classArmId'] ?? null;

                                        // Validation des champs
                                        if ($password !== $confirmPassword) {
                                            echo "<div class='alert alert-danger' role='alert'>Passwords do not match!</div>";
                                        } else {
                                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hachage du mot de passe

                                            if ($userType === "Administrator") {
                                                $stmt = $conn->prepare("INSERT INTO tbladmin (firstName, lastName, emailAddress, password) VALUES (?, ?, ?, ?)");
                                                $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
                                            } elseif ($userType === "ClassTeacher") {
                                                $stmt = $conn->prepare("INSERT INTO tblclassteacher (firstName, lastName, emailAddress, password, classId, classArmId) VALUES (?, ?, ?, ?, ?, ?)");
                                                $stmt->bind_param("ssssii", $firstName, $lastName, $email, $hashedPassword, $classId, $classArmId);
                                            }

                                            if ($stmt->execute()) {
                                                echo "<div class='alert alert-success' role='alert'>Account created successfully! <a href='index.php'>Login here</a>.</div>";
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
                                            }
                                        }
                                    }
                                    ?>
                                    <hr>
                                    <div class="text-center">
                                        <a href="index.php">Already have an account? Login</a>
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
    <script>
        // Afficher ou masquer les champs spécifiques au professeur
        const userTypeDropdown = document.querySelector('select[name="userType"]');
        const teacherFields = document.getElementById('teacherFields');
        const teacherFieldsArm = document.getElementById('teacherFieldsArm');

        userTypeDropdown.addEventListener('change', () => {
            if (userTypeDropdown.value === 'ClassTeacher') {
                teacherFields.style.display = 'block';
                teacherFieldsArm.style.display = 'block';
            } else {
                teacherFields.style.display = 'none';
                teacherFieldsArm.style.display = 'none';
            }
        });
    </script>
</body>

</html>
