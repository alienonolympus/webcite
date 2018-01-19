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
    <title>Webcite | Register</title>
    <link rel='stylesheet' type='text/css' href='../css/main.css'>
</head>
    
<body>
    <div class='container authcontainer'>
        <h1>Signup</h1>
        <form id='signup' action='signup_redirect.php' method='post' accept-charset='UTF-8'>

        <?php
                if ($error == 1) {
                    echo('
                        <p>
                            An error has occured, the following may have occured:
                            <ul>
                                <li>Username is not unique.</li>
                                <li>Quotation marks were used.</li>
                            </ul>
                        </p>
                    ');
                }
            ?>
            <table>
                <tr>
                    <td><label for='username'>Username: </label></td>
                    <td><input type='text' name='username' id='username' maxlength='50' class='textbox'></td>
                </tr>
                <tr>
                    <td><label for='password'>Password: </label></td>
                    <td><input type='password' name='password' id='password' maxlength='50' class='textbox'></td>
                </tr>
                <tr>
                    <td colspan='2' class='center-items'><button type='submit' name='submit' value='submit' id='submit' class='btn authbtn'>Submit</td>
                </tr>
            </table>

        </form>
        <p class='center-items'>Have account? <a href="login.php">Login</a></p>
    </div>
</body>
    
</html>