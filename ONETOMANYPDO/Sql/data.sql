-- Table for Esports Teams
CREATE TABLE esports_teams (
    id INT PRIMARY KEY AUTO_INCREMENT,   -- Primary Key for the team
    name VARCHAR(255) NOT NULL UNIQUE    -- Team Name (unique constraint for preventing duplicates)
);

-- Table for Users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,    -- Primary Key for the user
    username VARCHAR(255) UNIQUE NOT NULL, -- Unique username for each user
    password VARCHAR(255) NOT NULL         -- Hashed password for secure storage
);

-- Table for Players
CREATE TABLE players (
    id INT PRIMARY KEY AUTO_INCREMENT,     -- Primary Key for the player
    name VARCHAR(255) NOT NULL,            -- Player's Name
    role VARCHAR(50) NOT NULL,             -- Role/Lane (Top, Jungle, Mid, ADC, Support)
    player_type ENUM('Main', 'Substitute', 'Training') NOT NULL, -- Categorization of Player
    team_id INT,                           -- Foreign Key (Links to esports_teams)
    added_by INT,                          -- User ID of the user who added the player
    updated_by INT,                        -- User ID of the user who last updated the player
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Last updated timestamp
    FOREIGN KEY (team_id) REFERENCES esports_teams(id) ON DELETE SET NULL,  -- Foreign Key for team with cascade
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE SET NULL,         -- Foreign Key for user who added
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL        -- Foreign Key for user who updated
);
