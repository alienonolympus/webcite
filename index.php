<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 1) {
        header('Location: bibs.php');
    }
?>

<head>
    <title>Webcite | Home</title>
</head>

<body>

<?php
?>

<p>
<a href="auth/signup.php">Signup</a>
<a href="auth/login.php">Login</a>
</p>

</body>

</html>
