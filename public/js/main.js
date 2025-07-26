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
 * Version générique qui fonctionne pour login et register
 * @param {string} inputId - L'ID du champ de mot de passe à basculer
 */
function togglePassword(inputId) {
    // Récupère l'élément input du mot de passe
    const passwordInput = document.getElementById(inputId);
    if (!passwordInput) {
        console.error(`Élément avec l'ID "${inputId}" non trouvé`);
        return;
    }

    // Détermine l'ID de l'icône selon la page
    let eyeIconId;
    if (inputId === 'password') {
        // Vérifie si on est sur la page de login ou register
        eyeIconId = document.getElementById('eye-open') ? 'eye-open' : 'eye-open-register';
    }

    const eyeIcon = document.getElementById(eyeIconId);
    if (!eyeIcon) {
        console.error(`Icône avec l'ID "${eyeIconId}" non trouvée`);
        return;
    }

    // Bascule entre les types password et text
    if (passwordInput.type === 'password') {
        // Change en mode visible
        passwordInput.type = 'text';
        // Icône "œil barré" (mot de passe visible)
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
        `;
    } else {
        // Change en mode masqué
        passwordInput.type = 'password';
        // Icône "œil ouvert" (mot de passe masqué)
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
