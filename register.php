<?php
// Include the database connection file
include("database.php");

// Initialize variables for error messages
$username = '';
$password = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Sanitize user input
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if (empty($username)) {
        $error_message = "Please enter a username.";
    } elseif (empty($password)) {
        $error_message = "Please enter a password.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(user, password) VALUES ('$username', '$hash')";
        
        try {
            mysqli_query($conn, $sql);
            $error_message = "Registration successful!"; // Successful registration message
        } catch (mysqli_sql_exception $e) {
            $error_message = "That username is taken."; // Error handling
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Basic Reset */
        body, h2, p {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f0f0; /* Light background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
        }

        .register-container {
            background-color: white; /* White background for the form */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Fixed width */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Dark text color */
        }

        .form-group {
            margin-bottom: 15px; /* Space between fields */
        }

        label {
            display: block;
            margin-bottom: 5px; /* Space between label and input */
            color: #555; /* Grey label color */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%; /* Full width */
            padding: 10px;
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in width */
        }

        input[type="submit"] {
            background-color: #007bff; /* Primary button color */
            color: white; /* White text color */
            padding: 10px;
            border: none; /* No border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            width: 100%; /* Full width */
            font-size: 16px; /* Larger text */
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker on hover */
        }

        .error-message {
            color: red; /* Red for error messages */
            margin-top: 10px; /* Space above error messages */
            text-align: center; /* Center the error message */
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Welcome to Yahoo!</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <input type="submit" name="register" value="Register">
    </form>

    <!-- Display any error messages -->
    <p class="error-message"><?php echo $error_message; ?></p>
</div>

<?php
// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
