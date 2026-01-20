<?php
require_once 'db_connect.php';
include 'header.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $dateNaissance = $_POST['date_naissance'] ?? '';

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($dateNaissance)) {
        try {
            // Appel de la procédure stockée addstudent 
            $sql = "CALL addstudent(:nom, :prenom, :email, :date_naissance)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':date_naissance' => $dateNaissance
            ]);

            $message = "Étudiant ajouté avec succès !";

        } catch (PDOException $e) {
            // Gestion des erreurs 
            $error = "Erreur système : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4 text-center">Ajouter un Étudiant</h3>

                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" placeholder="Ex: Alami" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="prenom" placeholder="Ex: Omar" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="exemple@domaine.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date de Naissance</label>
                        <input type="date" class="form-control" name="date_naissance" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enregistrer l'étudiant</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Retour au Tableau de Bord</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>