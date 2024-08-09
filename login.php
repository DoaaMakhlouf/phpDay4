<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once ('header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check input fields are not empty
    if (!(empty($_POST['uname']) && empty($_POST['pass']))) {

        // get users data from DB to check user authorization
        include_once ('dbconnection.php');

        $query = "SELECT * FROM users where username =? && password =?";
        $stmt = $db->prepare($query);
        $stmt->execute([$_POST['uname'], $_POST['pass']]);
        $result = $stmt->fetchAll();

        // If user is authorized, store their credentials and redirect to home page
        if (count($result) > 0) {
            $_SESSION['username'] = $_POST['uname'];
            $_SESSION['password'] = $_POST['pass'];

            // Redirect to home page
            header('Location: home.php');
            exit;
        } else {
            echo 'Invalid username or password';
        }

    } else {
        echo 'Enter username and password';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="post">
        <label for="uname">Username</label>
        <input type="text" name="uname">
        <br><br>
        <label for="pass">Password</label>
        <input type="password" name="pass">
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>

</html>

<?php
include_once ('footer.php');
?>