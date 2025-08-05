<!-- Section Requests -->
<section id="requests" class="section">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number"><?= $enAttente; ?></div>
            <div class="stat-label">En Attente</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $approuve; ?></div>
            <div class="stat-label">Approuvées</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $rejete; ?></div>
            <div class="stat-label">Rejetées</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Gestion des Requests</h2>
        </div>
        <p>Interface de gestion des requests avec traitement et suivi des demandes.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Objet</th>
                    <th>Email</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php if (!empty($requests)) : ?>
                    <div>
                        <?php foreach ($requests as $result) : ?>
                            <?php
                            $dateFormatee = date('d-m-Y', strtotime($result['date']));
                            ?>
                            <tr>
                                <!-- ID -->
                                <td><?= $result['id']; ?></td>
                                <!-- Nom -->
                                <td><?= $result['nom']; ?></td>
                                <!-- Objet -->
                                <td><?= $result['objet']; ?></td>
                                <!-- Email -->
                                <td><?= $result['email']; ?></td>
                                <!-- Commentaire -->
                                <td><?= nl2br($result['commentaire']) ?></td>
                                <!-- Date -->
                                <td><?= $dateFormatee; ?></td>
                                <!-- Status -->
                                <td><?= $result['status']; ?></td>
                                <!-- Action -->
                                <td>
                                    <div class="actions">
                                        <?php if ($result['status'] === "En attente") : ?>
                                            <form method="post" style="display:inline;">
                                                <button class="btn btn-success" type="submit" name="ApproveBTN" value="<?= $result['id']; ?>">Approuver</button>
                                            </form>
                                            <form method="post" style="display:inline;">
                                                <button class="btn btn-danger" type="submit" name="RejectBTN" value="<?= $result['id']; ?>">Rejeter</button>
                                            </form>
                                        <?php elseif ($result['status'] === "Approuvé" || $result['status'] === "Rejeté") : ?>
                                            <form method="post" style="display:inline;">
                                                <button class="btn btn-danger" type="submit" name="DeleteBTN" value="<?= $result['id']; ?>">Supprimer</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>