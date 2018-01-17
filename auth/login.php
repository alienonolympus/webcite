<!DOCTYPE html>
<html>
<?php
    session_start();
    $error = $_GET['error'];
    if ($_SESSION['access'] == 1) {
        header('Location: ../bibs.php');
    }
?>

<head>
    <title>Webcite | Login</title>
</head>
    
<body>
    <form id='login' action='login_redirect.php' method='post' accept-charset='UTF-8'>

        <?php
            if ($error == 1) {
                echo('
                    <p>
                        An error has occured, the following may have occured:
                        <ul>
                            <li>Username does not exist.</li>
                            <li>Password is incorrect.</li>
                        </ul>
                    </p>
                ');
            }
        ?>
        <label for='username'>Username: </label>
        <input type='text' name='username' id='username' maxlength='50'>
        <br>
        <label for='password'>Password: </label>
        <input type='password' name='password' id='password' maxlength='50'>
        <br>
        <input type='submit' name='submit' value='submit'>

    </form>
    <p>Not registered? <a href="signup.php">Signup</a></p>
</body>
    
</html>