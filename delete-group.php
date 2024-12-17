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

// get teh group id from the url
$groupId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($groupId === false) 
{
    die("Invalid Group ID");
}

// remove group 
if (isset($_POST['submit'])) 
{
    $name = $_POST['group-name'];


    // Prepare and execute the insert query
    $stmt = $conn->prepare('DELETE FROM `_group_` WHERE `id`=:id');

    try {
        if ($stmt->execute(array(':id'=>$groupId)))
         {
            $_SESSION['success'] = "Group deleted!";
            header('Location: delete.php');
            exit();
        }
         else 
        {
            $_SESSION['error'] = "group not deleted";
            header('Location: delete.php');
            exit();
        }
    } catch (PDOException $ex) 
    {
        $_SESSION['error'] = "group not deleted" . $ex->getMessage();
    }
    

    unset($_SESSION['success']);
    unset($_SESSION['error']);  


    // Redirect to the same page after successful insertion
    header('Location: delete.php');
    exit();
}

/* 
add a foreign key contraint to the group_id column in the _contacts_ table,
referencing the id column in the _groups_ table,
the ON DELETE CASCADE option ensures that when a group its defected,
all contacts associated with that group will also be deleted

ALTER TABLE _contact_
ADD FOREIGN KEY (group_id) REFERENCIES _group_(id) ON DELETE CASCADE

*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="form-style.css">
    <title>Remove Group</title>   
    <style>

    input[type="submit"]{background-color: #f44336; width:45%;}

    input[type="submit"]:hover{background-color: #e53935;}

    </style>
</head>
<body>

    <h1>Remove Group</h1>
    <form method="post" action="#">
    <p class="confirm">Are you sure you want to delete this group?</p>
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

    <input type="submit" name="submit" value="Delete Group">
    <a class="cancel" href="groups.php" title='back to groups'> Cancel</a>
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
