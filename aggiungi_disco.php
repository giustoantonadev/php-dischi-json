<?php
$titolo = $_POST['titolo'] ?? '';
$artista = $_POST['artista'] ?? '';
$anno = $_POST['anno'] ?? '';
$url_cover = $_POST['url_cover'] ?? '';

//controllo minimo dei campi
if (!empty($titolo) && !empty($artista) && !empty($anno) && !empty($url_cover)) {
    $disco = [
        'titolo' => $titolo,
        'artista' => $artista,
        'anno' => $anno,
        'url_cover' => $url_cover
    ];

    // Leggi il contenuto del file JSON esistente
    $fileContent = file_get_contents('dischi.json');
    $dischi = json_decode($fileContent, true);

    // Aggiungi il nuovo disco all'array
    $dischi[] = $disco;

    // Salva l'array aggiornato nel file JSON
    file_put_contents('dischi.json', json_encode($dischi, JSON_PRETTY_PRINT));

    // Reindirizza alla pagina principale dopo l'aggiunta
    header('Location: index.php');
    exit();
} else {
    echo "Tutti i campi sono obbligatori.";
}

?>