<?php
$dischi_raw = @file_get_contents('dischi.json');
if ($dischi_raw === false) {
    $dischi = [];
} else {
    $dischi = json_decode($dischi_raw, true);
    if (!is_array($dischi)) {
        $dischi = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dischi</title>

    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", Arial, sans-serif;
            background: #121212;
            color: #eaeaea;
            padding: 40px 0;
        }

        /* GRID */
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto 50px auto;
            padding: 0 20px;
        }

        /* CARD */
        .card {
            background: #1e1e1e;
            padding: 18px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.6);
        }

        .card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .card p {
            font-size: 15px;
            color: #bdbdbd;
        }

        /* BUTTON */
        .open-modal {
            display: block;
            margin: 0 auto 30px auto;
            padding: 12px 20px;
            background: #6b4dff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .open-modal:hover {
            background: #5538d1;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #1e1e1e;
            padding: 25px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .modal-content h2 {
            margin-bottom: 15px;
        }

        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
            color: #aaa;
        }

        .close:hover {
            color: white;
        }

        /* FORM */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form input {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #333;
            background: #2a2a2a;
            color: #eaeaea;
            font-size: 16px;
        }

        form input::placeholder {
            color: #888;
        }

        form button {
            padding: 14px;
            background: #6b4dff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        form button:hover {
            background: #5538d1;
        }
    </style>

</head>

<body>

    <!-- BOTTONE PER APRIRE IL MODAL -->
    <button class="open-modal">+ Aggiungi Disco</button>

    <!-- MODAL -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <h2>Aggiungi un nuovo disco</h2>

            <form action="aggiungi_disco.php" method="POST">
                <input type="text" name="titolo" placeholder="Titolo" required>
                <input type="text" name="artista" placeholder="Artista" required>
                <input type="text" name="anno" placeholder="Anno" required>
                <input type="text" name="url_cover" placeholder="URL Copertina" required>
                <button type="submit">Aggiungi</button>
            </form>
        </div>
    </div>

    <!-- GRID DISCHI -->
    <div class="container">
        <?php foreach ($dischi as $disco) { ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($disco['url_cover'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?php echo htmlspecialchars($disco['titolo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <h2><?php echo htmlspecialchars($disco['titolo'] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
                <p><?php echo htmlspecialchars($disco['artista'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <p><?php echo htmlspecialchars((string)($disco['anno'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php } ?>
    </div>

    <!-- SCRIPT MODAL -->
    <script>
        const modal = document.getElementById("modal");
        const openBtn = document.querySelector(".open-modal");
        const closeBtn = document.querySelector(".close");

        openBtn.onclick = () => modal.style.display = "flex";
        closeBtn.onclick = () => modal.style.display = "none";

        window.onclick = (e) => {
            if (e.target === modal) modal.style.display = "none";
        };
    </script>

</body>

</html>