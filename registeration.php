<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Error handling for image uploading
    if ($_FILES['myImg']['error'] > 0) {
        echo 'Problem: ';
        switch ($_FILES['myImg']['error']) {
            case 1:
                echo 'File exceeded upload_max_filesize';
                break;
            case 2:
                echo 'File exceeded max_file_size';
                break;
            case 3:
                echo 'File only partially uploaded';
                break;
            case 4:
                echo 'No file uploaded';
                break;
            case 6:
                echo 'Cannot upload file: No temp directory specified';
                break;
            case 7:
                echo 'Upload failed: Cannot write to disk';
                break;
            case 8:
                echo 'A PHP extension stopped the file upload.';
        }
    }

    // Change image path to a new secured one
    $image = $_FILES['myImg'];
    $upimg = 'uploads/' . $_FILES['myImg']['name'];

    // Validate the uploaded file as an image
    if (getimagesize($image['tmp_name']) === false) {
        echo 'Problem: file is not image';
    }
    if (is_uploaded_file($_FILES['myImg']['tmp_name'])) {
        if (!move_uploaded_file($_FILES['myImg']['tmp_name'], $upimg)) {
            echo 'Problem: Could not move file to destination directory';
        }
    } else {
        echo 'Problem: Possible file upload attack. Filename: ';
        echo $_FILES['myImg']['name'];
    }

    include_once ('dbconnection.php');

    // Add users
    $userssql = 'INSERT INTO users (firstname, lastname, address, country, gender, username, password, image, department)
                VALUES (?,?,?,?,?,?,?,?,?)';

    $stmt = $db->prepare($userssql);
    $stmt->execute([
        $_POST['fname'],
        $_POST['lname'],
        $_POST['address'],
        $_POST['country'],
        $_POST['gender'],
        $_POST['uname'],
        $_POST['pass'],
        $upimg,
        $_POST['dep']
    ]);

    $result = $stmt->rowCount();

    $userid = $db->lastInsertId();
    echo 'User added successfully ' . $result;

    // Add skills
    $skillssql = 'INSERT INTO skills (userid, skill) VALUES (?,?)';

    $stmt = $db->prepare($skillssql);

    foreach ($_POST['skills'] as $key => $skill) {
        $stmt->execute([
            $userid,
            $skill
        ]);
    }

    $result = $stmt->rowCount();
    echo '<br> Skills added successfully ' . $result;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration</title>
</head>

<body>
    <?php include_once ('header.php'); ?>
    <form method="post" enctype="multipart/form-data">
        <label for="fname">First Name</label>
        <input type="text" name="fname">
        <br><br>
        <label for="lname">Last Name</label>
        <input type="text" name="lname">
        <br><br>
        <label for="address">Address</label>
        <textarea name="address"></textarea>
        <br><br>
        <label for="country">Country</label>
        <select name="country">
            <option value="Egy">Egypt</option>
            <option value="Pal">Palestine</option>
            <option value="Sud">Sudan</option>
            <option value="Syr">Syria</option>
        </select>
        <br><br>
        <label for="gender">Gender</label>
        <input type="radio" name="gender" value="m">
        <label for="gender">Male</label>
        <input type="radio" name="gender" value="f">
        <label for="gender">Female</label>
        <br><br>
        <label>Skills</label>
        <input type="checkbox" name="skills[]" value="PHP">
        <label>PHP</label>
        <input type="checkbox" name="skills[]" value="J2SE">
        <label>J2SE</label>
        <br><br>
        <input type="checkbox" name="skills[]" value="MySQL">
        <label>MySQL</label>
        <input type="checkbox" name="skills[]" value="PostgreeSQL">
        <label>PostgreeSQL</label>
        <br><br>
        <label for="uname">Username</label>
        <input type="text" name="uname">
        <br><br>
        <label for="pass">Password</label>
        <input type="password" name="pass">
        <br><br>
        <label for="myImg">Upload Image</label>
        <input type="file" name="myImg">
        <br><br>
        <label for="dep">Department</label>
        <input type="text" name="dep" placeholder="OpenSource">
        <br><br>
        <input type="submit" value="Register">
        <input type="Reset">
    </form>
    <?php include_once ('footer.php'); ?>
</body>

</html>