<?php
require_once 'db_connect.php';
include 'header.php';

$student = null;
$grades = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations de l'étudiant
    $sqlStudent = "SELECT * FROM students WHERE id = :id";
    $stmtStudent = $pdo->prepare($sqlStudent);
    $stmtStudent->execute([':id' => $id]);
    $student = $stmtStudent->fetch();

    if ($student) {
        // Récupérer les notes avec le titre des cours (JOIN)
        $sqlGrades = "
            SELECT c.titre, g.note 
            FROM grades g
            JOIN courses c ON g.course_id = c.id
            WHERE g.student_id = :id
        ";
        $stmtGrades = $pdo->prepare($sqlGrades);
        $stmtGrades->execute([':id' => $id]);
        $grades = $stmtGrades->fetchAll();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="card-title mb-0"><i class="bi bi-person-badge me-2"></i>Détails de l'Étudiant</h5>
                </div>
                <div class="card-body">
                    <?php if ($student): ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Matricule</span>
                                <span class="fw-bold">#<?php echo htmlspecialchars($student['id']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Nom Complet</span>
                                <span><?php echo htmlspecialchars($student['nom'] . ' ' . $student['prenom']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Email</span>
                                <span><?php echo htmlspecialchars($student['email']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Date de Naissance</span>
                                <span><?php echo htmlspecialchars($student['date_naissance'] ?? 'Non spécifiée'); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light mt-2">
                                <span class="fw-bold">Moyenne Générale</span>
                                <span class="badge <?php echo $student['moyenne'] >= 10 ? 'bg-success' : 'bg-danger'; ?> fs-6">
                                    <?php echo number_format($student['moyenne'], 2); ?> / 20
                                </span>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-3">
                    <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-pencil"></i> Modifier les infos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="card-title mb-0"><i class="bi bi-journal-check me-2"></i>Relevé de Notes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Matière</th>
                                    <th class="text-center">Note / 20</th>
                                    <th class="text-center">Observation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($grades) > 0): ?>
                                    <?php foreach ($grades as $grade): ?>
                                        <tr>
                                            <td class="ps-3 fw-medium"><?php echo htmlspecialchars($grade['titre']); ?></td>
                                            <td class="text-center fw-bold"><?php echo htmlspecialchars($grade['note']); ?></td>
                                            <td class="text-center">
                                                <?php if ($grade['note'] >= 10): ?>
                                                    <small class="text-success"><i class="bi bi-check-circle-fill"></i> Validé</small>
                                                <?php else: ?>
                                                    <small class="text-danger"><i class="bi bi-x-circle-fill"></i> Non validé</small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted italic">
                                            <i class="bi bi-exclamation-triangle fs-2 d-block mb-2"></i>
                                            Aucune note n'a été saisie pour cet étudiant.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3 mb-5">
        <a href="index.php" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Retour au Tableau de Bord
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>