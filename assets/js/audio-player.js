document.addEventListener("DOMContentLoaded", function () {
  const audioPlayer = document.getElementById("bg-music");
  const playerContainer = document.querySelector(".audio-player-container");

  // Enhanced audio player functionality
  if (audioPlayer && playerContainer) {
    // Auto-minimize player when not playing
    audioPlayer.addEventListener("pause", function () {
      playerContainer.style.opacity = "0.7";
      playerContainer.style.transform = "scale(0.9)";
    });

    audioPlayer.addEventListener("play", function () {
      playerContainer.style.opacity = "1";
      playerContainer.style.transform = "scale(1)";

      // Add pulsing effect while playing
      playerContainer.classList.add("playing");
    });

    // Volume control with scroll
    playerContainer.addEventListener(
      "wheel",
      function (e) {
        e.preventDefault();
        const currentVolume = audioPlayer.volume;

        if (e.deltaY < 0 && currentVolume < 1) {
          audioPlayer.volume = Math.min(1, currentVolume + 0.1);
        } else if (e.deltaY > 0 && currentVolume > 0) {
          audioPlayer.volume = Math.max(0, currentVolume - 0.1);
        }

        // Show volume indicator
        showVolumeIndicator(Math.round(audioPlayer.volume * 100));
      },
      { passive: false }
    ); // Keep as non-passive since we need preventDefault

    // Double click to toggle minimized state
    let isMinimized = false;
    playerContainer.addEventListener("dblclick", function () {
      if (isMinimized) {
        playerContainer.style.width = "auto";
        playerContainer.style.height = "auto";
        document.querySelector(".audio-player-header").style.display = "block";
        audioPlayer.style.display = "block";
        isMinimized = false;
      } else {
        playerContainer.style.width = "60px";
        playerContainer.style.height = "60px";
        document.querySelector(".audio-player-header").style.display = "none";
        audioPlayer.style.display = "none";
        isMinimized = true;
      }
    });

    // Save volume preference
    audioPlayer.addEventListener("volumechange", function () {
      localStorage.setItem("audioVolume", audioPlayer.volume);
    });

    // Load saved volume
    const savedVolume = localStorage.getItem("audioVolume");
    if (savedVolume) {
      audioPlayer.volume = parseFloat(savedVolume);
    }
  }

  function showVolumeIndicator(volume) {
    let indicator = document.querySelector(".volume-indicator");
    if (!indicator) {
      indicator = document.createElement("div");
      indicator.className = "volume-indicator";
      indicator.style.cssText = `
                position: fixed;
                bottom: 120px;
                right: 50px;
                background: #b71c1c;
                color: white;
                padding: 8px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                z-index: 102;
                opacity: 0;
                transition: opacity 0.3s ease;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            `;
      document.body.appendChild(indicator);
    }

    indicator.textContent = `🔊 ${volume}%`;
    indicator.style.opacity = "1";

    clearTimeout(indicator.fadeTimeout);
    indicator.fadeTimeout = setTimeout(() => {
      indicator.style.opacity = "0";
    }, 1500);
  }

  // Add CSS for playing animation
  const style = document.createElement("style");
  style.textContent = `
        .audio-player-container.playing {
            animation: audioPlayerPulse 2s infinite;
        }
        
        @keyframes audioPlayerPulse {
            0%, 100% { 
                border-color: #b71c1c;
                box-shadow: 
                    8px 8px 16px rgba(0, 0, 0, 0.1),
                    -8px -8px 16px rgba(255, 255, 255, 0.7);
            }
            50% { 
                border-color: #ffeb3b;
                box-shadow: 
                    8px 8px 20px rgba(183, 28, 28, 0.2),
                    -8px -8px 20px rgba(255, 235, 59, 0.2),
                    0 0 15px rgba(255, 235, 59, 0.3);
            }
        }
    `;
  document.head.appendChild(style);
});
