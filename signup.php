<!DOCTYPE html>
<html>
<?php
    session_start();
    $error = $_GET['error'];
    if ($_SESSION['access'] == 1) {
        header('Location: bibs.php');
    }
?>

<head>
    <title>Webcite | Register</title>
</head>
    
<body>
    <form id='signup' action='signup_redirect.php' method='post' accept-charset='UTF-8'>

        <?php
            if ($error == 1) {
                echo('
                    <p>
                        An error has occured, the following may have occured:
                        <ul>
                            <li>Quotation marks have been used.</li>
                            <li>The username is not unique.</li>
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

    <h3>Note:</h3>

    <p>Passwords are saved as plain text so please do not enter your commonly used passwords.</p>

</body>
    
</html>