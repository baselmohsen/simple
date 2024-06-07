<?php

@include 'config.php';

if (isset($_POST['submit'])) {

    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Hash the password using password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Query to check if user already exists
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($password != $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            // Insert the new user into the database
            $insert = "INSERT INTO user_form(name, email, password) VALUES('$name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert)) {
                header('Location: login_form.php');
            } else {
                $error[] = 'Error in registration. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>Register Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error_message) {
                    echo '<span class="error-msg">' . $error_message . '</span>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>

    </div>

</body>

</html>
