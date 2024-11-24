<?php
// Připojení k databázi
include 'db.php';
$db = new mysqli("localhost", $user, $pass, $dbname);

// Kontrola připojení
if ($db->connect_error) die("Chyba připojení: " . $db->connect_error);

// Načtení hodnot z formuláře
$email = htmlspecialchars($_POST['email']);
$heslo = $_POST['heslo'];
$potvrzeni_hesla = $_POST['potvrzeni_hesla'];
$hashovane_heslo = password_hash($heslo, PASSWORD_DEFAULT);
// Kontrola hesel
if ($heslo !== $potvrzeni_hesla) {
    header('Location: registrace.php?error=true'); // Přesměrování s chybou
    exit; // Ukončení skriptu
}

// Zápis do databáze
$sql = "INSERT INTO uzivatele (email, heslo) VALUES (?, ?)";
$stmt = $db->prepare($sql); //priprava dotazu


$stmt->bind_param("ss", $email, $hashovane_heslo); // Upravena na "ss" pro email a hash hesla

if ($stmt->execute()) {
    header('Location: index.php?success=true'); // Přesměrování na guest book s úspěšnou zprávou
} else {
    echo '<div style="color: red;">Chyba: ' . $stmt->error . '</div>'; // Chybová zpráva
}

$stmt->close();
$db->close();
?>
