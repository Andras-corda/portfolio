<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2025 Portfolio. Conçu avec <i class="fas fa-heart"></i> et beaucoup de café</p>
            </div>
            <div class="footer-right">
                <a href="#" class="footer-link" id="privacy-link">Politique de confidentialité</a>
                <a href="#" class="footer-link" id="legal-link">Mentions légales</a>

                <!-- si $_SESSION est connecté alors afficher-->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['certification'] === "admin") : ?>
                    <a href="/admin" class="footer-link">Administration</a>
                    <a href="/logout" class="footer-link">Déconnexion</a>
                <?php else : ?> <!-- sinon alors afficher-->
                    <a href="/login" class="footer-link">Connexion</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</footer>