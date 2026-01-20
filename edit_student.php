<?php
require_once 'db_connect.php';
include 'header.php';

$message = '';
$error = '';
$student = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $student = $stmt->fetch();

    if (!$student) {
        $error = "Étudiant non trouvé dans la base de données.";
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $student) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $dateNaissance = $_POST['date_naissance'] ?? '';

    if (!empty($nom) && !empty($prenom) && !empty($email)) {
        try {
            $sqlInfo = "UPDATE students SET nom = :nom, prenom = :prenom, email = :email, date_naissance = :date_naissance WHERE id = :id";
            $stmtInfo = $pdo->prepare($sqlInfo);
            $stmtInfo->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':date_naissance' => $dateNaissance ?: null,
                ':id' => $id
            ]);

            $message = "Informations de l'étudiant mises à jour avec succès !";
            
            // Refresh local data
            $stmt->execute([':id' => $id]);
            $student = $stmt->fetch();

        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
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
                <h3 class="fw-bold mb-4 text-center">Modifier l'Étudiant</h3>

                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($student): ?>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($student['nom']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="prenom" value="<?php echo htmlspecialchars($student['prenom']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" class="form-control" name="date_naissance" value="<?php echo htmlspecialchars($student['date_naissance'] ?? ''); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
                        <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Annuler et retourner</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>