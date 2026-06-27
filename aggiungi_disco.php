<?php

// Recupero dei dati dal form
$titolo = trim($_POST['titolo'] ?? '');
$artista = trim($_POST['artista'] ?? '');
$anno = trim($_POST['anno'] ?? '');
$url_cover = trim($_POST['url_cover'] ?? '');

// Validazione avanzata
$errors = [];

// Campi vuoti
if ($titolo === '' || $artista === '' || $anno === '' || $url_cover === '') {
    $errors[] = "Tutti i campi sono obbligatori.";
}

// Anno deve essere numerico e plausibile
if (!ctype_digit($anno) || (int)$anno < 1900 || (int)$anno > date("Y") + 1) {
    $errors[] = "L'anno inserito non è valido.";
}

// URL deve essere valido
if (!filter_var($url_cover, FILTER_VALIDATE_URL)) {
    $errors[] = "L'URL della copertina non è valido.";
}

// Se ci sono errori → li mostro e stoppo
if (!empty($errors)) {
    echo "<h2>Errore nell'inserimento:</h2>";
    foreach ($errors as $err) {
        echo "<p>- $err</p>";
    }
    echo '<p><a href="index.php">Torna indietro</a></p>';
    exit;
}

// Leggo il file JSON
$fileContent = file_get_contents('dischi.json');
$dischi = json_decode($fileContent, true);

// Se il JSON è vuoto o corrotto → inizializzo array vuoto
if (!is_array($dischi)) {
    $dischi = [];
}

// Creo il nuovo disco
$nuovo_disco = [
    "titolo" => $titolo,
    "artista" => $artista,
    "anno" => (int)$anno,
    "url_cover" => $url_cover
];

// Aggiungo il disco
$dischi[] = $nuovo_disco;

// Codifico il JSON e controllo errori
$json = json_encode($dischi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
    echo "<h2>Errore: impossibile codificare il JSON.</h2>";
    echo '<p><a href="index.php">Torna indietro</a></p>';
    exit;
}

// Riscrivo il file in modo sicuro (lock)
$bytes = @file_put_contents('dischi.json', $json, LOCK_EX);
if ($bytes === false) {
    echo "<h2>Errore: impossibile scrivere su dischi.json.</h2>";
    echo '<p><a href="index.php">Torna indietro</a></p>';
    exit;
}

// Redirect alla pagina principale
header('Location: index.php');
exit;
