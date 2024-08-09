<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once ('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Validate input
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $userId = intval($_GET['id']);

        include_once ('dbconnection.php');

        $userssql = 'DELETE FROM users WHERE id = ?';
        $stmt = $db->prepare($userssql);

        $stmt->execute([$userId]);
        $result = $stmt->rowCount();

        if ($result > 0) {
            echo 'User deleted successfully.';
        
        } else {
            echo 'No user found with the provided ID.';
        }

    } else {
        echo 'Invalid user ID.';
    }
}

include_once ('footer.php');
?>