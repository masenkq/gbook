<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>navstevni kniha</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2px; /*okraj od stranky vlevo a vpravo padding a mezi items je to margin*/
            margin: 0 auto ; /* Vycentruje obsah */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            height: 40px; /* Nastavení stejné výšky pro textová pole */
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #D3D3D3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-content: center;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #A9A9A9;
        }

        .body-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }/* Styl pro příspěvek */
        .prispevek {
            padding: 10px;
            margin-top: 10px;
            border-top: 1px solid black;
            width: 100%;
            box-sizing: border-box;

        }
        .prispevek:nth-child(even) {
            background-color: #D3D3D3; /* Barva pozadí pro sudé příspěvky */
        }

        .prispevek:nth-child(odd) {
            background-color: #A9A9A9; /* Barva pozadí pro liché příspěvky */
        }

        /* Styl pro hlavičku příspěvku - jméno a datum */
        .prispevek-header {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        /* Zarovnání jména vlevo a data vpravo */
        .prispevek-jmeno,
        .prispevek-datum
        {
            font-weight: bold;

        }



        /* Text zprávy pod hlavičkou */
        .prispevek-text {
            margin-top: 10px;
            text-align: justify;
        }

    </style>
</head>
<body>
<h1 class="body-title">guest book</h1>
<?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
    <!-- Kontrola, zda je nastaven úspěšna registrace -->
    <div id="successMessage" style="color: green; font-weight: bold;">
        Registrace byla úspěšná! Můžete nyní psát příspěvky
    </div>
<?php endif; ?>

<script>
    // Zkontroluj, jestli je zpráva úspěchu zobrazená
    const successMessage = document.getElementById("successMessage"); //najde element zpravy
    if (successMessage) {
        // Skrýt zprávu po 5 sekundách
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
</script>

<?php if (isset($_GET['error'])): ?>
    <div style="color: red; font-weight: bold;"><?php echo htmlspecialchars($_GET['error']); ?></div>

<?php endif; ?>


<form action="zapis.php" method="POST" name="gbook">
    <label for="jmeno">Jméno:</label>
    <input type="text" name="jmeno" id="jmeno" >

    <label for="email">Email:</label>
    <input name="email" id="email" type="email" required>

    <label for="zprava">Zpráva:</label>
    <textarea name="zprava" id="zprava"></textarea>
    <p>Nemáte účet? <a href="registrace.php">Zaregistrujte se zde</a></p>

    <input name="loginSubmit" value="odeslat" type="submit">
</form>

<?php

// hlasky
//if ($hlaska == 3) {
    //echo 'zadejte text, vratit se <a href = "javascript:self.history.back();">zpet</a>.';
//}

// vypis
echo "<hr>";
include_once("gbook.class.php"); // pripojuju tridu
$gbook = new gbook(); // vytvarim objekt
$prispevky = $gbook->vratPrispevky(); // promena prispevku, pole array

// vypsat všechny příspěvky

foreach ($prispevky as $prispevek) {


    // Formatování data
   /* $datum = date('Y-m-d', strtotime($prispevek->datum));*/

    // Formatování data na český formát

    //zlepsovak
    $datum = date('j. n. Y', strtotime($prispevek->datum)); //1.9.2019


    // Výstup celého příspěvku s barvou pozadí
    echo '<div class="prispevek">';
    echo '<div class="prispevek-header">';
    echo '<span  class="prispevek-jmeno">' . htmlspecialchars($prispevek->jmeno) . '</span>';
    echo '<span class="prispevek-datum">' . $datum . '</span>';
    echo '</div>';

    // Výstup textu zprávy pod tím
    echo '<div class="prispevek-text">';
    echo '<p>' . nl2br(htmlspecialchars($prispevek->text)) . '</p>'; // Zarovnání textu do bloku     text-align: justify;
    echo '</div>'; // Uzavření divu pro příspěvek
}
    ?>

</body>
</html>
