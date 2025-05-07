<?php
session_start();
if (!isset($_SESSION['vartotojas'])) {
    header("Location: login.php");
    exit();
}

$vardas = $_SESSION['vartotojas']['name'];
$role = $_SESSION['vartotojas']['role'];

echo "Sveikas, $vardas! Tavo rolė: $role<br>";
?>
<a href="logout.php">Atsijungti</a>
