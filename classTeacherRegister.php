<?php 
include 'Includes/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tblclassteacher (firstName, lastName, emailAddress, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Account created successfully! <a href='login.php'>Login here</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Error creating account. Please try again.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center">Register</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-success btn-block" value="Register">
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
