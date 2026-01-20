<?php
require_once 'db_connect.php';
include 'header.php';

// 1. Statistiques
$sqlCountStudents = "SELECT COUNT(*) FROM students";
$stmtCountStudents = $pdo->prepare($sqlCountStudents);
$stmtCountStudents->execute();
$totalStudents = $stmtCountStudents->fetchColumn();

$sqlCountCourses = "SELECT COUNT(*) FROM courses";
$stmtCountCourses = $pdo->prepare($sqlCountCourses);
$stmtCountCourses->execute();
$totalCourses = $stmtCountCourses->fetchColumn();

// 2. Liste des Étudiants
$sqlStudents = "SELECT * FROM students ORDER BY created_at DESC";
$stmtStudents = $pdo->prepare($sqlStudents);
$stmtStudents->execute();
$students = $stmtStudents->fetchAll();
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Tableau de Bord</h2>
        <p class="text-muted">Vue d'ensemble de la gestion académique</p>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6 mb-3">
        <div class="card p-3 h-100 shadow-sm border-0 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2 opacity-75">Total Étudiants</h6>
                    <h3 class="fw-bold mb-0"><?php echo htmlspecialchars($totalStudents); ?></h3>
                </div>
                <div class="icon-shape bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card p-3 h-100 shadow-sm border-0 bg-dark text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2 opacity-75">Total Cours</h6>
                    <h3 class="fw-bold mb-0"><?php echo htmlspecialchars($totalCourses); ?></h3>
                </div>
                <div class="icon-shape bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-book-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-bold mb-0">Liste des Étudiants</h5>
                    <a href="add_student.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Nouvel Étudiant
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#ID</th>
                                <th>Nom & Prénom</th>
                                <th>Email</th>
                                <th>Moyenne</th>
                                <th>Résultat</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($students)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Aucun enregistrement trouvé</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><span class="text-muted">#<?php echo htmlspecialchars($student['id']); ?></span></td>
                                        <td class="fw-bold">
                                            <?php echo htmlspecialchars($student['nom'] . ' ' . $student['prenom']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td>
                                            <span class="fw-bold <?php echo $student['moyenne'] >= 10 ? 'text-success' : 'text-danger'; ?>">
                                                <?php echo number_format($student['moyenne'], 2); ?> / 20
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($student['moyenne'] >= 10): ?>
                                                <span class="badge bg-success-subtle text-success border border-success">Admis</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger">Ajourné</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="view_student.php?id=<?php echo $student['id']; ?>" class="btn btn-outline-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-outline-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="delete_student.php?id=<?php echo $student['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm"
                                                   onclick="return confirm('Confirmer la suppression de cet étudiant ?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>