document.addEventListener('DOMContentLoaded', function() {
    const bgMusic = document.getElementById('backgroundMusic');
    const diceSound = document.getElementById('diceSound');
    const winSound = document.getElementById('winSound');
    let musicEnabled = true;
    let soundsEnabled = true;
    let welcomeAnimationShown = sessionStorage.getItem('welcomeShown') === 'true';
    const toggleMusicBtn = document.getElementById('toggleMusic');
    const toggleSoundsBtn = document.getElementById('toggleSounds');
    const playMusic = () => {
        if (musicEnabled && bgMusic) {
            bgMusic.volume = 0.3;
            bgMusic.play().catch(e => console.log('Error al reproducir música:', e));
        }
    };
    const playDiceSound = () => {
        if (soundsEnabled && diceSound) {
            diceSound.currentTime = 0;
            diceSound.play().catch(e => console.log('Error al reproducir sonido de dados:', e));
        }
    };
    const playWinSound = () => {
        if (soundsEnabled && winSound) {
            winSound.currentTime = 0;
            winSound.play().catch(e => console.log('Error al reproducir sonido de victoria:', e));
        }
    };
    if (toggleMusicBtn) {
        toggleMusicBtn.addEventListener('click', () => {
            musicEnabled = !musicEnabled;
            toggleMusicBtn.textContent = musicEnabled ? '🔊 Música' : '🔇 Música';
            if (musicEnabled) playMusic();
            else if (bgMusic) bgMusic.pause();
        });
    }  
    if (toggleSoundsBtn) {
        toggleSoundsBtn.addEventListener('click', () => {
            soundsEnabled = !soundsEnabled;
            toggleSoundsBtn.textContent = soundsEnabled ? '🎵 Sonidos' : '🔇 Sonidos';
        });
    }
    const welcomeAnimation = document.querySelector('.welcome-animation');
    const mainContainer = document.querySelector('.container');
    
    if (welcomeAnimation && mainContainer) {
        if (!welcomeAnimationShown) {
            setTimeout(() => {
                welcomeAnimation.style.opacity = '0';
                welcomeAnimation.style.pointerEvents = 'none';
                mainContainer.style.display = 'block';
                setTimeout(() => {
                    welcomeAnimation.style.display = 'none';
                }, 1000);
                
                sessionStorage.setItem('welcomeShown', 'true');
                welcomeAnimationShown = true;
                playMusic();
            }, 19000);
        } else {
            welcomeAnimation.style.display = 'none';
            mainContainer.style.display = 'block';
            playMusic();
        }
    }
    const initGameAnimations = () => {
        const diceContainer = document.querySelector('.dice-container');
        const cup = document.querySelector('.cup');
        const dice = document.querySelectorAll('.dice');
        if (diceContainer && cup) {
            diceContainer.style.zIndex = '5';
            cup.style.zIndex = '10';
        }
        if (dice.length > 0) {
            dice.forEach((die, index) => {
                die.style.animationDelay = `${index * 0.1}s`;
                
                die.addEventListener('animationend', function() {
                    die.classList.remove('roll-animation');
                });
            });
        }
        if (cup && cup.classList.contains('shake-animation')) {
            playDiceSound();
            
            cup.addEventListener('animationend', function() {
                cup.classList.remove('shake-animation');
                cup.classList.add('flip-animation');
                cup.style.pointerEvents = 'none';
                const winnerMessage = document.querySelector('.winner-message');
                if (winnerMessage) {
                    setTimeout(() => {
                        playWinSound();
                    }, 500);
                }
            });
        }
        if (cup && cup.classList.contains('flip-animation')) {
            cup.addEventListener('animationend', function() {
                cup.classList.remove('flip-animation');
            });
        }
    };
    if (welcomeAnimationShown) {
        initGameAnimations();
    } else {
        const checkWelcomeEnd = setInterval(() => {
            if (welcomeAnimationShown) {
                clearInterval(checkWelcomeEnd);
                initGameAnimations();
            }
        }, 100);
    }
    const gameForm = document.querySelector('form[method="POST"]');
    if (gameForm) {
        gameForm.addEventListener('submit', function() {
            setTimeout(() => {
                playDiceSound();
            }, 300);
        });
    }
    document.addEventListener('click', function enableAudio() {
        playMusic();
        document.removeEventListener('click', enableAudio);
    }, { once: true });
    document.addEventListener('click', function() {
        playMusic();
    }, { once: true });
});