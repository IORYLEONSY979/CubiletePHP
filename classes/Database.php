<?php
class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        $this->initializeDatabase();
    }
    
    private function initializeDatabase() {
        $sql = "CREATE TABLE IF NOT EXISTS high_scores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            player_name VARCHAR(50) NOT NULL,
            score INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->conn->query($sql);
    }
    
    public function saveScore($name, $score) {
        $name = $this->conn->real_escape_string($name);
        $sql = "INSERT INTO high_scores (player_name, score) VALUES ('$name', $score)";
        return $this->conn->query($sql);
    }
    
    public function getHighScores($limit = 10) {
        $sql = "SELECT player_name, score, created_at FROM high_scores ORDER BY score DESC LIMIT $limit";
        $result = $this->conn->query($sql);
        
        $scores = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $scores[] = $row;
            }
        }
        return $scores;
    }
    
    public function __destruct() {
        $this->conn->close();
    }
}