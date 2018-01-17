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
    <script src='js/clipboard-polyfill.js'></script>
</head>
    
<body>

<p>

<a href="auth/logout.php">Logout</a>
<a href="bibs.php">Bibliographies</a>

</p>

<form id='addentry' action='bibfn/addentry.php' method='post' accept-charset='UTF-8'>
    <label for='newentry'>New Entry: </label>
    <input type='text' name='url' id='url'>
    <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
    <input type='submit' name='submit' value='submit'>
</form>

<?php
    $empty = true;

    echo('<table>');

    foreach ($bib as $key => $content) {

        echo('<tr><td>');

        $cite = '';
        $footnote = '';
        
        // Authors
        $authors = 0;
        foreach ($content['surname'] as $surname) {
            if ($surname != '') {
                $authors++;
            }
        }
        if ($authors == 1) {
            $cite = $cite . $content['surname'][0] . ', ' . $content['firstname'][0] . '. ';
            $footnote = $footnote . $content['firstname'][0] . ' ' . $content['surname'][0] . ', ';
        } else {
            if ($authors <= 3) {
                for ($i = 0; $i < $authors; $i++) {
                    $footnote = $footnote . $content['firstname'][$i] . ' ' . $content['surname'][$i] . ', ';
                }
            } else {
                $footnote = $footnote . $content['firstname'][0] . ' ' . $content['surname'][0] . ' et al. ';
            }
            for ($i = 0; $i < $authors; $i++) {
                if ($i < $authors - 1) {
                    $cite = $cite . $content['surname'][$i] . ', ' . $content['firstname'][$i] . ', ';
                } else {
                    $cite = $cite . 'and ' . $content['surname'][$i] . ', ' . $content['firstname'][$i] . '. ';
                }
            }
        }

        // Title
        $cite = $cite . '"' . $content['title'] . '."';
        $footnote = $footnote . '"' . $content['title'] . ',"';
        
        // Sitename
        if ($content['flag_sitename'] == false) {
            $cite = $cite . '<i> ' . $content['sitename'] . '</i>.';
            $footnote = $footnote . '<i> ' . $content['sitename'] . '</i>,';
        }

        // Date
        if ($content['flag_datetime'] == false) {
            $cite = $cite . ' Last modified ' . $content['datetime'] . '.';
            $footnote = $footnote . ' last modified ' . $content['datetime'] . ',';
        } else {
            $cite = $cite . ' Accessed ' . $content['accessed'] . '.';
            $footnote = $footnote . ' accessed ' . $content['accessed'] . ',';
        }

        // URL
        $cite = $cite . ' ' . $content['url'] . '.';
        $footnote = $footnote . ' ' . $content['url'] . '.';

        echo($cite);

        // Edit or deleting the entry

        echo("</td> 
        
            <td><form id='delentry' action='bibfn/delentry.php' method='post'>
                <input type='hidden' name='delentryname' id='delentryname' value='" . $key . "'>
                <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
                <input type='submit' name='submit' value='delete' onclick='return confirm(\"Are you sure?\");'>
            </form></td>

            <td><form id='editentry' action='editentry.php' method='post'>
            <input type='hidden' name='editentryname' id='editentryname' value='" . $key . "'>
            <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
            <input type='submit' name='submit' value='edit'>
            </form></td>

            <td><button id='copy-entry-" . $key . "'>copy entry</button></td>
            <td><button id='copy-footnote-" . $key . "'>copy footnote</button></td>
            <td><span id='copy-result-" . $key . "'></span></td>

            </tr>

            <script>
                document.getElementById('copy-entry-" . $key . "').addEventListener('click', function() {
                    var resultField = document.getElementById('copy-result-" . $key . "');
                    var dt = new clipboard.DT();

                    var plain = '" . $cite . "'.replace('<i>', '').replace('</i>', '');

                    dt.setData('text/plain', plain);
                    dt.setData('text/html', '" . $cite . "');

                    clipboard.write(dt).then(function(){
                        resultField.textContent = 'copied entry';
                    }, function(err){
                        resultField.textContent = err;
                    });
                });
                document.getElementById('copy-footnote-" . $key . "').addEventListener('click', function() {
                    var resultField = document.getElementById('copy-result-" . $key . "');
                    var dt = new clipboard.DT();

                    var plain = '" . $footnote . "'.replace('<i>', '').replace('</i>', '');

                    dt.setData('text/plain', plain);
                    dt.setData('text/html', '" . $footnote . "');

                    clipboard.write(dt).then(function(){
                        resultField.textContent = 'copied footnote';
                    }, function(err){
                        resultField.textContent = err;
                    });
                });
            </script>
        ");
        $empty = false;
    }

    if ($empty) {
        echo('<p>Your bibliography is empty!</p>');
    }
?>

<tr>
    <td colspan='5'>
    <form id='export' action='export.php' method='post'>
        <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
        <input type='submit' name='export' value='export bibliography'>
    </form>
    </td>
</tr>
</table>
</body>
    
</html>