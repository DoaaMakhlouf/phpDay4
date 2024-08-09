<?php
include_once ('header.php');
?>

<table width="100%" ; border="1px solid" ;>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Country</th>
        <th>Gender</th>
        <th>Skills</th>
        <th>Username</th>
        <th>Password</th>
        <th>Image</th>
        <th>Department</th>
        <th>Control User</th>
    </tr>

    <?php
    // User can only list users when they are logged in
    include_once ('dbconnection.php');

    // Select users and their skills
    $query = "SELECT users.*, GROUP_CONCAT(skills.skill ORDER BY skills.skill SEPARATOR ', ') AS skills
        FROM users LEFT JOIN skills ON users.id = skills.userid GROUP BY users.id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $row) {

        ?>

        <tr>
            <td>
                <?php echo $row['id']; ?>
            </td>
            <td>
                <?php echo $row['firstname']; ?>
            </td>
            <td>
                <?php echo $row['lastname']; ?>
            </td>
            <td>
                <?php echo $row['address']; ?>
            </td>
            <td>
                <?php echo $row['country']; ?>
            <td>
                <?php echo $row['gender']; ?>
            </td>
            <td>
                <?php echo $row['skills']; ?>
            </td>
            <td>
                <?php echo $row['username']; ?>
            </td>
            <td>
                <?php echo $row['password']; ?>
            </td>
            <td>
                <?php echo $row['image']; ?>
            </td>
            <td>
                <?php echo $row['department']; ?>
            </td>
            <td>
                <a href="updateuser.php?id=<?php echo $row['id']; ?>">Update</a>
                <a href="deleteuser.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>

        <?php
    }
    ?>

</table>

<?php
include_once ('footer.php');
?>