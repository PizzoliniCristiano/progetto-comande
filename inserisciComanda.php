<html>
<head>
    <link rel="stylesheet" href="stl.css">
</head>

<body>
    <?php
    session_start();
    include "collegamentoDB.php";

    $n_tavolo = isset($_GET['n_tavolo']) ? intval($_GET['n_tavolo']) : 0;
    $cameriere = isset($_SESSION['cameriere']) ? $_SESSION['cameriere'] : '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n_coperti = isset($_POST['n_coperti']) ? intval($_POST['n_coperti']) : 0;
        $stato = isset($_POST['stato']) ? intval($_POST['stato']) : 1;
        $data = date("Y-m-d");
        $ora = date("H:i:s");

        // Inserimento della comanda nel database
        $sql = "INSERT INTO comanda (n_coperti, n_tavolo, stato, ora, data, cameriere) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $n_coperti, $n_tavolo, $stato, $ora, $data, $cameriere);

        if ($stmt->execute()) {
            echo "<p>Comanda inserita con successo!</p>";
            header("Location: index.php");
            exit();
        } 
        else {
            echo "<p>Errore nell'inserimento: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }

    // Inizio del form HTML per inserire la comanda
    echo "<div id='sceltaTipologia'>";
    echo "<form method='POST'>";

    echo "<div id='resoconto' style= 'margin-top: 100px'>";
    echo "<label for='n_coperti' >Inserisci Numero Coperti:</label>";
    echo "<input type='number' id='n_coperti' name='n_coperti' required><br>";
    echo "</div>";

    echo "<div id='resoconto'>";
    echo "<label for='n_tavolo' >Numero Tavolo:</label>";
    echo "<input type='number' id='n_tavolo' name='n_tavolo' value='" . $n_tavolo . "' readonly><br>";
    echo "</div>";

    echo "<div id='resoconto' style= 'margin-bottom: 350px'>";
    echo "<label for='cameriere'>Cameriere:</label>";
    echo "<input type='text' id='cameriere' name='cameriere' value='" . $cameriere . "' readonly><br>";
    echo "</div>";

    echo "<button type='submit' style= 'background-color: green;'>Inserisci Comanda</button>";
    echo "</form>";

    echo "<a href='index.php'>";
    echo "<button type='button'>INDIETRO</button>";
    echo "</a>";

    echo "</div>"; 
    ?>
</body>
</html>
