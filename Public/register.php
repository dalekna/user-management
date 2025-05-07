<?php
require '../autoload.php';

use App\Models\User;

$zinute = null;
$generuotasSlaptazodis = null;

function generuotiSlaptazodi($ilgis = 10): string {
    return bin2hex(random_bytes($ilgis / 2));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vardas = $_POST['vardas'];
    $pavarde = $_POST['pavarde'];
    $elpastas = $_POST['elpastas'];
    $slaptazodis = $_POST['slaptazodis'];

    if (empty($slaptazodis)) {
        $slaptazodis = generuotiSlaptazodi();
        $generuotasSlaptazodis = $slaptazodis;
    }

    $naujasVartotojas = new User($vardas, $pavarde, $elpastas, $slaptazodis);

    if ($naujasVartotojas->issaugoti()) {
        $zinute = "Registracija sėkminga! <a href='login.php'>Prisijunk čia</a>";
    } else {
        $zinute = "Klaida registruojantis.";
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-3">Registracija</h2>

        <?php if ($zinute): ?>
            <div class="alert alert-info"><?php echo $zinute; ?></div>
        <?php endif; ?>

        <?php if ($generuotasSlaptazodis): ?>
            <div class="alert alert-warning">
                Jums buvo automatiškai sugeneruotas slaptažodis: <strong><?php echo htmlspecialchars($generuotasSlaptazodis); ?></strong>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="vardas" class="form-label">Vardas</label>
                <input type="text" class="form-control" name="vardas" id="vardas" required>
            </div>
            <div class="mb-3">
                <label for="pavarde" class="form-label">Pavardė</label>
                <input type="text" class="form-control" name="pavarde" id="pavarde" required>
            </div>
            <div class="mb-3">
                <label for="elpastas" class="form-label">El. paštas</label>
                <input type="email" class="form-control" name="elpastas" id="elpastas" required>
            </div>
            <div class="mb-3">
                <label for="slaptazodis" class="form-label">Slaptažodis</label>
                <input type="password" class="form-control" name="slaptazodis" id="slaptazodis">
                <div class="form-text">Palikite tuščią, jei norite, kad jis būtų sugeneruotas automatiškai</div>
            </div>
            <button type="submit" class="btn btn-success">Registruotis</button>
        </form>

        <p class="mt-3">
            Jau turite paskyrą? <a href="login.php">Prisijunkite čia</a>
        </p>
    </div>
</div>
</body>
</html>
