<?php
require '../autoload.php';

use App\Services\AuthService;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $elpastas = $_POST['elpastas'];
    $slaptazodis = $_POST['slaptazodis'];

    $auth = new AuthService();
    echo $auth->login($elpastas, $slaptazodis);
}
?>

<h2>Prisijungimas</h2>
<form method="POST">
    El. paštas: <input type="email" name="elpastas" required><br>
    Slaptažodis: <input type="password" name="slaptazodis" required><br>
    <button type="submit">Prisijungti</button>
</form>
