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

    // Verifica se ci sono prodotti nella comanda
    if (!isset($_SESSION['comanda_corrente']) || empty($_SESSION['comanda_corrente'])) {
        echo "<div id='sceltaTipologia'>";
        echo "<p style='color: red; font-size: 20px; text-align: center;'>Non hai selezionato nessun prodotto!</p>";
        echo "<a href='selezionaTipologia.php?n_tavolo=$n_tavolo'>
                <button type='button' style='width: 400px; height: 60px; margin: 20px auto; display: block;'>Torna alla selezione prodotti</button>
              </a>";
        echo "<a href='homePage.php'>
                <button type='button' style='width: 400px; height: 60px; margin: 20px auto; display: block;'>Torna alla Home</button>
              </a>";
        echo "</div>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n_coperti = isset($_POST['n_coperti']) ? intval($_POST['n_coperti']) : 0;
        $stato = isset($_POST['stato']) ? intval($_POST['stato']) : 1;
        $data = date("Y-m-d");
        $ora = date("H:i:s");

        // Inizia la transazione
        $conn->begin_transaction();

        try {
            // Inserimento della comanda nel database
            $sql = "INSERT INTO comanda (n_coperti, n_tavolo, stato, ora, data, cameriere) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisss", $n_coperti, $n_tavolo, $stato, $ora, $data, $cameriere);
            $stmt->execute();
            
            // Ottieni l'ID della comanda appena inserita
            $id_comanda = $conn->insert_id;

            // Inserimento dei dettagli della comanda
            $sql_dettaglio = "INSERT INTO dettaglio_comanda (id_comanda, id_piatto, quantita) VALUES (?, ?, ?)";
            $stmt_dettaglio = $conn->prepare($sql_dettaglio);

            foreach ($_SESSION['comanda_corrente'] as $id_piatto => $prodotto) {
                $quantita = $prodotto['quantita'];
                $stmt_dettaglio->bind_param("iii", $id_comanda, $id_piatto, $quantita);
                $stmt_dettaglio->execute();
            }

            // Commit della transazione
            $conn->commit();
            
            // Pulisci la sessione della comanda corrente
            unset($_SESSION['comanda_corrente']);
            
            // Reindirizza alla homepage
            header("Location: homePage.php");
            exit();
        } catch (Exception $e) {
            // Rollback in caso di errore
            $conn->rollback();
            echo "<p style='color: red;'>Errore nell'inserimento: " . $e->getMessage() . "</p>";
        }

        $stmt->close();
        $stmt_dettaglio->close();
    }

    // Calcola il totale della comanda
    $totale_comanda = 0;
    foreach ($_SESSION['comanda_corrente'] as $prodotto) {
        $totale_comanda += $prodotto['prezzo'] * $prodotto['quantita'];
    }

    // Inizio del form HTML per inserire la comanda
    echo "<div id='sceltaTipologia'>";
    echo "<h2 style='text-align: center;'>Riepilogo dell'ordine - Tavolo $n_tavolo</h2>";
    
    // Mostra il riepilogo dei prodotti selezionati
    echo "<div style='background-color: white; padding: 10px; margin: 20px 0; border-radius: 10px; max-height: 300px; overflow-y: auto;'>";
    echo "<table style='width: 100%; margin-top: 5px;'>";
    echo "<tr><th>Prodotto</th><th>Prezzo</th><th>Qtà</th><th>Totale</th></tr>";
    
    foreach ($_SESSION['comanda_corrente'] as $id_piatto => $prodotto) {
        $totale_prodotto = $prodotto['prezzo'] * $prodotto['quantita'];
        
        echo "<tr>";
        echo "<td>{$prodotto['des_piatto']}</td>";
        echo "<td>€{$prodotto['prezzo']}</td>";
        echo "<td>{$prodotto['quantita']}</td>";
        echo "<td>€" . number_format($totale_prodotto, 2) . "</td>";
        echo "</tr>";
    }
    
    echo "<tr><td colspan='3'><strong>Totale Comanda</strong></td><td><strong>€" . number_format($totale_comanda, 2) . "</strong></td></tr>";
    echo "</table>";
    echo "</div>";

    echo "<form method='POST'>";
    
    echo "<div id='resoconto'>";
    echo "<label for='n_coperti'>Inserisci Numero Coperti:</label>";
    echo "<input type='number' id='n_coperti' name='n_coperti' required><br>";
    echo "</div>";

    echo "<div id='resoconto'>";
    echo "<label for='n_tavolo'>Numero Tavolo:</label>";
    echo "<input type='number' id='n_tavolo' name='n_tavolo' value='" . $n_tavolo . "' readonly><br>";
    echo "</div>";

    echo "<div id='resoconto' style='margin-bottom: 20px;'>";
    echo "<label for='cameriere'>Cameriere:</label>";
    echo "<input type='text' id='cameriere' name='cameriere' value='" . $cameriere . "' readonly><br>";
    echo "</div>";

    echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>";
    echo "<a href='visualizzaCarrello.php?n_tavolo=$n_tavolo'>
            <button type='button' style='width: 230px; height: 60px;'>Modifica Prodotti</button>
          </a>";
    echo "<button type='submit' style='width: 230px; height: 60px; background-color: green;'>Conferma Comanda</button>";
    echo "</div>";
    
    echo "</form>";

    echo "<a href='selezionaTipologia.php' style='display: block; margin-top: 20px;'>";
    echo "<button type='button' style='width: 100%; height: 60px; background-color: #ff9900;'>INDIETRO</button>";
    echo "</a>";

    echo "</div>"; 
    
    $conn->close();
    ?>
</body>
</html>