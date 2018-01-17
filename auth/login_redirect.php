<?php
    session_start();
    if ($_SESSION['access'] == 1) {
        header('Location: ../bibs.php');
    }
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    chdir('..');
    exec('python bib.py login \'' . $username . '\' \'' . $password . '\'', $output, $ret);
    if ($output[0] == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['access'] = true;
        header('Location: ../bibs.php');
    } else {
        $_SESSION['access'] = false;
        header('Location: login.php?error=1');
    }
?>