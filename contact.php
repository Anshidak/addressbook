<?php
session_start();

 if (!isset($_SESSION['user_id'])) 
{
    // Redirect to login if session is not set
    header('Location: add-contact.php');
    exit();
}

// Now it's safe to use $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

require_once "db_connect.php";

try { 

/* if (isset($_SESSION['user_id']))
{
    echo $_SESSION['email'];
}
else
{
    header('Location: login.php');
}

require_once "db_connect.php";

$user_id = $_SESSION['user_id']; */

    // Query to retrieve contacts
    $sql = "SELECT 
                _contact_.id, 
                _contact_.name, 
                _contact_.email, 
                _contact_.phone, 
                _contact_.address, 
                _group_.name as 'group' 
            FROM _contact_ 
            INNER JOIN _group_ ON _contact_.group_id = _group_.id 
            WHERE _contact_.user_id = :user_id";

    if (isset($_POST['search-submit'])) {
        $searchValue = $_POST['search-value'];
        $sql = "SELECT 
                    _contact_.id, 
                    _contact_.name, 
                    _contact_.email, 
                    _contact_.phone, 
                    _contact_.address, 
                    _group_.name as 'group' 
                FROM _contact_ 
                INNER JOIN _group_ ON _contact_.group_id = _group_.id 
                WHERE (
                    _contact_.name LIKE :searchValue OR 
                    _contact_.email LIKE :searchValue OR 
                    _contact_.phone LIKE :searchValue OR 
                    _contact_.address LIKE :searchValue OR
                    _group_.name LIKE :searchValue
                ) AND _contact_.user_id = :user_id";
    }

    $stmt = $conn->prepare($sql);

    if (isset($searchValue)) {
        $searchValue = '%' . $searchValue . '%';
        $stmt->bindParam(':searchValue', $searchValue);
    }

    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

}
    
     catch (PDOException $e) {
    echo "Error fetching contacts: " . $e->getMessage();
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="contact-style.css">
    <title>My Contacts</title>
</head>
<body>
    <div class="container">
        <!-- Navigation menu -->
        <nav class="menu">
            <ul>
                <li><a href="groups.php">Groups</a></li>
                <li><a href="contact.php">Contacts</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h1>My Contacts</h1>

        <div class="search">
            <form action="#" method="post">
                <input type="search" name="search-value" placeholder="Search contacts...">
                <button type="submit" name="search-submit">Search</button>
            </form>
        </div> 

        <!-- Groups Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Group</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) 
                {
                    echo "<tr>";
                    echo "<td>" .$row['name']."</td>";
                    echo "<td>" .$row['email']."</td>"; 
                    echo "<td>" .$row['phone']."</td>";
                    echo "<td>" .$row['address']."</td>";
                    echo "<td>" .$row['group']."</td>";
                    echo "<td>";
                    echo "<a href=edit-contact.php?id=".$row['id']." class='icon icon-edit' title='edit'></a>";
                    echo "<a href=delete-contact.php?id=".$row['id']." class='icon icon-delete' title='remove'></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="icon-add-container">
            <a href="add-contact.php" class="icon icon-add" title="Add Contact">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</body>
</html>
