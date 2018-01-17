<?php
    session_start();
    $bibname = htmlspecialchars($_POST['delbibname']);
    chdir('..');
    exec('python bib.py db \'' . $_SESSION['username'] . '\' \'' . $bibname . '\'', $output, $ret);
    header('Location: ../bibs.php');
?>