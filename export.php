<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 0) {
        header('Location: index.php');
    }
    $bibname = $_POST['bibname'];
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

    <div class='export'>
        <?php
            $empty = true;

            $sort_template1 = array();
            $sort_template2 = array();

            foreach ($bib as $key => $content) {
                $cite = '';

                // Authors
                $authors = 0;
                foreach ($content['surname'] as $surname) {
                    if ($surname != '') {
                        $authors++;
                    }
                }
                if ($authors == 1) {
                    $cite = $cite . $content['surname'][0] . ', ' . $content['firstname'][0] . '. ';
                } else /* if ($authors <= 3) */ {
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
                
                // Sitename
                if ($content['sitename']) {
                    $cite = $cite . '<i> ' . $content['sitename'] . '</i>.';
                }

                // Date
                if ($content['datetime']) {
                    $cite = $cite . ' Last modified ' . $content['datetime'] . '.';
                } else {
                    $cite = $cite . ' Accessed ' . $content['accessed'] . '.';
                }

                // URL
                $cite = $cite . ' ' . $content['url'] . '.';
                array_push($sort_template1, $cite);
                $cite = ucfirst(str_replace('"', '', $cite));
                array_push($sort_template2, $cite);
                $empty = false;
            }

            asort($sort_template2);
            
            $bibliography = array();

            foreach ($sort_template2 as $key => $content) {
                $bibliography[$key] = $sort_template1[$key];
            }

            foreach ($bibliography as $entry) {
                echo($entry);
                echo('<br>');
            }

            if ($empty) {
                echo('<p>Your bibliography is empty!</p>');
            } else {
                echo('<br>');
            }
        ?>
    </div>
</div>
</body>
    
</html>