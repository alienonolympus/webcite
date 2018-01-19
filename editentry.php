<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 0) {
        header('Location: index.php');
    }
    if ($_POST['editentryname']) {
        $entryname = htmlspecialchars($_POST['editentryname']);
        $bibname = htmlspecialchars($_POST['bibname']);
    } else {
        $entryname = $_SESSION['entryname'];
        $bibname = $_SESSION['bibname'];
    }
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
    <link rel='stylesheet' type='text/css' href='../css/main.css'>
</head>
    
<body>

<div class='container'>

    <div class='header'>
        <a href='auth/logout.php'>Logout(<?php echo($_SESSION['username'])?>)</a>
        <span> > </span> 
        <a href="bibs.php">Bibliographies</a>
        <span> > </span> 
        <a href="bib.php?name=<?php echo($bibname); ?>"><?php echo($bibname); ?></a>
    </div>

    <br>

    <form id='updateentry' action='bibfn/updateentry.php' method='post' accept-charset='UTF-8'>
        <table class='entries input'>
            <tr>
                <td><label for='title'>Title: </label></td>
                <td colspan='3'>
                    <input type='text' name='title' id='title' value=<?php echo('"' . $bib[$entryname]['title'] . '"'); ?>>
                </td>
            </tr>

            <?php
                if ($bib[$entryname]['flag_author']) {
                    echo('<span style="color: red">');
                }
                $authors = sizeof($bib[$entryname]['surname']);
            ?>

            <tr>
                <td><label for='surname'>Surnames: </label></td>
                <td>
                    <input type='text' name='surname' id='surname' value='<?php for($i = 0; $i < $authors; $i++) {echo($bib[$entryname]['surname'][$i]); if($i < $authors - 1){echo(',');}}?>'>
                </td>
                <td><label for='firstname'>Firstnames: </label></td>
                <td>
                    <input type='text' name='firstname' id='firstname' value='<?php for($i = 0; $i < $authors; $i++) {echo($bib[$entryname]['firstname'][$i]); if($i < $authors - 1){echo(',');}}?>'>
                </td>
            </tr>

            <?php
                if ($bib[$entryname]['flag_author']) {
                    echo('</span>');
                }
                if ($bib[$entryname]['flag_sitename']) {
                    echo('<span style="color: red">');
                }
            ?>

            <tr>
                <td><label for='sitename'>Sitename: </label></td>
                <td colspan='3'>
                    <input type='text' name='sitename' id='sitename' value=<?php echo('"' . $bib[$entryname]['sitename'] . '"'); ?>>
                </td>
            </tr>

            <?php
                if ($bib[$entryname]['flag_sitename']) {
                    echo('</span>');
                }
                if ($bib[$entryname]['flag_datetime']) {
                    echo('<span style="color: red">');
                }
            ?>

            <tr>
                <td><label for='datetime'>Last Modified: </label></td>
                <td colspan='3'>
                    <input type='text' name='datetime' id='datetime' value=<?php echo('"' . $bib[$entryname]['datetime'] . '"'); ?>>
                </td>
            </tr>

            <?php
                if ($bib[$entryname]['flag_datetime']) {
                    echo('</span>');
                }
            ?>

            <tr>
                <td><label for='accessed'>Accessed: </label></td>
                <td colspan='3'>
                    <input type='text' name='accessed' id='accessed' value=<?php echo('"' . $bib[$entryname]['accessed'] . '"'); ?>>
                </td>
            </tr>

            <tr>
                <td><label for='url'>URL: </label></td>
                <td colspan='3'>
                    <input type='text' name='url' id='url' value=<?php echo('"' . $bib[$entryname]['url'] . '"'); ?>>
                </td>
            </tr>

            <tr>
                <td colspan='4' style='text-align: center'>
                    <button type='submit' name='submit' class='btn'>Submit</button>
                </td>
            </tr>
            
            <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
            <input type='hidden' name='entryname' id='entryname' value='<?php echo($entryname); ?>'>
            <input type='hidden' name='authors' id='authors' value='<?php echo($authors); ?>'>
        </table>
    </form>


    <div class='left-margin'>
        <h3>Note:</h3>

        <p>Field names in <span style='color: red;'>red</span> are flagged and should be double checked</p>

        <p>For multiple authors, you can use commas. Example for Jane Doe and John Poe:</p>

        <pre><label for='example1'>Surname: </label><input type='text' name='example1' id='example1' value='Doe, Poe' readonly='readonly'> <label for='example2'>Firstname: </label><input type='text' name='example2' id='example2' value='Jane, John' readonly='readonly'></pre>
    </div>

    <br>
</div>

</body>
    
</html>