<?php
// Start the session for user session management
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if a player ID is provided via GET for deletion
if (isset($_GET['player_id'])) {
    $player_id = $_GET['player_id'];
    
    // Call function to delete the player record from the database
    deletePlayer($pdo, $player_id);

    // Redirect to the main page after deletion
    header("Location: index.php");
    exit();
}
?>
