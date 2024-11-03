<?php
session_start(); // Start a new session or resume the existing session
require_once 'dbConfig.php'; // Include the database configuration
require_once 'models.php'; // Include the models for handling user and player data

// Enable error reporting for debugging purposes
ini_set('display_errors', 1); // Display errors on the screen
error_reporting(E_ALL); // Report all types of errors

// Handle registration
if (isset($_POST['registerBtn'])) { // Check if the registration button was pressed
    $username = trim($_POST['username']); // Get and trim the username input
    $password = $_POST['password']; // Get the password input

    // Call the registration function and capture the result
    $registrationResult = registerUser($pdo, $username, $password);

    // Check if registration was successful
    if ($registrationResult === true) {
        header("Location: ../login.php"); // Redirect to login page on success
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Registration failed: $registrationResult"; // Output error message
    }
}

// Handle login
if (isset($_POST['loginBtn'])) { // Check if the login button was pressed
    $username = trim($_POST['username']); // Get and trim the username input
    $password = $_POST['password']; // Get the password input

    // Call the login function and capture the result
    $loginResult = loginUser($pdo, $username, $password);
    
    // Check if login was successful
    if ($loginResult) {
        $_SESSION['user_id'] = $loginResult['id']; // Store user ID in session
        header("Location: ../index.php"); // Redirect to the main page on success
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Login failed: Invalid username or password."; // Output error message
    }
}

// Handle player insertion
if (isset($_POST['insertPlayerBtn'])) { // Check if the insert player button was pressed
    // Ensure the user is logged in before proceeding
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to add players."); // Stop execution and notify user
    }
    
    // Get and trim input values for player details
    $teamName = trim($_POST['teamName']); // Get the team name
    $playerName = trim($_POST['playerName']); // Get the player name
    $role = trim($_POST['role']); // Get the role
    $playerType = $_POST['playerType']; // Get the player type from dropdown
    $userId = $_SESSION['user_id']; // Get the current user's ID from the session

    // Call the function to insert the player into the database
    $insertResult = insertPlayer($pdo, $teamName, $playerName, $role, $playerType, $userId);
    
    // Check if the insertion was successful
    if ($insertResult === true) {
        header("Location: ../index.php"); // Redirect to the main page on success
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Failed to add player: $insertResult"; // Output error message
    }
}

// Handle logout
if (isset($_POST['logoutBtn'])) { // Check if the logout button was pressed
    session_destroy(); // Destroy the current session, logging the user out
    header("Location: ../login.php"); // Redirect to the login page
    exit(); // Ensure no further code is executed after the redirect
}
?>
