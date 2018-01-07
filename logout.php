<?php
    session_start();
    $_SESSION['username'] = '';
    $_SESSION['access'] = false;
    header('Location: index.php');
?>