<?php
// Start the session
session_start();

// Include the database connection file
require_once("db_connect.php");

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Sanitize inputs
    $fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    try {
        // Check if the email already exists
        $email_check_query = "SELECT * FROM `users` WHERE `email` = :email";
        $stmt = $conn->prepare($email_check_query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Error: Email already exists.";
            header('Location: register.php');
            exit();
        }

        // Error if the password is less than 8 characters
        if(strlen($password) < 8){
            $_SESSION['error'] = "Password must be at least 8 characters long!";
            header('Location: register.php');
            exit();
        }

        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database with hashed password
        $insert_query = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // Use hashed password
        $stmt->execute();

        $_SESSION['success'] = 'Account created successfully!';
        header('Location: login.php');  // Redirect to the login page
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        header('Location: register.php');
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
    <title>Sign Up Form</title>
</head>
<body>
    <div class="signup-wrapper">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="signup-form">

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert error"><p>' . $_SESSION['error'] . '</p><span class="close">&times;</span></div>';
                unset($_SESSION['error']);
            } 
            elseif (isset($_SESSION['success'])) {
                echo '<div class="alert success"><p>' . $_SESSION['success'] . '</p><span class="close">&times;</span></div>';
                unset($_SESSION['success']);
            }
            ?>

            <h1>Sign Up</h1>

            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit" name="submit">Signup</button>
            </div>

            <p>Already have an account? <a href="login.php">Login</a></p>
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
