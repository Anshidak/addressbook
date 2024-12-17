 <?php
// Start the session
session_start();

// Include the database connection file
require_once("db_connect.php");

// Redirect if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: contact.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // Check if email and password are provided
    if (!empty($email) && !empty($password)) {
        try {
            // Prepare the SQL query to check for the user in the database
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Compare the entered password with the stored plain text password
                if ($password === $result['password']) {  // Direct comparison for plain text passwords
                    $_SESSION['user_id'] = $result['id']; // Store the user ID in the session
                    $_SESSION['email'] = $result['email']; 
                    header("Location: contact.php");  // Redirect to the contact page
                    exit();
                } else {
                    $_SESSION['error'] = "Incorrect email or password!";
                    header('Location: login.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "No user found with that email!";
                header('Location: login.php');
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Email and password are required!";
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="lg_rg_style.css">
    <title>Login Form</title>
</head>
<body>
    <div class="signup-wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="signup-form">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert error"><p>' . $_SESSION['error'] . '</p><span class="close">&times;</span></div>';
                unset($_SESSION['error']);
            }
            ?>

            <h1>Sign in</h1>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>

            <p>Don't have an account yet? <a href="register.php">Sign up</a></p>
        </form>
    </div>

    <script>
        // Close the alert message
        document.querySelectorAll(".close").forEach(function(closeButton){
            closeButton.addEventListener("click", function(){
                closeButton.parentElement.style.display = "none";  
            });
        });
    </script>
</body>
</html>
