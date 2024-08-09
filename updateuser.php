<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once ('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Validate input
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $userId = intval($_GET['id']);

        include_once ('dbconnection.php');

        // Get user data from DB and send them to registeration form fields
        $query = "SELECT * FROM users where users.id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        $result = $stmt->fetchAll();

        foreach ($result as $row) {

            ?>

            <form method="post" enctype="multipart/form-data">
                <label for="fname">First Name</label>
                <input type="text" name="fname" value="<?php echo $row['firstname'] ?>">
                <br><br>
                <label for="lname">Last Name</label>
                <input type="text" name="lname" value="<?php echo $row['lastname'] ?>">
                <br><br>
                <label for="address">Address</label>
                <textarea name="address" value="<?php echo $row['address'] ?>"></textarea>
                <br><br>
                <label for="country">Country</label>
                <select name="country" value="<?php echo $row['country'] ?>">
                    <option value="Egy">Egypt</option>
                    <option value="Pal">Palestine</option>
                    <option value="Sud">Sudan</option>
                    <option value="Syr">Syria</option>
                </select>
                <br><br>
                <label for="gender">Gender</label>
                <input type="radio" name="gender" value="<?php echo $row['gender'] ?>">
                <label for="gender">Male</label>
                <input type="radio" name="gender" value="<?php echo $row['gender'] ?>">
                <label for="gender">Female</label>
                <br><br>
                <label>Skills</label>
                <input type="checkbox" name="skills[]" value="<?php echo $row['skills'] ?>">
                <label>PHP</label>
                <input type="checkbox" name="skills[]" value="<?php echo $row['skills'] ?>">
                <label>J2SE</label>
                <br><br>
                <input type="checkbox" name="skills[]" value="<?php echo $row['skills'] ?>">
                <label>MySQL</label>
                <input type="checkbox" name="skills[]" value="<?php echo $row['skills'] ?>">
                <label>PostgreeSQL</label>
                <br><br>
                <label for="uname">Username</label>
                <input type="text" name="uname" value="<?php echo $row['username'] ?>">
                <br><br>
                <label for="pass">Password</label>
                <input type="password" name="pass">
                <br><br>
                <label for="myImg">Upload Image</label>
                <input type="file" name="myImg" value="<?php echo $row['image'] ?>">
                <br><br>
                <label for="dep">Department</label>
                <input type="text" name="dep" placeholder="OpenSource" value="<?php echo $row['department'] ?>">
                <br><br>
                <input type="submit" value="Update">
                <input type="Reset">
            </form>

            <?php

        }

        // Update user data
        $userssql = 'UPDATE users set firstname = ?, lastname = ?, address = ?, country = ?,
         gender = ?, username = ?, password = ?, image = ?, department = ? WHERE id = ?';
        $stmt = $db->prepare($userssql);

        $stmt->execute([$userId]);
        $result = $stmt->rowCount();

        if ($result > 0) {
            echo 'User updated successfully.';
        } else {
            echo 'No user found with the provided ID.';
        }
    } else {
        echo 'Invalid user ID.';
    }
}
?>
<?php include_once ('footer.php'); ?>