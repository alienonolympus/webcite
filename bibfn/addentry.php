<?php
    session_start();
    $bibname = htmlspecialchars($_POST['bibname']);
    $url = htmlspecialchars($_POST['url']);
    chdir('..');
    exec('python bib.py ne \'' . $_SESSION['username'] . '\' \'' . $bibname . '\' \'' . $url . '\'', $output, $ret);
    $_SESSION['entryname'] = $output[0];
    $_SESSION['bibname'] = $bibname;
    // header('Location: ../bib.php?name=' . $bibname);
    header('Location: ../editentry.php');
?>