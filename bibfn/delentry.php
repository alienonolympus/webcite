<?php
    session_start();
    $bibname = htmlspecialchars($_POST['bibname']);
    $entryname = htmlspecialchars($_POST['delentryname']);
    chdir('..');
    exec('python bib.py de \'' . $_SESSION['username'] . '\' \'' . $bibname. '\' \'' . $entryname . '\'', $output, $ret);
    header('Location: ../bib.php?name=' . $bibname);
?>