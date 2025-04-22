document.addEventListener('DOMContentLoaded', function() {
    // Esperar a que termine la animación de bienvenida
    setTimeout(() => {
        // Inicializar elementos de audio
        const bgMusic = document.getElementById('backgroundMusic');
        const diceSound = document.getElementById('diceSound');
        const winSound = document.getElementById('winSound');
        
        // Configuración de audio del usuario
        let musicEnabled = true;
        let soundsEnabled = true;
        
        // Botones de control de audio
        const toggleMusicBtn = document.getElementById('toggleMusic');
        const toggleSoundsBtn = document.getElementById('toggleSounds');
        
        // Intentar reproducir música (necesario para políticas de autoplay)
        const playMusic = () => {
            if (musicEnabled) {
                bgMusic.volume = 0.3;
                bgMusic.play().catch(e => console.log('Autoplay prevented:', e));
            }
        };
        
        // Configurar controles de audio
        toggleMusicBtn.addEventListener('click', () => {
            musicEnabled = !musicEnabled;
            toggleMusicBtn.textContent = musicEnabled ? '🔊 Música' : '🔇 Música';
            if (musicEnabled) playMusic();
            else bgMusic.pause();
        });
        
        toggleSoundsBtn.addEventListener('click', () => {
            soundsEnabled = !soundsEnabled;
            toggleSoundsBtn.textContent = soundsEnabled ? '🎵 Sonidos' : '🔇 Sonidos';
        });
        
        // Reproducir música al hacer clic en cualquier parte (para desbloquear autoplay)
        document.body.addEventListener('click', () => {
            playMusic();
        }, { once: true });
        
        // Animación de dados
        const dice = document.querySelectorAll('.dice');
        const cup = document.querySelector('.cup');
        
        dice.forEach((die, index) => {
            // Retraso escalonado para la animación
            die.style.animationDelay = `${index * 0.1}s`;
            
            // Remover la clase de animación después de que termine
            die.addEventListener('animationend', function() {
                die.classList.remove('roll-animation');
            });
        });
        
        // Animación del vaso
        if (cup.classList.contains('shake-animation')) {
            // Reproducir sonido de dados
            if (soundsEnabled) {
                diceSound.currentTime = 0;
                diceSound.play();
            }
            
            cup.addEventListener('animationend', function() {
                cup.classList.remove('shake-animation');
                
                // Añadir animación de volteo después de agitar
                cup.classList.add('flip-animation');
                
                // Reproducir sonido de victoria si el juego terminó
                const winnerMessage = document.querySelector('.winner-message');
                if (winnerMessage && soundsEnabled) {
                    setTimeout(() => {
                        winSound.play();
                    }, 500);
                }
            });
        }
        
        // Animación de volteo del vaso
        if (cup.classList.contains('flip-animation')) {
            cup.addEventListener('animationend', function() {
                cup.classList.remove('flip-animation');
            });
        }
    }, 2500); // Esperar 2.5s para que termine la animación de bienvenida
});