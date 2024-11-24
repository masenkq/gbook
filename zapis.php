<?php
// Připojení k databázi
include 'db.php';
$db = new mysqli("localhost", $user, $pass, $dbname);

// Kontrola připojení
if ($db->connect_error) {
    die("Chyba připojení: " . $db->connect_error);
}

// Načtení hodnot z formuláře a ošetření
$jmeno = htmlspecialchars($_POST['jmeno']);
$email = htmlspecialchars($_POST['email']);
$zprava = htmlspecialchars($_POST['zprava']);

// Získání IP adresy uživatele,,guest book tabulka
$ip = $_SERVER['REMOTE_ADDR'];

// Kontrola, zda je uživatel zaregistrován
$sql_check = "SELECT * FROM uzivatele WHERE email = '$email'";
$result_check = $db->query($sql_check);

if ($result_check->num_rows == 0) {
    // Pokud není registrován, nastaví se chybová zpráva
    $error = 'Nejste registrován!'; // Chybová zpráva
} else {
    // Zapisování příspěvku do databáze jestli uzivatel je zaregistrovan
    $sql_insert = "INSERT INTO gbook (jmeno, email, text, datum, IP) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = $db->prepare($sql_insert);//priprava dorazu
//jestli se podarila tak zapiseme do databaze t oc uzivatel napsal do input forms
    if ($stmt) {
        $stmt->bind_param("ssss", $jmeno, $email, $zprava, $ip); // Přidání IP adresy do příkazu
//jestli je vlozeni prispevku uspesne tak todle
        if ($stmt->execute()) {
            // Příspěvek byl úspěšně uložen
            header("Location: index.php?success=1");
            exit;
            //jestli ne tak error
        } else {
            // Chyba při ukládání příspěvku
            $error = "Chyba při ukládání příspěvku: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Chyba při přípravě dotazu
        $error = "Chyba při přípravě dotazu: " . $db->error;
    }
}

// Uzavření připojení k databázi
$db->close();

// Zobrazení chyby na index.php
if (isset($error)) {
    header("Location: index.php?error=" . urlencode($error));
    exit;
}
?>
