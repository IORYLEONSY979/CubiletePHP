<?php
require_once 'config.php';
require_once 'classes/Database.php';
require_once 'classes/Dice.php';
require_once 'classes/Game.php';

$db = new Database();
$game = new Game();

if (isset($_SESSION['game_data'])) {
    $game->setFromSession($_SESSION['game_data']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['play_turn'])) {
    $game->playTurn();
    $_SESSION['game_data'] = $game->toSession();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_score'])) {
    if ($game->isGameOver() && $game->getWinner()) {
        $db->saveScore($_POST['player_name'], $game->getScores()[$game->getWinner() - 1]);
        session_destroy();
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_GET['restart'])) {
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$highScores = $db->getHighScores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Cubilete Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <audio id="backgroundMusic" loop>
    <source src="<?= AUDIO_PATH ?>bg.mp3" type="audio/mpeg">
    Tu navegador no soporta el elemento de audio.
</audio>
</head>
<body>
    <div class="welcome-animation">
        <div class="welcome-message">🎲 Cubilete Alfa Perron 🎲</div>
    </div>
    
    <div class="container">
        <h1>🎲 Cubilete Alfa Perron 🎲</h1>
        
        <div class="game-area">
            <?php if ($game->getLastRolls()): ?>
                <div class="dice-container">
                    <?php foreach ($game->getLastRolls() as $roll): ?>
                        <div class="dice roll-animation">
                            <div class="dice-value"><?= $roll ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cup shake-animation">
                    <div class="dice-inside"></div>
                </div>
                <p class="roll-result">
                    Jugador <?= ($game->getCurrentPlayer() == 1) ? 2 : 1 ?> obtuvo <?= $game->getLastTotal() ?> puntos!
                </p>
            <?php else: ?>
                <div class="dice-container">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="dice">
                            <div class="dice-value">?</div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="cup">
                    <div class="dice-inside"></div>
                </div>
                <p class="roll-instruction">
                    Haz clic en el botón para lanzar los dados
                </p>
            <?php endif; ?>
            
            <div class="players">
                <div class="player player-1 <?= ($game->getCurrentPlayer() == 1 && !$game->isGameOver()) ? 'active' : '' ?>">
                    <h2>Jugador 1</h2>
                    <div class="player-score"><?= $game->getScores()[0] ?></div>
                    <p>Puntos</p>
                </div>
                
                <div class="player player-2 <?= ($game->getCurrentPlayer() == 2 && !$game->isGameOver()) ? 'active' : '' ?>">
                    <h2>Jugador 2</h2>
                    <div class="player-score"><?= $game->getScores()[1] ?></div>
                    <p>Puntos</p>
                </div>
            </div>
            
            <?php if ($game->isGameOver()): ?>
                <div class="winner-message">
                    <h2>¡Jugador <?= $game->getWinner() ?> gana el juego con <?= $game->getScores()[$game->getWinner() - 1] ?> puntos!</h2>
                    
                    <form method="POST" class="score-form">
                        <input type="text" name="player_name" placeholder="Ingresa tu nombre para el récord" required>
                        <button type="submit" name="save_score" class="btn btn-secondary">Guardar Puntuación</button>
                    </form>
                </div>
                
                <a href="?restart=1" class="btn">Jugar de nuevo</a>
            <?php else: ?>
                <form method="POST">
                    <button type="submit" name="play_turn" class="btn">
                        Turno Jugador <?= $game->getCurrentPlayer() ?>
                    </button>
                </form>
            <?php endif; ?>
            
            <div class="high-scores">
                <h2>🏆 Mejores Puntuaciones 🏆</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Nombre</th>
                            <th>Puntuación</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($highScores) > 0): ?>
                            <?php foreach ($highScores as $index => $score): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($score['player_name']) ?></td>
                                    <td><?= $score['score'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($score['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4">No hay puntuaciones registradas aún</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="audio-controls">
        <button id="toggleMusic" class="btn-audio">🔊 Música</button>
        <button id="toggleSounds" class="btn-audio">🎵 Sonidos</button>
    </div>
    
    <audio id="backgroundMusic" loop>
        <source src="<?= AUDIO_PATH ?>bg.mp3" type="audio/mpeg">
    </audio>
    <audio id="diceSound">
        <source src="<?= AUDIO_PATH ?>roll.mp3" type="audio/mpeg">
    </audio>
    <audio id="winSound">
        <source src="<?= AUDIO_PATH ?>win.mp3" type="audio/mpeg">
    </audio>
    
    <script src="assets/js/game.js"></script>
    <script>
document.addEventListener('click', function() {
    const bgMusic = document.getElementById('backgroundMusic');
    bgMusic.play().catch(e => console.log('Audio error:', e));
}, { once: true });
</script><script>
document.addEventListener('click', function() {
    const bgMusic = document.getElementById('backgroundMusic');
    bgMusic.play().catch(e => console.log('Audio error:', e));
}, { once: true });
</script>
</body>
</html>