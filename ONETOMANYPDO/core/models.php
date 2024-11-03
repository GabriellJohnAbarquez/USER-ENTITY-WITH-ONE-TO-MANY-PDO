<?php  

// Inserts a new player into the database
function insertPlayer($pdo, $teamName, $playerName, $role, $playerType, $userId) {
    try {
        $pdo->beginTransaction(); // Start a database transaction

        // First, try to find the existing team ID
        $teamQuery = "SELECT id FROM esports_teams WHERE name = ?"; // Prepare SQL query to find team by name
        $teamStmt = $pdo->prepare($teamQuery); // Prepare the statement
        $teamStmt->execute([$teamName]); // Execute the statement with team name
        $team = $teamStmt->fetch(PDO::FETCH_ASSOC); // Fetch the result

        // If the team does not exist, insert it
        if (!$team) {
            $insertTeamQuery = "INSERT INTO esports_teams (name) VALUES (?)"; // SQL to insert new team
            $insertTeamStmt = $pdo->prepare($insertTeamQuery); // Prepare the insert statement
            $insertTeamStmt->execute([$teamName]); // Execute the insert
            $teamID = $pdo->lastInsertId(); // Get the ID of the newly inserted team
        } else {
            $teamID = $team['id']; // Get the existing team's ID
        }

        // Insert the player
        $sql = "INSERT INTO players (name, role, player_type, team_id, added_by, updated_by) VALUES (?, ?, ?, ?, ?, ?)"; // SQL for player insertion
        $stmt = $pdo->prepare($sql); // Prepare the insert statement
        $stmt->execute([$playerName, $role, $playerType, $teamID, $userId, $userId]); // Execute the insert with player data

        $pdo->commit(); // Commit the transaction
        return true; // Return true on success
    } catch (Exception $e) {
        $pdo->rollBack(); // Rollback transaction on error
        return $e->getMessage(); // Return error message
    }
}

// Retrieves all players along with team and user details
function getAllPlayers($pdo) {
    // SQL query to select player details including associated team and user info
    $sql = "SELECT players.id, players.name, players.role, players.player_type, 
                   esports_teams.name AS team_name, 
                   u1.username AS added_by_user, 
                   u2.username AS updated_by_user, 
                   players.last_updated 
            FROM players 
            LEFT JOIN esports_teams ON players.team_id = esports_teams.id 
            LEFT JOIN users u1 ON players.added_by = u1.id 
            LEFT JOIN users u2 ON players.updated_by = u2.id";
    $stmt = $pdo->prepare($sql); // Prepare the SQL statement
    $stmt->execute(); // Execute the statement
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch and return all results as associative array
}

// Deletes a player by ID
function deletePlayer($pdo, $player_id) {
    $sql = "DELETE FROM players WHERE id = ?"; // SQL query to delete a player by ID
    $stmt = $pdo->prepare($sql); // Prepare the statement
    $stmt->execute([$player_id]); // Execute the deletion
}

// Retrieves player details by ID
function getPlayerById($pdo, $player_id) {
    // SQL query to get player details by ID
    $sql = "SELECT players.*, esports_teams.name AS team_name 
            FROM players 
            LEFT JOIN esports_teams ON players.team_id = esports_teams.id 
            WHERE players.id = ?";
    $stmt = $pdo->prepare($sql); // Prepare the statement
    $stmt->execute([$player_id]); // Execute the statement with player ID
    return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch and return the player details
}

// Update player information including team name
function updatePlayer($pdo, $player_id, $name, $role, $player_type, $team_name, $user_id) {
    try {
        $pdo->beginTransaction(); // Start a database transaction

        // First, try to find the existing team ID
        $teamQuery = "SELECT id FROM esports_teams WHERE name = ?"; // Prepare SQL to find team by name
        $teamStmt = $pdo->prepare($teamQuery); // Prepare the statement
        $teamStmt->execute([$team_name]); // Execute the statement
        $team = $teamStmt->fetch(PDO::FETCH_ASSOC); // Fetch the result

        // If the team does not exist, insert it
        if (!$team) {
            $insertTeamQuery = "INSERT INTO esports_teams (name) VALUES (?)"; // SQL to insert new team
            $insertTeamStmt = $pdo->prepare($insertTeamQuery); // Prepare the insert statement
            $insertTeamStmt->execute([$team_name]); // Execute the insert
            $teamID = $pdo->lastInsertId(); // Get the ID of the newly inserted team
        } else {
            $teamID = $team['id']; // Get the existing team's ID
        }

        // Update the player record
        $sql = "UPDATE players SET name = ?, role = ?, player_type = ?, team_id = ?, updated_by = ? WHERE id = ?"; // SQL for updating player details
        $stmt = $pdo->prepare($sql); // Prepare the statement
        $stmt->execute([$name, $role, $player_type, $teamID, $user_id, $player_id]); // Execute the update with new data

        $pdo->commit(); // Commit the transaction
        return true; // Return true on success
    } catch (Exception $e) {
        $pdo->rollBack(); // Rollback transaction on error
        return $e->getMessage(); // Return error message
    }
}


// Function to register a new user
function registerUser($pdo, $username, $password) {
    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    // If the username exists, return an error message
    if ($stmt->rowCount() > 0) {
        return "Username already exists.";
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    return true; // Return true if registration was successful
}

// Function to authenticate user login
function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ?"; // SQL query to get user by username
    $stmt = $pdo->prepare($sql); // Prepare the statement
    $stmt->execute([$username]); // Execute the query with username
    $user = $stmt->fetch(); // Fetch the user details

    // Verify the password against the stored hash
    if ($user && password_verify($password, $user['password'])) {
        return $user; // Return user details on successful authentication
    }
    return false; // Return false if authentication fails
}
?>
