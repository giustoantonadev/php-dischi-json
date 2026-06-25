<?php
$dischi = file_get_contents('dischi.json');
$dischi = json_decode($dischi, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9e9e9;
            padding: 30px 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1100px;
            margin: 0 auto 40px auto;
        }

        .card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        /* FORM */
        form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form input {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form button {
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        form button:hover {
            background: #0056b3;
        }
    </style>

</head>

<body>
    <div class="container">
        <?php foreach ($dischi as $disco) { ?>
            <div class="card">
                <img src="<?php echo $disco['url_cover'] ?>" alt="">
                <h2><?php echo $disco['titolo'] ?></h2>
                <p><?php echo $disco['artista'] ?></p>
                <p><?php echo $disco['anno'] ?></p>
            </div>
        <?php } ?>
    </div>

    <!-- Tramite un form, dai la possibilità all'utente di aggiungere un disco dall'elenco. -->
    <form action="aggiungi_disco.php" method="POST">
        <input type="text" name="titolo" placeholder="Titolo">
        <input type="text" name="artista" placeholder="Artista">
        <input type="text" name="anno" placeholder="Anno">
        <input type="text" name="url_cover" placeholder="URL Copertina">
        <button type="submit">Aggiungi Disco</button>
    </form>

</body>

</html>