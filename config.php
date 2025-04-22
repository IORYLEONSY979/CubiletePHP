<?php
// Configuración de la aplicación
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'juego_cubilete');

// Configuración de rutas
define('BASE_URL', 'http://localhost/juego_cubilete');
define('AUDIO_PATH', BASE_URL . '/assets/audio/');

// Iniciar sesión
session_start();