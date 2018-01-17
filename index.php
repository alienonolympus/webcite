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
    <link rel='stylesheet' type='text/css' href='css/index.css'>
</head>

<body>

<div class='container'>
    <button id='signup' class='btn'>Signup</button>
    <button id='login' class='btn'>Login</button>
</div>

<script type='text/javascript'>
    document.getElementById('signup').onclick = function() {
        location.href = 'auth/signup.php';
    };
    document.getElementById('login').onclick = function() {
        location.href = 'auth/login.php';
    }
</script>

</body>

</html>
