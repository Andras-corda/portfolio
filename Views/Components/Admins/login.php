<!-- Views/Components/Admins/login.php -->
<div class="login-container">
    <h2 class="login-title">Connexion</h2>

    <?php if (isset($loginError) && !empty($loginError)): ?>
        <div class="error-alert">
            <span class="error-icon">⚠️</span>
            <span class="error-text"><?php echo htmlspecialchars($loginError); ?></span>
            <button class="error-close" onclick="this.parentElement.style.display='none'">×</button>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login" id="loginForm">
        <div class="form-group">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text"
                id="username"
                name="username"
                class="form-input"
                required
                autofocus
                placeholder="Entrez votre nom d'utilisateur"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password"
                id="password"
                name="password"
                class="form-input"
                required
                placeholder="Entrez votre mot de passe">
        </div>

        <button type="submit" name="btnLogin" class="submit-btn" id="submitBtn">
            <span class="btn-text">Se connecter</span>
        </button>
    </form>
</div>