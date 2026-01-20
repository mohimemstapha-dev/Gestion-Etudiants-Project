<?php
require_once 'db_connect.php';
include 'header.php';

$message = '';
$error = '';

// Get Students List ordered alphabetically
$sqlStudents = "SELECT * FROM students ORDER BY nom ASC";
$stmtStudents = $pdo->prepare($sqlStudents);
$stmtStudents->execute();
$students = $stmtStudents->fetchAll();

// Get Courses List ordered by title
$sqlCourses = "SELECT * FROM courses ORDER BY titre ASC";
$stmtCourses = $pdo->prepare($sqlCourses);
$stmtCourses->execute();
$courses = $stmtCourses->fetchAll();

// ========================================================
// 2. Process Form Data
// ========================================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = $_POST['student_id'] ?? '';
    $courseId = $_POST['course_id'] ?? '';
    $note = $_POST['note'] ?? '';

    if (!empty($studentId) && !empty($courseId) && $note !== '') {
        try {
            // Call Stored Procedure: addgrade
            $sqlAddGrade = "CALL addgrade(:student_id, :course_id, :note)";
            $stmtAddGrade = $pdo->prepare($sqlAddGrade);
            
            $stmtAddGrade->execute([
                ':student_id' => $studentId,
                ':course_id' => $courseId,
                ':note' => $note
            ]);

            $message = "Note ajoutée avec succès ! La moyenne a été mise à jour.";
            
        } catch (PDOException $e) {
            // Check for Custom SQLState '45000' from the procedure
            if ($e->getCode() === '45000') {
               $error = "Erreur de validation : " . $e->getMessage();
            } else {
               $error = "Erreur système : " . $e->getMessage();
            }
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4 text-center">Ajouter une Note</h3>

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

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Étudiant</label>
                        <select class="form-select" name="student_id" required>
                            <option value="">Sélectionner un étudiant...</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo htmlspecialchars($student['id']); ?>">
                                    <?php echo htmlspecialchars($student['nom'] . ' ' . $student['prenom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Matière</label>
                        <select class="form-select" name="course_id" required>
                            <option value="">Sélectionner une matière...</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo htmlspecialchars($course['id']); ?>">
                                    <?php echo htmlspecialchars($course['titre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note (sur 20)</label>
                        <input type="number" step="0.01" class="form-control" name="note" placeholder="Ex: 15.50" required>
                        <div class="form-text text-muted">La note doit être comprise entre 0 et 20.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enregistrer la note</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2 text-decoration-none">Retour à la liste</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>