<?php 
session_start(); // Start a new session or resume the existing session
require_once 'core/dbConfig.php'; // Include database configuration
require_once 'core/models.php'; // Include models for data handling

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit(); // Ensure no further code is executed after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design for mobile devices -->
    <title>Esports Team Management</title> <!-- Title displayed in the browser tab -->
    <style>
        /* Basic styling for the body of the page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font family for text */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Add padding around the body */
            background-color: #0e0e0e; /* Dark background */
            color: #e0e0e0; /* Light text color */
        }
        /* Heading colors */
        h1, h2, h3 {
            color: #ff4c00; /* T1 Orange */
        }
        /* Styling for forms */
        form {
            background: #1c1c1c; /* Dark background for forms */
            padding: 20px; /* Padding inside forms */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            margin-bottom: 20px; /* Space below forms */
        }
        /* Label styling */
        label {
            display: block; /* Block display for labels */
            margin-bottom: 5px; /* Space below labels */
        }
        /* Input and select field styling */
        input[type="text"], input[type="password"], select {
            width: 100%; /* Full width for inputs */
            padding: 8px; /* Padding inside inputs */
            margin-bottom: 10px; /* Space below inputs */
            border: 1px solid #444; /* Border styling */
            border-radius: 4px; /* Rounded corners */
            background-color: #222; /* Darker background for inputs */
            color: #e0e0e0; /* Light text color */
        }
        /* Submit button styling */
        input[type="submit"] {
            background-color: #ff4c00; /* T1 Orange */
            color: white; /* Text color for button */
            border: none; /* No border */
            padding: 10px; /* Padding inside button */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
        }
        /* Submit button hover effect */
        input[type="submit"]:hover {
            background-color: #ff6f00; /* Lighter Orange on hover */
        }
        /* Container for player details */
        .container {
            background: #2c2c2c; /* Dark background for containers */
            padding: 15px; /* Padding inside containers */
            border-radius: 5px; /* Rounded corners */
            margin-bottom: 10px; /* Space below containers */
        }
        /* Edit and delete links styling */
        .editAndDelete a {
            margin-left: 10px; /* Space to the left of links */
            text-decoration: none; /* No underline for links */
            color: #ff4c00; /* T1 Orange */
        }
        /* Edit and delete links hover effect */
        .editAndDelete a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Esports Team Management System</h1> <!-- Main heading -->

    <!-- Add Player Form -->
    <form action="core/handleForms.php" method="POST">
        <h2>Add New Player</h2>
        <p>
            <label for="teamName">Team Name</label> 
            <input type="text" name="teamName" required> <!-- Input for team name -->
        </p>
        <p>
            <label for="playerName">Player Name</label> 
            <input type="text" name="playerName" required> <!-- Input for player name -->
        </p>
        <p>
            <label for="role">Role</label> 
            <input type="text" name="role" required> <!-- Input for player role -->
        </p>
        <p>
            <label for="playerType">Player Type</label>
            <select name="playerType" required> <!-- Dropdown for player type -->
                <option value="Main">Main</option>
                <option value="Substitute">Substitute</option>
                <option value="Training">Training</option>
            </select>
        </p>
        <p>
            <input type="submit" name="insertPlayerBtn" value="Add Player"> <!-- Submit button for adding player -->
        </p>
    </form>

    <!-- Display list of players -->
    <h2>List of Players in Teams</h2>
    <?php $players = getAllPlayers($pdo); // Fetch all players from the database ?>
    <?php if ($players): // Check if players exist ?>
        <?php foreach ($players as $player): // Loop through each player ?>
            <div class="container" style="border-style: solid; margin-top: 20px;">
                <h3>Player: <?= htmlspecialchars($player['name']); ?> (Role: <?= htmlspecialchars($player['role']); ?>)</h3> <!-- Display player name and role -->
                <p>Type: <?= htmlspecialchars($player['player_type']); ?></p> <!-- Display player type -->
                <p>Team: <?= htmlspecialchars($player['team_name']); ?></p> <!-- Display team name -->
                <p>Added by: <?= htmlspecialchars($player['added_by_user']); ?></p> <!-- Display user who added the player -->
                <p>Last updated by: <?= htmlspecialchars($player['updated_by_user']); ?> on <?= htmlspecialchars($player['last_updated']); ?></p> <!-- Display user who last updated the player and the timestamp -->
                
                <div class="editAndDelete" style="float: right;"> <!-- Container for edit/delete links -->
                    <a href="editplayer.php?player_id=<?= $player['id']; ?>">Edit</a> <!-- Link to edit player -->
                    <a href="deleteplayer.php?player_id=<?= $player['id']; ?>">Delete</a> <!-- Link to delete player -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No players found.</p> <!-- Message if no players exist -->
    <?php endif; ?>

    <!-- Logout form -->
    <form action="core/handleForms.php" method="POST" style="margin-top: 20px;">
        <input type="submit" name="logoutBtn" value="Logout"> <!-- Submit button for logout -->
    </form>
</body>
</html>
