<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
   
    echo $_SESSION['email'];
} else {
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}


require_once "db_connect.php";

//get the user groups
//Query to retrieve group 
$sql = "SELECT * FROM `_group_` WHERE `user_id` =:user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id );
$stmt->execute();


// Include database connection
require_once 'db_connect.php';

// Fetch groups from the database
$groups = [];
try {
    $stmt = $conn->prepare('SELECT `id`, `name` FROM `_group_` WHERE `user_id` = :user_id');
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching groups: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="contact-style.css">
    <title>My Groups</title>
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

        <!-- Page Header -->
        <h1>My Groups</h1>

        <div class="search">
            <form action="#" method="post">
                <input type="search" name="search" placeholder="Search Groups...">
                <button type="submit" name="search-submit">Search</button>
            </form>
        </div> 

        <!-- Groups Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Group Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($groups)): ?>
                    <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($group['id']); ?></td>
                            <td><?php echo htmlspecialchars($group['name']); ?></td>
                            <td>
                                
                                <a href="edit-group.php?id=<?php echo $group['id']; ?>" class="icon icon-edit" title="Edit"></a>
                                <a href="delete-group.php?id=<?php echo $group['id']; ?>" class="icon icon-delete" title="Delete"></a>
                            </td>
                            </tr>
                            <?php 
                            // Generate table rows
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
                            {
                                echo "<tr>";
                                echo "<td>" .$row['id']."</td>";
                                echo "<td>" .$row['name']."</td>";
                                echo "<td>";
                                echo "<a href=edit-group.php?id=".$row['id'] . "'class='icon icon-edit' title='Edit'></a>";
                                echo "<a href=delete.php?id=".$row['id'] . "'class='icon icon-delete' title='Delete'></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                            
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No groups found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Add Group Button -->
        <div class="icon-add-container">
            <a href="add-group.php" class="icon icon-add" title="Add Group">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</body>
</html>
