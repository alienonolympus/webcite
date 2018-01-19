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
    <link rel='stylesheet' type='text/css' href='../css/main.css'>
    <link rel="icon" type="image/x-icon" href="css/favicon.ico">
</head>
    
<body>
<div class='container'>
    <div class='header'>
        <a href='auth/logout.php'>Logout(<?php echo($_SESSION['username'])?>)</a>
        <span> > </span> 
        <a href="bibs.php">Bibliographies</a>
    </div>

    <form id='addentry' action='bibfn/addentry.php' method='post' accept-charset='UTF-8' class='enter'>
        <label for='newentry'>New Entry: </label>
        <input type='text' name='url' id='url' style='width: 60%'>
        <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
        <button type='submit' name='submit' class='btn'>Submit</button>
    </form>

    <?php
        $empty = true;

        echo("
            <table class='entries' rules=rows>
            <col width='80%'>
            <col width='10%'>
            <col width='10%'>
        ");

        foreach ($bib as $key => $content) {

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
            if ($content['sitename']) {
                $cite = $cite . '<i> ' . $content['sitename'] . '</i>.';
                $footnote = $footnote . '<i> ' . $content['sitename'] . '</i>,';
            }

            // Date
            if ($content['datetime']) {
                $cite = $cite . ' Last modified ' . $content['datetime'] . '.';
                $footnote = $footnote . ' last modified ' . $content['datetime'] . ',';
            } else {
                $cite = $cite . ' Accessed ' . $content['accessed'] . '.';
                $footnote = $footnote . ' accessed ' . $content['accessed'] . ',';
            }

            // URL
            $cite = $cite . ' ' . $content['url'] . '.';
            $footnote = $footnote . ' ' . $content['url'] . '.';

            // Edit or deleting the entry

            echo("
                <tr><td rowspan='2'>" . $cite . "</td> 
            
                <td><form id='delentry' action='bibfn/delentry.php' method='post'>
                    <input type='hidden' name='delentryname' id='delentryname' value='" . $key . "'>
                    <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
                    <button type='submit' name='submit' class='btn btnsmall'  onclick='return confirm(\"Are you sure?\");'>Delete</button>
                </form></td>

                <td><form id='editentry' action='editentry.php' method='post'>
                <input type='hidden' name='editentryname' id='editentryname' value='" . $key . "'>
                <input type='hidden' name='bibname' id='bibname' value='" . $bibname . "'>
                <button type='submit' name='submit' class='btn btnsmall'>Edit</button>
                </form></td></tr>

                <tr>
                
                <td><button id='copy-entry-" . $key . "' class='btn btnsmall'>Entry</button></td>
                <td><button id='copy-footnote-" . $key . "' class='btn btnsmall'>Footnote</button></td>

                </tr>

                <script>
                    document.getElementById('copy-entry-" . $key . "').addEventListener('click', function() {
                        var resultField = document.getElementById('copy-result');
                        var dt = new clipboard.DT();

                        var plain = '" . $cite . "'.replace('<i>', '').replace('</i>', '');

                        dt.setData('text/plain', plain);
                        dt.setData('text/html', '" . $cite . "');

                        clipboard.write(dt).then(function(){
                            resultField.textContent = 'Copied entry!';
                        }, function(err){
                            resultField.textContent = err;
                        });
                    });
                    document.getElementById('copy-footnote-" . $key . "').addEventListener('click', function() {
                        var resultField = document.getElementById('copy-result');
                        var dt = new clipboard.DT();

                        var plain = '" . $footnote . "'.replace('<i>', '').replace('</i>', '');

                        dt.setData('text/plain', plain);
                        dt.setData('text/html', '" . $footnote . "');

                        clipboard.write(dt).then(function(){
                            resultField.textContent = 'Copied footnote!';
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
        echo('</table>')
    ?>

    <p id='copy-result'>Entry and Footnote will copy the entry and footnote of that source respectively.</p>

    <form id='export' action='export.php' method='post'>
        <input type='hidden' name='bibname' id='bibname' value='<?php echo($bibname); ?>'>
        <div style='text-align: center;'>
            <button type='submit' name='export' class='btn btnlarge'>Export Bibliography</button>
        </div>
    </form>

    <br>
</div>
</body>
    
</html>