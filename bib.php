<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 0) {
        header('Location: index.php');
    }
    $bibname = $_GET['name'];
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
    <title>Webcite | Edit Bibliography</title>
</head>
    
<body>

<p>

<a href="logout.php">Logout</a>
<a href="bibs.php">Bibliographies</a>

</p>

<?php
    $empty = true;

    foreach ($bib as $key => $content) {

        echo('<table><tr><td>');

        // Authors
        $authors = 0;
        foreach ($content['surname'] as $surname) {
            if ($surname != '') {
                $authors++;
            }
        }
        if ($authors == 1) {
            echo($content['surname'][0] . ', ' . $content['firstname'][0] . '.');
        } else /* if ($authors <= 3) */ {
            for ($i = 0; $i < $authors; $i++) {
                if ($i < $authors - 1) {
                    echo($content['surname'][$i] . ', ' . $content['firstname'][$i] . ', ');
                } else {
                    echo('and ' . $content['surname'][$i] . ', ' . $content['firstname'][$i] . '.');
                }
            }
        }

        // Title
        echo(' "' . $content['title'] . '."');
        
        // Sitename
        if ($content['flag_sitename'] == false) {
            echo('<i> ' . $content['sitename'] . '</i>.');
        }

        // Date
        if ($content['flag_datetime'] == false) {
            echo(' Last modified ' . $content['datetime'] . '.');
        } else {
            echo(' Accessed ' . $content['accessed'] . '.');
        }

        // URL
        echo(' ' . $content['url'] . '.');

        // Edit or deleting the entry

        echo("</td> 
        
            <td><form id='delentry' action='delentry.php' method='post'>
                <input type='hidden' name='delentryname' id='delentryname' value='" . $key . "'>
                <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
                <input type='submit' name='submit' value='delete' onclick='return confirm(\"Are you sure?\");'>
            </form></td>

            <td><form id='editentry' action='editentry.php' method='post'>
            <input type='hidden' name='editentryname' id='editentryname' value='" . $key . "'>
            <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
            <input type='submit' name='submit' value='edit'>
            </form></td>

            </tr></table>
        ");

        echo('<br>');
        $empty = false;
    }

    if ($empty) {
        echo('<p>Your bibliography is empty!</p>');
    } else {
        echo('<br>');
    }
?>

<form id='addentry' action='addentry.php' method='post' accept-charset='UTF-8'>
    <label for='newentry'>New Entry: </label>
    <input type='text' name='url' id='url'>
    <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
    <input type='submit' name='submit' value='submit'>
</form>

<br>

<form id='export' action='export.php' method='post'>
    <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
    <input type='submit' name='export' value='export'>
</form>

</body>
    
</html>