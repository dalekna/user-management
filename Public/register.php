<?php
require '../autoload.php';

use App\Models\User;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vardas = $_POST['vardas'];
    $elpastas = $_POST['elpastas'];
    $slaptazodis = $_POST['slaptazodis'];

    $naujasVartotojas = new User($vardas, $elpastas, $slaptazodis);
    
    if ($naujasVartotojas->issaugoti()) {
        echo "Registracija sėkminga! <a href='login.php'>Prisijunk čia</a>";
    } else {
        echo "Klaida registruojantis.";
    }
}
?>

<h2>Registracija</h2>
<form method="POST">
    Vardas: <input type="text" name="vardas" required><br>
    El. paštas: <input type="email" name="elpastas" required><br>
    Slaptažodis: <input type="password" name="slaptazodis" required><br>
    <button type="submit">Registruotis</button>
</form>
