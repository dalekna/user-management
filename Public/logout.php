<?php
require '../autoload.php';

use App\Services\AuthService;

$klaida = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $elpastas = $_POST['elpastas'];
    $slaptazodis = $_POST['slaptazodis'];

    $auth = new AuthService();
    $atsakymas = $auth->login($elpastas, $slaptazodis);

    if ($atsakymas === "Sėkmingai prisijungta!") {
        header("Location: index.php");
        exit();
    } else {
        $klaida = $atsakymas;
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-3">Prisijungimas</h2>

        <?php if ($klaida): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($klaida); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="elpastas" class="form-label">El. paštas</label>
                <input type="email" class="form-control" name="elpastas" id="elpastas" required>
            </div>
            <div class="mb-3">
                <label for="slaptazodis" class="form-label">Slaptažodis</label>
                <input type="password" class="form-control" name="slaptazodis" id="slaptazodis" required>
            </div>
            <button type="submit" class="btn btn-primary">Prisijungti</button>
        </form>
        <p class="mt-3">
            Neturite paskyros? <a href="register.php">Registruokitės čia</a>
        </p>
    </div>
</div>
</body>
</html>
