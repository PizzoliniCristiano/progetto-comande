<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  <body>
    <?php
    include "collegamentoDB.php";
    session_start();

    if (!isset($_GET['id_comanda'])) {
        echo "ID comanda mancante.";
        exit;
    }

    $id_comanda = intval($_GET['id_comanda']);

    // Recupera lo stato attuale della comanda e il numero tavolo
    $checkSql = "SELECT stato, n_tavolo FROM comanda WHERE id_comanda = $id_comanda";
    $checkResult = $conn->query($checkSql);

    if (!$checkResult || $checkResult->num_rows === 0) {
        echo "Comanda non trovata.";
        exit;
    }

    $rowStato = $checkResult->fetch_assoc();
    $stato_comanda = $rowStato['stato'];
    $n_tavolo = $rowStato['n_tavolo'];

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

    // Gestione della modifica della comanda
    if (isset($_POST['modifica_comanda']) && $stato_comanda == 1) {
        // Ottieni i piatti della comanda
        $sqlPiatti = "SELECT piatto.id_piatto, piatto.des_piatto, piatto.prezzo, dettaglio_comanda.quantita 
                    FROM dettaglio_comanda 
                    JOIN piatto ON dettaglio_comanda.id_piatto = piatto.id_piatto 
                    WHERE dettaglio_comanda.id_comanda = $id_comanda";
        $resultPiatti = $conn->query($sqlPiatti);
        
        // Inizializza l'array della comanda corrente nella sessione
        $_SESSION['comanda_corrente'] = [];
        
        // Popola l'array con i piatti della comanda
        while ($row = $resultPiatti->fetch_assoc()) {
            $_SESSION['comanda_corrente'][$row['id_piatto']] = [
                'des_piatto' => $row['des_piatto'],
                'prezzo' => $row['prezzo'],
                'quantita' => $row['quantita']
            ];
        }
        
        // Reindirizza alla pagina del carrello
        header("Location: visualizzaCarrello.php?n_tavolo=$n_tavolo");
        exit();
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
        // Div con barra di scorrimento per i prodotti
        echo "<div style='background-color: white; padding: 10px; margin-bottom: 20px; border-radius: 10px; max-height: 400px; overflow-y: auto;'>";
        echo "<table border='1' style='width: 100%;'>";
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
        echo "</div>";
    } else {
        echo "<p>Nessun piatto associato a questa comanda.</p>";
    }

    // Mostra i bottoni solo se la comanda è ancora aperta
    echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>";
    
    if ($stato_comanda == 1) {
        // Pulsante per modificare la comanda (solo se attiva)
        echo "<form method='POST' style='display: inline;'>
                <button type='submit' name='modifica_comanda' style='width: 230px; height: 60px; background-color: #4CAF50;'>Modifica Comanda</button>
              </form>";
              
        // Pulsante per chiudere la comanda
        echo "<form method='POST' style='display: inline;'>
                <button type='submit' name='chiudi_comanda' style='width: 230px; height: 60px; background-color: orange;'>Chiudi Comanda (Paga)</button>
              </form>";
    } else {
        echo "<p style='color: green; font-weight: bold; margin: auto;'>Comanda già chiusa.</p>";
    }
    
    echo "</div>";

    echo "<a href='homePage.php' style='display: block; margin-top: 20px;'>
            <button style='width: 100%; height: 60px;'>Torna alle comande</button>
          </a>";
    echo "</div>";

    $conn->close();
    ?>
  </body>
</html>