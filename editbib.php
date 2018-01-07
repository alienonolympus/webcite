<?php
    $bibname = htmlspecialchars($_POST['editbibname']);
    header('Location: bib.php?name=' . $bibname)
?>