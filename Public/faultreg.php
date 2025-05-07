<?php
require '../autoload.php';

use App\Core\Database;

session_start();
if (!isset($_SESSION['vartotojas'])) {
    header("Location: login.php");
    exit();
}

$zinute = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pdo = Database::getInstance()->getConnection();

    $userId = $_SESSION['vartotojas']['id'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'nežinomas';
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    $stmt = $pdo->prepare("INSERT INTO faults (user_id, title, description, location, ip_address) VALUES (?, ?, ?, ?, ?)");
    $success = $stmt->execute([$userId, $title, $description, $location, $ip]);

    if ($success) {
        $zinute = "Gedimas užregistruotas sėkmingai!";
    } else {
        $zinute = "Klaida registruojant gedimą.";
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Gedimo registravimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-3">Gedimo registravimas</h2>

        <?php if ($zinute): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($zinute); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Pavadinimas</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Aprašymas</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Vieta</label>
                <input type="text" name="location" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Registruoti gedimą</button>
        </form>

        <p class="mt-3">
            <a href="home.php">Grįžti į pradžią</a>
        </p>
    </div>
</div>
</body>
</html>
