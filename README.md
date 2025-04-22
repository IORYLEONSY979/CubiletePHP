El Juego de Cubilete es una aplicación web interactiva que simula el clásico juego de dados donde los jugadores compiten para alcanzar primero los 100 puntos. Esta versión incluye animaciones realistas, efectos de sonido y un sistema de registro de puntuaciones.

Características principales 
Juego multijugador (2 jugadores)

Animaciones realistas:

Vaso que se agita y voltea

Dados que ruedan

Efectos visuales al ganar

Sistema de audio:

Música ambiental

Efectos de sonido para dados y victoria

Controles para ajustar volumen

Registro de puntuaciones con top 10

Diseño responsive que funciona en móviles y desktop

Animación de bienvenida con duración sincronizada al audio

Requisitos técnicos ⚙️
Servidor web con PHP 7.0+

Base de datos MySQL

Navegador web moderno (Chrome, Firefox, Edge, Safari)

Conexión a internet para cargar fuentes de Google

Instalación 🛠️
Clonar el repositorio:

bash
git clone https://github.com/IORYLEONSY979/CubiletePHP.git
cd juego-cubilete
Configurar la base de datos:

Crear una base de datos MySQL

Importar la estructura de la tabla (se crea automáticamente al ejecutar)

Configurar credenciales:
Editar config.php con tus datos de conexión:

php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'juego_cubilete');
Subir archivos al servidor web

Estructura de archivos 📂
/juego_cubilete
├── index.php          # Página principal
├── config.php         # Configuración
├── classes/           # Lógica del juego
│   ├── Database.php   # Manejo de base de datos
│   ├── Game.php       # Lógica principal
│   └── Dice.php       # Generación de dados
├── assets/
│   ├── js/
│   │   └── game.js    # Animaciones y audio
│   ├── css/
│   │   └── styles.css # Estilos
│   └── audio/         # Sonidos
│       ├── roll.mp3
│       ├── win.mp3
│       └── bg.mp3
└── README.md          # Este archivo
Cómo jugar 🎮
Iniciar el juego: Haz clic en "Turno Jugador 1"

Ver animación: El vaso se agitará y mostrará los dados

Sumar puntos: Los puntos se suman automáticamente

Cambio de turno: Alterna entre jugadores

Ganar: El primero en alcanzar 100 puntos gana

Guardar puntuación: Ingresa tu nombre para el cuadro de honor

Personalización 🎨
Puedes modificar:

Colores en styles.css (variables CSS)

Sonidos en la carpeta assets/audio/

Puntuación para ganar en classes/Game.php

Capturas de pantalla 📸
Pantalla de inicio
Animación de bienvenida

Juego en progreso
Turno de juego

Puntuaciones
Tabla de records

Licencia 📜
Este proyecto está bajo licencia MIT. Ver archivo LICENSE para más detalles.

Contacto ✉️
Para soporte o contribuciones:

Email:ioryleonsy@gmail.com

GitHub: github.com/IORYLEONSY979
