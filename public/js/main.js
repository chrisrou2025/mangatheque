/**
 * Fonction pour afficher une notification toast
 * @param {string} message - Le message à afficher
 * @param {string} type - Le type de notification (success, error, info)
 */
function showToast(message, type = 'success') {
    // Définit les icônes selon le type de notification
    const icons = {
        success: '✓',
        error: '✗',
        info: 'i'
    };

    // Crée l'élément toast
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <div class="toast-icon">
                <span>${icons[type]}</span>
            </div>
            <div class="toast-message">
                <p>${message}</p>
            </div>
            <div class="toast-close">
                <button onclick="hideToast(this.parentElement.parentElement.parentElement)" class="close-btn">&times;</button>
            </div>
        </div>
        <div class="progress-bar progress-bar-${type}"></div>
    `;

    // Ajoute le toast au container
    const container = document.getElementById('toast-container');
    if (container) {
        container.appendChild(toast);
    }

    // Affiche le toast avec animation après un court délai
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    // Masque automatiquement le toast après 4 secondes
    setTimeout(() => {
        hideToast(toast);
    }, 4000);
}

/**
 * Fonction pour masquer un toast
 * @param {HTMLElement} toast - L'élément toast à masquer
 */
function hideToast(toast) {
    // Ajoute les classes pour l'animation de sortie
    toast.classList.add('hide');
    toast.classList.remove('show');

    // Supprime l'élément du DOM après l'animation
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

/**
 * Fonction pour confirmer la déconnexion avec une boîte de dialogue
 * Si l'utilisateur confirme, il est redirigé vers la page de déconnexion
 */
function confirmLogout() {
    // Affiche une boîte de dialogue de confirmation
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        // Si l'utilisateur confirme, redirection vers la route de déconnexion
        window.location.href = '/mangatheque/logout';
    }
    // Si l'utilisateur annule, rien ne se passe (il reste sur la page actuelle)
}

/**
 * Fonction pour afficher les messages de session au chargement
 * Cette fonction sera appelée depuis le fichier PHP si nécessaire
 * @param {string} message - Le message à afficher
 * @param {string} type - Le type de message
 */
function displaySessionMessage(message, type) {
    document.addEventListener('DOMContentLoaded', function () {
        showToast(message, type);
    });
}

/**
 * Fonction pour basculer l'affichage du mot de passe
 */
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'inline';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'inline';
        eyeClosed.style.display = 'none';
    }
    // Met à jour l'icône pour le bouton de bascule
    const toggleBtn = document.querySelector('.password-toggle-btn');
    if (toggleBtn) {
        toggleBtn.classList.toggle('active');
    }
}