<?php
    session_start();
    $bibname = htmlspecialchars($_POST['bibname']);
    $entryname = htmlspecialchars($_POST['entryname']);
    $authors = htmlspecialchars($_POST['authors']);
    $title = htmlspecialchars($_POST['title']);
    /*$surname = '';
    $firstname = '';
    for($i = 0; $i < $authors; $i++) {
        if ($i < $authors - 1) {
            $surname = $surname . '"' . $_POST['surname'][$i] . '"' . ',';
            $firstname = $firstname . '"' . $_POST['firstname'][$i] . '"' . ',';
        } else {
            $surname = $surname . '"' . $_POST['surname'][$i] . '"';
            $firstname = $firstname . '"' . $_POST['firstname'][$i] . '"';
        }
    }*/
    $surname = htmlspecialchars($_POST['surname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $sitename = htmlspecialchars($_POST['sitename']);
    $datetime = htmlspecialchars($_POST['datetime']);
    $flag_datetime = $datetime == '';
    $accessed = htmlspecialchars($_POST['accessed']);
    $url = htmlspecialchars($_POST['url']);
    $command = 'python bib.py ue \''. $_SESSION['username'] . '\' \'' . $bibname. '\' \'' . $entryname . '\' \'' . $title . '\' \'' . 'false' . '\' \'' . $surname .'\' \'' . $firstname .'\' \'' . 'false' . '\' \'' . $sitename . '\' \'' . $flag_datetime . '\' \'' . $datetime . '\' \'' . $accessed . '\' \'' . $url . '\' ';
    chdir('..');
    exec($command);
    header('Location: ../bib.php?name=' . $bibname);
    //username, bib_name, index_original, title, flag_author, surname, firstname, flag_sitename, sitename, flag_datetime, datetime, accessed, url
?>