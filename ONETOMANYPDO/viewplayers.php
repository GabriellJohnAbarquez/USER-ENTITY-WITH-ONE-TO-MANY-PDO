<?php
session_start(); // Start the session to access session variables
require_once 'core/dbConfig.php'; // Include the database configuration file
require_once 'core/models.php'; // Include model functions for database operations

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login
    exit(); // Exit to prevent further script execution
}

// Fetch all players from the database
$players = getAllPlayers($pdo); // Call the function to retrieve all players
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Character set for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>View Players</title> <!-- Title of the page -->
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
</head>
<body>
    <h1>Players List</h1> <!-- Header for the players list -->

    <?php if ($players): ?> <!-- Check if there are players to display -->
        <?php foreach ($players as $player): ?> <!-- Loop through each player -->
            <div class="container"> <!-- Container for each player's details -->
                <h3>Player: <?= htmlspecialchars($player['name']); ?> (Role: <?= htmlspecialchars($player['role']); ?>)</h3> <!-- Display player's name and role -->
                <p>Type: <?= htmlspecialchars($player['player_type']); ?></p> <!-- Display player's type -->
                <p>Team: <?= htmlspecialchars($player['team_name']); ?></p> <!-- Display the player's team name -->
                <p>Added by: <?= htmlspecialchars($player['username']); ?> on <?= htmlspecialchars($player['last_updated']); ?></p> <!-- Display who added the player and when -->
                <div class="editAndDelete"> <!-- Container for edit and delete actions -->
                    <a href="editplayer.php?player_id=<?= $player['id']; ?>">Edit</a> <!-- Link to edit the player -->
                    <a href="deleteplayer.php?player_id=<?= $player['id']; ?>">Delete</a> <!-- Link to delete the player -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?> <!-- If no players are found -->
        <p>No players found.</p> <!-- Message indicating no players -->
    <?php endif; ?>

    <a href="index.php">Back to Home</a> <!-- Link to go back to the home page -->
</body>
</html>
