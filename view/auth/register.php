<?php
$title = "Inscription - Ma Mangathèque";
ob_start();
?>

<div class="register-container">
    <div class="register-wrapper">
        <!-- En-tête du formulaire -->
        <div class="register-header">
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
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="form-input-register form-input-password"
                            placeholder="Votre mot de passe">

                        <!-- Bouton pour afficher/masquer le mot de passe -->
                        <button
                            type="button"
                            class="password-toggle-btn"
                            onclick="togglePassword('password')">
                            <span id="eye-open" class="unicode-icon-small eye-icon">👁️</span>
                            <span id="eye-closed" class="unicode-icon-small eye-icon" style="display: none;">🙈</span>
                        </button>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="submit-group">
                    <button
                        type="submit"
                        name="submit"
                        class="submit-btn-register">
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();

require __DIR__ . '/../base-html.php';
?>