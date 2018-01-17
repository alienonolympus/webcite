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
</head>

<body>

<p><a href="auth/logout.php">Logout</a></p>

<form id='addbib' action='bibfn/addbib.php' method='post' accept-charset='UTF-8'>
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
    <input type='text' name='newbib' id='newbib' maxlength='50'>
    <input type='submit' name='submit' value='submit'>
</form>

<p>
<?php
    echo('Hello, ' . $_SESSION['username']);
?>
. Here are your bibliographies:
</p>

<?php
    $json = file_get_contents('./bib.json');
    $json_data = json_decode($json, true);
    $bibs = $json_data[$_SESSION['username']];
    $empty = true;

    foreach ($bibs as $bib => $content) {
        if ($bib != 'password') {
            echo('<table><tr><td>' . $bib . '</td>' . "

                <td><form id='delbib' action='bibfn/delbib.php' method='post'>
                    <input type='hidden' name='delbibname' id='delbibname' value='" . $bib . "'>
                    <input type='submit' name='submit' value='delete' onclick='return confirm(\"Are you sure?\");'>
                </form></td>

                <td><form id='editbib' action='bibfn/editbib.php' method='post'>
                <input type='hidden' name='editbibname' id='editbibname' value='" . $bib . "'>
                <input type='submit' name='submit' value='edit'>
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

</body>

</html>
