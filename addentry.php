<?php
    session_start();
    $bibname = htmlspecialchars($_POST['bibname']);
    $url = htmlspecialchars($_POST['url']);
    exec('python bib.py ne \'' . $_SESSION['username'] . '\' \'' . $bibname . '\' \'' . $url . '\'', $output, $ret);
    header('Location: bib.php?name=' . $bibname)
?>