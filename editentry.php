<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 0) {
        header('Location: index.php');
    }
    $bibname = htmlspecialchars($_POST['bibname']);
    $entryname = htmlspecialchars($_POST['editentryname']);
    // exec('python bib.py de \'' . $_SESSION['username'] . '\' \'' . $bibname. '\' \'' . $entryname . '\'', $output, $ret);
    $json = file_get_contents('./bib.json');
    $json_data = json_decode($json, true);
    $bibs = $json_data[$_SESSION['username']];
    if (array_key_exists($bibname, $bibs)) {
        $bib = $bibs[$bibname];
    } else {
        header('Location: bibs.php');
    }
?>

<head>
    <title>Webcite | Edit Entry</title>
</head>
    
<body>

<p>

<a href="logout.php">Logout</a>
<a href="bibs.php">Bibliographies</a>
<a href="bib.php?name=<?php echo($bibname); ?>"><?php echo($bibname); ?></a>

</p>

<br>

<form id='updateentry' action='updateentry.php' method='post' accept-charset='UTF-8'>
    <label for='title'>Title: </label>
    <input type='text' name='title' id='title' value=<?php echo('"' . $bib[$entryname]['title'] . '"'); ?>>
    <br>
    <?php
        if ($bib[$entryname]['flag_author']) {
            echo('<span style="color: red">');
        }
        $authors = sizeof($bib[$entryname]['surname']);
    ?>
    <!--?php
        for($i = 0; $i < $authors; $i++) {
            echo("
                <label for='surname'>Surname: </label>
                <input type='text' name='surname[" . $i . "]' id='surname[" . $i . "]' value='" . $bib[$entryname]['surname'][$i] . "'>
                <label for='firstname'>Firstname: </label>
                <input type='text' name='firstname[" . $i . "]' id='firstname[" . $i . "]' value='" . $bib[$entryname]['firstname'][$i] . "'>
                <br>
            ");
        }
    ?-->

    <label for='surname'>Surnames: </label>
    <input type='text' name='surname' id='surname' value='<?php for($i = 0; $i < $authors; $i++) {echo($bib[$entryname]['surname'][$i]); if($i < $authors - 1){echo(',');}}?>'>
    <label for='firstname'>Firstnames: </label>
    <input type='text' name='firstname' id='firstname' value='<?php for($i = 0; $i < $authors; $i++) {echo($bib[$entryname]['firstname'][$i]); if($i < $authors - 1){echo(',');}}?>'>
    <br>

    <?php
        if ($bib[$entryname]['flag_author']) {
            echo('</span>');
        }
    ?>
    <?php
        if ($bib[$entryname]['flag_sitename']) {
            echo('<span style="color: red">');
        }
    ?>
    <label for='sitename'>Sitename: </label>
    <input type='text' name='sitename' id='sitename' value=<?php echo('"' . $bib[$entryname]['sitename'] . '"'); ?>>
    <br>
    <?php
        if ($bib[$entryname]['flag_sitename']) {
            echo('</span>');
        }
    ?>
    <?php
        if ($bib[$entryname]['flag_datetime']) {
            echo('<span style="color: red">');
        }
    ?>
    <label for='datetime'>Last Modified: </label>
    <input type='text' name='datetime' id='datetime' value=<?php echo('"' . $bib[$entryname]['datetime'] . '"'); ?>>
    <br>
    <?php
        if ($bib[$entryname]['flag_datetime']) {
            echo('</span>');
        }
    ?>
    <label for='accessed'>Accessed: </label>
    <input type='text' name='accessed' id='accessed' value=<?php echo('"' . $bib[$entryname]['accessed'] . '"'); ?>>
    <br>
    <label for='url'>URL: </label>
    <input type='text' name='url' id='url' value=<?php echo('"' . $bib[$entryname]['url'] . '"'); ?>>
    <br>
    
    <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
    <input type='hidden' name='entryname' id='entryname' value='<?php echo($entryname); ?>'>
    <input type='hidden' name='authors' id='authors' value='<?php echo($authors); ?>'>
    <input type='submit' name='submit' value='submit'>
</form>



<h3>Note:</h3>

<p>Field names in <span style='color: red;'>red</span> are flagged and should be double checked</p>

<p>For multiple authors, you can use commas. Example:</p>

<pre><b>Jane Doe and John Doe</b> | <label for='example1'>Surname: </label><input type='text' name='example1' id='example1' value='Doe, Doe'> <label for='example2'>Firstname: </label><input type='text' name='example2' id='example2' value='Jane, John'></pre>

</body>
    
</html>