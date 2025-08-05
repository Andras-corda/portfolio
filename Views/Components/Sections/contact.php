<!-- Section Contact -->
<section id="contact" class="contact">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-envelope"></i>
                Me contacter
            </h2>
            <p class="section-description">N'hésitez pas à me contacter pour discuter de vos projets</p>
        </div>
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-card">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>andrascorda.switch@gmail.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Localisation</h4>
                            <p>Namur, Belgique</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Disponibilité</h4>
                            <p>Lun - Ven, 9h - 18h</p>
                        </div>
                    </div>
                </div>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=andrascorda.switch@gmail.com"
                        class="social-link">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="https://discord.com/users/411170239607472128" class="social-link">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="/" class="social-link">
                        <i class="fas fa-globe"></i>
                    </a>
                </div>
            </div>
            <form class="contact-form" id="contact-form" method="post">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" name="nom" placeholder="Exemple : Julien" required />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Exemple : Julien@gmail.com" required />
                    </div>
                    <div class="form-group">
                        <label for="subject">Objet</label>
                        <input type="text" name="objet" placeholder="Exemple : Ça va être tout noir" required />
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="commentaire" rows="5" placeholder="Écrivez un court message ici..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btnEnvoi">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer le message
                    </button>
                </form>
        </div>
    </div>
</section>