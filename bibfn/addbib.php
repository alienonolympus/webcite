<?php
    session_start();
    $newbib = htmlspecialchars($_POST['newbib']);
    chdir('..');
    exec('python bib.py nb \'' . $_SESSION['username'] . '\' \'' . $newbib . '\'', $output, $ret);
    if ($output[0] == 1) {
        header('Location: ../bibs.php');
    } else {
        header('Location: ../bibs.php?error=1');
    }
?>