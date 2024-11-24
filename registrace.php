<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            height: 40px; /* Nastavení stejné výšky pro textová pole */
        }
    </style>
</head>
<body>
<h1>Registrace</h1>

<?php if (isset($_GET['error'])): ?>
    <div style="color: red; font-weight: bold;">
        Hesla se neshodují!
    </div>
<?php elseif (isset($_GET['success'])): ?>

    <div style="color: green; font-weight: bold;">
        Registrace byla úspěšná! Můžete nyní psát příspěvky.
    </div>
<?php endif; ?>

<form action="zapis_registraci.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="heslo">Heslo:</label>
    <input type="password" name="heslo" id="heslo" required>

    <label for="potvrzeni_hesla">Potvrzení hesla:</label>
    <input type="password" name="potvrzeni_hesla" id="potvrzeni_hesla" required>
    <p>Máte účet? <a href="index.php">Kliknete se zde</a></p>
    <input type="submit" value="Zaregistrovat se">
</form>
</body>
</html>
