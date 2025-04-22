<?php
class Game {
    private $currentPlayer;
    private $scores;
    private $gameOver;
    private $winner;
    private $lastRolls;
    private $lastTotal;
    private $dice;
    
    public function __construct() {
        $this->dice = new Dice();
        $this->resetGame();
    }
    
    public function resetGame() {
        $this->scores = [0, 0];
        $this->currentPlayer = 1;
        $this->gameOver = false;
        $this->winner = null;
        $this->lastRolls = null;
        $this->lastTotal = 0;
    }
    
    public function playTurn() {
        if (!$this->gameOver) {
            $this->lastRolls = $this->dice->rollMultiple();
            $this->lastTotal = array_sum($this->lastRolls);
            $this->scores[$this->currentPlayer - 1] += $this->lastTotal;
            
            $this->switchPlayer();
            $this->checkWinner();
        }
    }
    
    private function switchPlayer() {
        $this->currentPlayer = ($this->currentPlayer == 1) ? 2 : 1;
    }
    
    private function checkWinner() {
        if ($this->scores[0] >= 100) {
            $this->gameOver = true;
            $this->winner = 1;
        } elseif ($this->scores[1] >= 100) {
            $this->gameOver = true;
            $this->winner = 2;
        }
    }
    
    // Getters
    public function getCurrentPlayer() { return $this->currentPlayer; }
    public function getScores() { return $this->scores; }
    public function isGameOver() { return $this->gameOver; }
    public function getWinner() { return $this->winner; }
    public function getLastRolls() { return $this->lastRolls; }
    public function getLastTotal() { return $this->lastTotal; }
    
    // Setters para cargar desde sesión
    public function setFromSession($data) {
        $this->currentPlayer = $data['current_player'] ?? 1;
        $this->scores = $data['scores'] ?? [0, 0];
        $this->gameOver = $data['game_over'] ?? false;
        $this->winner = $data['winner'] ?? null;
        $this->lastRolls = $data['last_rolls'] ?? null;
        $this->lastTotal = $data['last_total'] ?? 0;
    }
    
    public function toSession() {
        return [
            'current_player' => $this->currentPlayer,
            'scores' => $this->scores,
            'game_over' => $this->gameOver,
            'winner' => $this->winner,
            'last_rolls' => $this->lastRolls,
            'last_total' => $this->lastTotal
        ];
    }
}