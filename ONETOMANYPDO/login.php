<?php
// Start the session to handle user sessions
session_start(); 

// Include the database configuration and model functions for database operations
require_once 'core/dbConfig.php'; 
require_once 'core/models.php';

// Redirect to the homepage if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the main page
    exit(); // Stop further script execution to prevent rendering the login form
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Make the page responsive -->
    <title>Login</title> <!-- Title for the login page -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Set the font style for the body */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Add padding around the body */
            background-color: #0e0e0e; /* Dark background color */
            color: #e0e0e0; /* Light text color */
        }
        h1 {
            color: #ff4c00; /* Color for the main heading */
        }
        form {
            background: #1c1c1c; /* Darker background for the form */
            padding: 20px; /* Padding inside the form */
            border-radius: 5px; /* Rounded corners for the form */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Add shadow for depth */
            margin-bottom: 20px; /* Space below the form */
        }
        label {
            display: block; /* Ensure labels are block elements for proper spacing */
            margin-bottom: 5px; /* Space between label and input */
        }
        input[type="text"], input[type="password"] {
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
            background-color: #ff6f00; /* Change button color when hovering */
        }
    </style>
</head>
<body>
    <h2>Login</h2> <!-- Main heading for the login form -->
    <!-- Login form for users -->
    <form action="core/handleForms.php" method="POST"> <!-- Form submits to handleForms.php -->
        <p>
            <label for="username">Username:</label> <!-- Label for the username input -->
            <input type="text" name="username" required> <!-- Input for username; required field -->
        </p>
        <p>
            <label for="password">Password:</label> <!-- Label for the password input -->
            <input type="password" name="password" required> <!-- Input for password; required field -->
        </p>
        <p>
            <input type="submit" name="loginBtn" value="Login"> <!-- Submit button for the form -->
        </p>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p> <!-- Link to the registration page -->
</body>
</html>
