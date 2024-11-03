<?php 
// Start the session to handle user sessions
session_start(); 

// Include the database configuration and model functions for database interactions
require_once 'core/dbConfig.php'; 
require_once 'core/models.php';

// Redirect to the homepage if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the index page
    exit(); // Stop further script execution
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the registerUser function and handle the response
    $registrationResult = registerUser($pdo, $username, $password);
    if ($registrationResult === true) {
        header("Location: login.php"); // Redirect to login after successful registration
        exit();
    } else {
        $errorMessage = $registrationResult; // Store the error message for display
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>Register</title> <!-- Title of the registration page -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Set font styles */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Add padding */
            background-color: #0e0e0e; /* Dark background */
            color: #e0e0e0; /* Light text color */
        }
        h1 {
            color: #ff4c00; /* Header color for the title */
        }
        form {
            background: #1c1c1c; /* Darker background for the form */
            padding: 20px; /* Padding inside the form */
            border-radius: 5px; /* Rounded corners for the form */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Add shadow for depth */
            margin-bottom: 20px; /* Space below the form */
        }
        label {
            display: block; /* Ensure labels are block elements */
            margin-bottom: 5px; /* Space between label and input */
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%; /* Full width for input fields */
            padding: 8px; /* Padding inside the input fields */
            margin-bottom: 10px; /* Space below each input field */
            border: 1px solid #444; /* Dark border for input fields */
            border-radius: 4px; /* Rounded corners for input fields */
            background-color: #222; /* Darker background for input fields */
            color: #e0e0e0; /* Light text color for input fields */
        }
        input[type="submit"] {
            background-color: #ff4c00; /* Button background color */
            color: white; /* Text color for the button */
            border: none; /* No border for the button */
            padding: 10px; /* Padding inside the button */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Change cursor to pointer on hover */
        }
        input[type="submit"]:hover {
            background-color: #ff6f00; /* Lighter orange when hovering over the button */
        }
    </style>
</head>
<body>
    <h1>Register</h1> <!-- Title for the registration form -->
    <form action="register.php" method="POST"> <!-- Form that submits to register.php -->
        <p>
            <label for="username">Username</label> <!-- Label for the username input -->
            <input type="text" name="username" required> <!-- Input for username; required field -->
        </p>
        <p>
            <label for="password">Password</label> <!-- Label for the password input -->
            <input type="password" name="password" required> <!-- Input for password; required field -->
        </p>
        <?php if (isset($errorMessage)): ?> <!-- Display error message if any -->
            <p style="color: red;"><?= htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <p>
            <input type="submit" value="Register"> <!-- Submit button for the form -->
        </p>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p> <!-- Link to the login page -->
</body>
</html>
