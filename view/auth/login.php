<?php
$title = "Connexion - Ma Mangathèque";
ob_start();
?>

<div class="login-container">
    <div class="login-wrapper">
        <!-- En-tête du formulaire -->
        <div class="login-header">
            <div class="login-icon">
                <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h2 class="login-title">
                Connexion à votre compte
            </h2>
        </div>

        <!-- Formulaire de connexion -->
        <div class="login-form-container">
            <form class="login-form" action="/mangatheque/login" method="POST">
                <!-- Champ Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        Adresse email
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg class="icon-svg-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            class="form-input"
                            placeholder="votre@email.com"
                        >
                    </div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        Mot de passe
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg class="icon-svg-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="current-password" 
                            required 
                            class="form-input form-input-password"
                            placeholder="Votre mot de passe"
                        >
                        <!-- Bouton pour afficher/masquer le mot de passe -->
                        <button 
                            type="button" 
                            class="password-toggle-btn"
                            onclick="togglePassword('password')"
                        >
                            <svg id="eye-open" class="icon-svg-small eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="submit-group">
                    <button 
                        type="submit" 
                        name="submit"
                        class="submit-btn"
                    >
                        <span class="submit-btn-icon">
                            <svg class="icon-svg-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
/**
 * Fonction pour basculer l'affichage du mot de passe
 */
function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById('eye-open');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
</script>

<?php
$content = ob_get_contents();
ob_end_clean();

require __DIR__ . '/../base-html.php';
?>