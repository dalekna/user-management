<?php
session_start();
if (!isset($_SESSION['vartotojas'])) {
    header("Location: login.php");
    exit();
}

$vardas = $_SESSION['vartotojas']['name'];
$role = $_SESSION['vartotojas']['role'];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Pradinis puslapis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h1 class="mb-3">Sveikas, <?php echo htmlspecialchars($vardas); ?>!</h1>
            <p>Tavo rolė: <strong><?php echo htmlspecialchars($role); ?></strong></p>
            <a href="logout.php" class="btn btn-danger">Atsijungti</a>
        </div>
    </div>
</body>
</html>
