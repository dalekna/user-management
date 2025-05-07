<?php
require '../autoload.php';

use App\Core\Database;

session_start();
if (!isset($_SESSION['vartotojas'])) {
    header("Location: login.php");
    exit();
}

$pdo = Database::getInstance()->getConnection();
$vartotojas = $_SESSION['vartotojas'];

// Trinimas
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM faults WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $vartotojas['id']]);
    header("Location: faultlist.php");
    exit();
}

// Gaunam visus įrašus
$stmt = $pdo->query("
    SELECT f.*, u.email 
    FROM faults f 
    JOIN users u ON f.user_id = u.id 
    ORDER BY f.created_at DESC
");
$faults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Gedimų sąrašas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Visi gedimų įrašai</h2>
    <a href="home.php" class="btn btn-secondary mb-3">⬅️ Grįžti</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Pavadinimas</th>
                <th>Aprašymas</th>
                <th>Vieta</th>
                <th>IP</th>
                <th>Vartotojas</th>
                <th>Data</th>
                <th>Veiksmas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($faults as $fault): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fault['title']); ?></td>
                    <td><?php echo htmlspecialchars($fault['description']); ?></td>
                    <td><?php echo htmlspecialchars($fault['location']); ?></td>
                    <td><?php echo htmlspecialchars($fault['ip_address']); ?></td>
                    <td><?php echo htmlspecialchars($fault['email']); ?></td>
                    <td><?php echo $fault['created_at']; ?></td>
                    <td>
                        <?php if ($fault['user_id'] == $vartotojas['id']): ?>
                            <a href="?delete=<?php echo $fault['id']; ?>" class="btn btn-sm btn-danger">🗑️ Trinti</a>
                        <?php else: ?>
                            <em>-</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
