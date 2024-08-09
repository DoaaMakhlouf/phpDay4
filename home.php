<?php
session_start();

include_once ('header.php');

if (isset($_SESSION['username'])) {
    echo 'Welcome ' . $_SESSION['username'];
} else {
    echo 'Please login';
    header('Location: login.php');
    exit;
}
?>

<br><br>
<a href="listusers.php">List User Data</a>

<?php
include_once('footer.php');
?>