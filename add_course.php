<?php
require_once 'db_connect.php';
include 'header.php';

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le titre du cours
    $titre = $_POST['titre'] ?? '';

    if (!empty($titre)) {
        try {
            // Préparer la requête d'insertion dans la table 'courses'
            $sql = "INSERT INTO courses (titre) VALUES (:titre)";
            $stmt = $pdo->prepare($sql);

            // Exécuter la requête
            $stmt->execute([':titre' => $titre]);

            $message = '<div class="alert alert-success alert-dismissible fade show">
                            Cours ajouté avec succès !
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur système : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez entrer un titre pour le cours.</div>';
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Ajouter une Matière</h4>
                </div>
                <div class="card-body p-4">
                    <?php echo $message; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de la Matière</label>
                            <input type="text" class="form-control" id="titre" name="titre" placeholder="Ex: Algorithmique" required>
                            <div class="form-text">Ce titre sera affiché dans la liste des notes.</div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Enregistrer la matière</button>
                        <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Retour au Dashboard</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>