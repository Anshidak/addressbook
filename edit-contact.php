<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Only echo if the 'name' key is set
    echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
} else 
{
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}


// Include database connection
require_once 'db_connect.php';

$user_id = $_SESSION['user_id'];

//get the user groups
//Query to retrieve group names
$sql = "SELECT * FROM `_group_` WHERE `user_id` =:user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id );
$stmt->execute();

//generate options for select elements
$options = '';

// get teh contact id from the url
$contactId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($groupId === false) 
{
    die("Invalid Contact ID");
}
$name = '';
$email = '';
$phone = '';
$address = '';
$groupId = '';

$select_query = "SELECT * FROM `_contact_` WHERE `id`=:contact_id";
$stmt2 = $conn->prepare($select_query);
$stmt2->bindParam(':contact_id',$groupId);
$stmt2->execute();
$result = $stmt2->fetch(PDO::FETCH_ASSOC);
if($result)
{
    $name = $result['name'];
    $email = $result['email'];
    $phone = $result['phone'];
    $address = $result['address'];
    $groupId = $result['group_id'];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        //$selected = select the contact group
        $selected = $result['group_id'] == $row['id'] ? 'selected="selected"':'';
        $options .= '<option value="' . $row['id'] . '" name="group_id" '.$selected.'>' 
                                      . $row['name'].'</option>';
    }    
}


// Add a new contact
if (isset($_POST['submit'])) 
{
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $group_id = $_POST['group'];
    //   $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert query
    $stmt = $conn->prepare('INSERT INTO `_contact_` SET `name` =:name,`email`=:email, `phone`=:phone, `address`=:address, `group_id`= :group_id WHERE `id`=:id');

    try {
        if ($stmt->execute(array(':name' => $name, ':email' => $email, ':phone' => $phone, ':address' => $address, ':group_id' => $group_id, ':id' => $contactId)))
         {
            $_SESSION['success'] = "contact info updated!";
            header('Location: edit-contact.php');
            exit();
        }
         else 
        {
            $_SESSION['error'] = "contact info not updated";
            header('Location: edit-contact.php');
            exit();
        }
    } catch (PDOException $ex) 
    {
        $_SESSION['error'] = "contact not updated: " . $ex->getMessage();
    }
    

    unset($_SESSION['success']);
    unset($_SESSION['error']);  


    // Redirect to the same page after successful insertion
    header('Location: edit-contact.php');
    exit();  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="form-style.css">
    <title>Edit Contact</title>
</head>
<body>
     <h1>Edit Contact</h1>
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

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email ?>" required>

        <label for="phone">phone:</label>
        <input type="tel" name="phone" id="phone" value="<?php echo $phone ?>"required>

        <label for="address">Address:</label>
        <textarea name ="address" id="address"rows="4" required><?php echo $address ?></textarea>

        <label for="group">Group:</label>

        <!-- HTML select elements with generated options -->

        <select name="group" id="group">
            <option value="">--select a Group--</option>


        <!--populate options dynamically from the databse!-->
            <?php
               echo $options;
            ?>
            
        </select>
    <input type="submit" name="submit"value="Edit Contact">
    <a class="cancel" href="contacts.php" title='contacts'> Contacts</a>
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