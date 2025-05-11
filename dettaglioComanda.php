<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  <body>
    <?php
    include "collegamentoDB.php";

    if (!isset($_GET['id_comanda'])) {
        echo "ID comanda mancante.";
        exit;
    }

    $id_comanda = intval($_GET['id_comanda']);

    // Recupera lo stato attuale della comanda
    $checkSql = "SELECT stato FROM comanda WHERE id_comanda = $id_comanda";
    $checkResult = $conn->query($checkSql);

    if (!$checkResult || $checkResult->num_rows === 0) {
        echo "Comanda non trovata.";
        exit;
    }

    $rowStato = $checkResult->fetch_assoc();
    $stato_comanda = $rowStato['stato'];

    // Gestione del cambio stato 
    if (isset($_POST['chiudi_comanda']) && $stato_comanda == 1) {
        $updateSql = "UPDATE comanda SET stato = 0 WHERE id_comanda = $id_comanda";
        if ($conn->query($updateSql) === TRUE) {
            header("Location: homePage.php");
            exit();
        } else {
            echo "<p style='color: red;'>Errore durante la chiusura della comanda.</p>";
        }
    }

    // Query per dettagli piatti
    $sql = "SELECT piatto.des_piatto, piatto.prezzo, dettaglio_comanda.quantita
            FROM dettaglio_comanda
            JOIN piatto ON dettaglio_comanda.id_piatto = piatto.id_piatto
            WHERE dettaglio_comanda.id_comanda = $id_comanda";

    $result = $conn->query($sql);

    echo "<div id='dettaglioComande'>";
    echo "<h2>Dettagli della comanda N.$id_comanda</h2>";

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nome Piatto</th><th>Prezzo</th><th>Quantità</th><th>Totale</th></tr>";

        $totale_comanda = 0;

        while ($row = $result->fetch_assoc()) {
            $totale = $row['prezzo'] * $row['quantita'];
            $totale_comanda += $totale;

            echo "<tr>
                    <td>{$row['des_piatto']}</td>
                    <td>€{$row['prezzo']}</td>
                    <td>{$row['quantita']}</td>
                    <td>€" . number_format($totale, 2) . "</td>
                  </tr>";
        }

        echo "<tr><td colspan='3'><strong>Totale Comanda</strong></td><td><strong>€" . number_format($totale_comanda, 2) . "</strong></td></tr>";
        echo "</table>";
    } else {
        echo "Nessun piatto associato a questa comanda.";
    }

    // Mostra il bottone solo se la comanda è ancora aperta
    if ($stato_comanda == 1) {
        echo "<form method='POST' style='margin-top: 20px;'>
                <button type='submit' name='chiudi_comanda' style='background-color: orange;'>Chiudi Comanda (Paga)</button>
              </form>";
    } else {
        echo "<p style='color: green; font-weight: bold;'>Comanda già chiusa.</p>";
    }

    echo "<br><a href='homePage.php'><button style='margin-top: -20px;'>Torna alle comande</button></a>";
    echo "</div>";

    $conn->close();
    ?>
  </body>
</html>
