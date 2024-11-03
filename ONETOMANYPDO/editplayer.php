<?php
session_start(); // Start the session to access session variables
require_once 'core/dbConfig.php'; // Include database configuration file
require_once 'core/models.php'; // Include model functions for database operations

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Exit to prevent further script execution
}

// Check if a player ID is provided in the query string
if (isset($_GET['player_id'])) {
    $player_id = $_GET['player_id']; // Get the player ID from the URL
    $player = getPlayerById($pdo, $player_id); // Fetch player details using the ID

    // If the player is not found, display an error message
    if (!$player) {
        die("Player not found.");
    }
}

// Handle form submission to update player details
if (isset($_POST['updatePlayerBtn'])) {
    $player_id = $_POST['player_id']; // Get the player ID from the form
    $name = $_POST['name']; // Get the player's name from the form
    $role = $_POST['role']; // Get the player's role from the form
    $player_type = $_POST['player_type']; // Get the player's type from the form
    $team_name = $_POST['team_name']; // Capture the team name from the form
    $user_id = $_SESSION['user_id']; // Get the current user's ID from the session

    // Call the updatePlayer function to update the player's information in the database
    $updateResult = updatePlayer($pdo, $player_id, $name, $role, $player_type, $team_name, $user_id);

    // Check if the update was successful
    if ($updateResult === true) {
        header("Location: index.php"); // Redirect to the index page on success
        exit(); // Exit to prevent further script execution
    } else {
        // Display an error message if the update failed
        echo "Failed to update player: $updateResult";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font style for the page */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Add padding */
            background-color: #0e0e0e; /* Dark background color */
            color: #e0e0e0; /* Light text color */
        }
        h1 {
            color: #ff4c00; /* Title color */
        }
        form {
            background: #1c1c1c; /* Form background color */
            padding: 20px; /* Padding for form */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Shadow effect */
            margin-bottom: 20px; /* Bottom margin */
            max-width: 400px; /* Limit form width */
            margin: 20px auto; /* Center form */
        }
        label {
            display: block; /* Make labels block elements */
            margin-bottom: 5px; /* Space below labels */
        }
        input[type="text"], select {
            width: 100%; /* Full width for input and select */
            padding: 8px; /* Padding for input */
            margin-bottom: 10px; /* Space below inputs */
            border: 1px solid #444; /* Border style */
            border-radius: 4px; /* Rounded corners */
            background-color: #222; /* Input background color */
            color: #e0e0e0; /* Input text color */
        }
        input[type="submit"] {
            background-color: #ff4c00; /* Button background color */
            color: white; /* Button text color */
            border: none; /* No border */
            padding: 10px; /* Padding for button */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: 100%; /* Full width for button */
        }
        input[type="submit"]:hover {
            background-color: #ff6f00; /* Button hover color */
        }
    </style>
</head>
<body>
    <h1>Edit Player</h1>
    <form action="editplayer.php" method="POST"> <!-- Form to update player details -->
        <input type="hidden" name="player_id" value="<?= $player['id']; ?>"> <!-- Hidden field for player ID -->
        <p>
            <label for="name">Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($player['name']); ?>" required> <!-- Input for player name -->
        </p>
        <p>
            <label for="role">Role</label>
            <input type="text" name="role" value="<?= htmlspecialchars($player['role']); ?>" required> <!-- Input for player role -->
        </p>
        <p>
            <label for="player_type">Player Type</label>
            <select name="player_type" required> <!-- Dropdown for player type -->
                <option value="Main" <?= $player['player_type'] == 'Main' ? 'selected' : ''; ?>>Main</option> <!-- Option for main player -->
                <option value="Substitute" <?= $player['player_type'] == 'Substitute' ? 'selected' : ''; ?>>Substitute</option> <!-- Option for substitute -->
                <option value="Training" <?= $player['player_type'] == 'Training' ? 'selected' : ''; ?>>Training</option> <!-- Option for training -->
            </select>
        </p>
        <p>
            <label for="team_name">Team Name</label>
            <input type="text" name="team_name" value="<?= htmlspecialchars($player['team_name']); ?>" required> <!-- Input for team name -->
        </p>
        <p>
            <input type="submit" name="updatePlayerBtn" value="Update Player"> <!-- Submit button -->
        </p>
    </form>
</body>
</html>
