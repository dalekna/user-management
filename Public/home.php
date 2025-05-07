<?php
session_start();
if (!isset($_SESSION['vartotojas'])) {
    header("Location: login.php");
    exit();
}

$vardas = $_SESSION['vartotojas']['name'];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Vartotojo meniu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-geltona {
            background-color: #FFCC00;
            color: black;
        }
        .btn-zalia {
            background-color: #007A33;
            color: white;
        }
        .btn-raudona {
            background-color: #BF1E2E;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow" style="border-top: 10px solid #FFCC00;">
        <h2 class="mb-4">Sveikas, <?php echo htmlspecialchars($vardas); ?>!</h2>
        <p>Ką norėtum daryti?</p>

        <div class="d-flex flex-column gap-3">
            <a href="faultreg.php" class="btn btn-geltona btn-lg">🟡 Registruoti gedimą</a>
            <a href="faultlist.php" class="btn btn-zalia btn-lg">🟢 Peržiūrėti visus gedimus</a>
            <a href="logout.php" class="btn btn-raudona btn-lg">🔴 Atsijungti</a>
        </div>
    </div>
</div>
</body>
</html>
