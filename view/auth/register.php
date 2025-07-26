<?php
$title = "Inscription - Ma Mangathèque";
ob_start();
?>

<div class="register-container">
    <div class="register-wrapper">
        <!-- En-tête du formulaire -->
        <div class="register-header">
            <div class="register-icon">
                <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="register-title">
                Créez votre compte
            </h2>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="register-form-container">
            <form class="register-form" action="/mangatheque/register" method="POST">
                <!-- Champ Pseudo -->
                <div class="form-group">
                    <label for="pseudo" class="form-label">
                        Nom d'utilisateur
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg class="icon-svg-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            id="pseudo"
                            name="pseudo"
                            type="text"
                            autocomplete="username"
                            required
                            class="form-input-register"
                            placeholder="Votre nom d'utilisateur">
                    </div>
                </div>

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
                            class="form-input-register"
                            placeholder="votre@email.com">
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
                            autocomplete="new-password"
                            required
                            class="form-input-register form-input-password"
                            placeholder="Choisissez un mot de passe sécurisé"
                            oninput="checkPasswordStrength(this.value)">

                        <!-- Bouton pour afficher/masquer le mot de passe -->
                        <button
                            type="button"
                            class="password-toggle-btn"
                            onclick="togglePassword('password')">
                            <svg id="eye-open-register" class="icon-svg-small eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        class="submit-btn-register">
                        <span class="submit-btn-icon">
                            <svg class="icon-svg-small" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour les fonctionnalités interactives -->
<script>
    /**
     * Fonction pour basculer l'affichage du mot de passe
     * @param {string} inputId - L'ID du champ de mot de passe
     */
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById('eye-open-register');

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