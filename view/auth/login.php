<?php
$title = "Connexion - Ma Mangathèque";
ob_start();
?>

<div class="login-container">
    <div class="login-wrapper">
        <!-- En-tête du formulaire -->
        <div class="login-header">
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
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            class="form-input"
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
                            autocomplete="current-password"
                            required
                            class="form-input form-input-password"
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
                        class="submit-btn">
                        Se connecter
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