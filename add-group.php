<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Only echo if the 'name' key is set
    echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
} else {
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}


// Include database connection
require_once 'db_connect.php';

// Add a new group
if (isset($_POST['submit'])) {
    $name = $_POST['group-name'];
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert query
    $stmt = $conn->prepare('INSERT INTO `_group_`(`name`, `user_id`) VALUES (:name, :user_id)');

    try {
        if ($stmt->execute(array(':name' => $name, ':user_id' => $user_id)))
         {
            $_SESSION['success'] = "New group added successfully!";
            header('Location: add-group.php');
            exit();
        }
         else 
        {
            $_SESSION['error'] = "Failed to add group.";
            header('Location: add-group.php');
            exit();
        }
    } catch (PDOException $ex) 
    {
        $_SESSION['error'] = "Error adding group: " . $ex->getMessage();
    }
    

    unset($_SESSION['success']);
    unset($_SESSION['error']);  


    // Redirect to the same page after successful insertion
    header('Location: add-group.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="form-style.css">
    <title>Add Group</title>
</head>
<body>

    <h1>Add Group</h1>
    <form method="post" action="#">

    <?php

        if (isset($_SESSION['error']))
        {
            echo '<div class="alert error"><p>' . $_SESSION['error'] . '</p><span class="close">&times;
            </span></div>';
        } 

        elseif (isset($_SESSION['success'])) 
        {
            echo '<div class="alert success"><p>' . $_SESSION['success'] . '</p><span class="close">&times;
            </span></div>';
        }

        unset($_SESSION['error']);
        unset($_SESSION['success']);
    ?>
    
        <label for="group-name">Group Name:</label>
        <input type="text" name="group-name" id="group-name" required>
        <input type="submit" name="submit" value="Add Group">
        <a class="cancel" href="groups.php" title='back to groups'> groups</a>
    </form>

    <script>
        // Close the alert message
        document.querySelectorAll(".close").forEach(function(closeButton)
        {
            closeButton.addEventListener("click", function(){
                closeButton.parentElement.style.display = "none";  
            });
        });
    </script>
    
</body>
</html>
