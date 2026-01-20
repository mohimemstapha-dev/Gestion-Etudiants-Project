<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #4f46e5;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease-in-out;
            background-color: var(--card-bg);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .table-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .table thead th {
            background-color: #f1f5f9;
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #64748b;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .status-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-admis {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-ajourne {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>EduManager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_student.php">Ajouter Étudiant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_grade.php">Ajouter Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_course.php">Ajouter Cours</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="height: 80px;"></div> <!-- Spacer for fixed navbar -->
    <div class="container py-4">