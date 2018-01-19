<!DOCTYPE html>
<html>
<?php
    session_start();
    if ($_SESSION['access'] == 0) {
        header('Location: index.php');
    }
?>

<head>
    <title>Webcite | Bibliographies</title>
    <link rel='stylesheet' type='text/css' href='../css/main.css'>
</head>

<body>

<div class='container'>

    <div class='header'>
        <a href='auth/logout.php' class='headerlink'>Logout(<?php echo($_SESSION['username'])?>)</a>
    </div>

    <form id='addbib' action='bibfn/addbib.php' method='post' accept-charset='UTF-8' class='enter'>
        <?php
            $error = $_GET['error'];
            if ($error == 1) {
                echo('
                    <p>
                        An error has occured, the following may have occured:
                        <ul>
                            <li>The bibliography name is not unique.</li>
                        </ul>
                    </p>
                ');
            }
        ?>
        <label for='newbib'>New Bibliography: </label>
        <input type='text' name='newbib' id='newbib' style='width: 70%'>
        <button type='submit' name='submit' class='btn'>Submit</button>
    </form>
    <?php
        $json = file_get_contents('./bib.json');
        $json_data = json_decode($json, true);
        $bibs = $json_data[$_SESSION['username']];
        $empty = true;

        foreach ($bibs as $bib => $content) {
            if ($bib != 'password') {
                echo('<table>
                    <col width="80%">
                    <col width="10%">
                    <col width="10%">
                    <tr class="bibs">
                        <td>' . $bib . '</td>' . "

                        <td><form id='delbib' action='bibfn/delbib.php' method='post'>
                            <input type='hidden' name='delbibname' id='delbibname' value='" . $bib . "'>
                            <button type='submit' name='submit' class='btn'  onclick='return confirm(\"Are you sure?\");'>Delete</button>
                        </form></td>

                        <td><form id='editbib' action='bibfn/editbib.php' method='post'>
                        <input type='hidden' name='editbibname' id='editbibname' value='" . $bib . "'>
                        <button type='submit' name='submit' class='btn'>Edit</button>
                        </form></td>
                    </tr></table>
                ");
                $empty = false;
            }
        }

        if ($empty) {
            echo('<p>You have no bibliographies!</p>');
        }
    ?>

    <br>

</div>
</body>

</html>
