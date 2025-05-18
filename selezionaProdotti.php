<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
    <?php
        session_start();
        include "collegamentoDB.php";

        $n_tavolo = isset($_GET['n_tavolo']) ? intval($_GET['n_tavolo']) : 0;
        $tipologia = isset($_POST['tipologia']) ? $_POST['tipologia'] : (isset($_GET['tipologia']) ? $_GET['tipologia'] : '');

        // Inizializza l'array della comanda nella sessione se non esiste
        if (!isset($_SESSION['comanda_corrente'])) {
            $_SESSION['comanda_corrente'] = [];
        }

        // Gestisci l'aggiunta di un prodotto alla comanda
        if (isset($_POST['aggiungi_prodotto'])) {
            $id_piatto = $_POST['id_piatto'];
            $des_piatto = $_POST['des_piatto'];
            $prezzo = $_POST['prezzo'];
            $tipologia = $_POST['tipologia']; // Mantieni la tipologia selezionata
            
            // Se il prodotto esiste già nella comanda, incrementa la quantità
            if (isset($_SESSION['comanda_corrente'][$id_piatto])) {
                $_SESSION['comanda_corrente'][$id_piatto]['quantita']++;
            } else {
                // Altrimenti, aggiungi il prodotto alla comanda
                $_SESSION['comanda_corrente'][$id_piatto] = [
                    'des_piatto' => $des_piatto,
                    'prezzo' => $prezzo,
                    'quantita' => 1
                ];
            }
            
            // Reindirizza per evitare il ricaricamento del form
            header("Location: selezionaProdotti.php?n_tavolo=$n_tavolo&tipologia=$tipologia");
            exit();
        }

        echo "<div id='lista_prodotti'>";
        
        // Stato del carrello (conteggio prodotti)
        if (isset($_SESSION['comanda_corrente']) && !empty($_SESSION['comanda_corrente'])) {
            $totale_prodotti = 0;
            $totale_importo = 0;
            foreach ($_SESSION['comanda_corrente'] as $prodotto) {
                $totale_prodotti += $prodotto['quantita'];
                $totale_importo += $prodotto['prezzo'] * $prodotto['quantita'];
            }
            echo "<div style='background-color: white; padding: 10px; margin-bottom: 20px; border-radius: 10px;'>";
            echo "<h3>Carrello: <span style='color: green;'>$totale_prodotti prodotti</span> - Totale: <span style='color: green;'>€" . number_format($totale_importo, 2) . "</span></h3>";
            echo "<a href='visualizzaCarrello.php?n_tavolo=$n_tavolo'>";
            echo "<button type='button' style='width: 100%; height: 40px; background-color: #4CAF50;'>Visualizza Carrello</button>";
            echo "</a>";
            echo "</div>";
        }

        // Mostra i prodotti della tipologia selezionata
        if (!empty($tipologia)) {
            // Query per filtrare i prodotti in base alla tipologia
            $sql = "SELECT * FROM piatto WHERE id_tipologia = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $tipologia);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Recupera il nome della tipologia
            $sql_tipologia = "SELECT des_tipologia FROM tipologiapiatto WHERE id_tipologia = ?";
            $stmt_tipologia = $conn->prepare($sql_tipologia);
            $stmt_tipologia->bind_param("s", $tipologia);
            $stmt_tipologia->execute();
            $result_tipologia = $stmt_tipologia->get_result();
            $row_tipologia = $result_tipologia->fetch_assoc();
            $nome_tipologia = $row_tipologia ? $row_tipologia['des_tipologia'] : 'Prodotti';
          

            if ($result->num_rows > 0) {
                echo "<div style='display: flex; flex-wrap: wrap; justify-content: space-around;'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<form method='POST' style='margin: 10px;'>";
                    echo "<input type='hidden' name='id_piatto' value='{$row['id_piatto']}'>";
                    echo "<input type='hidden' name='des_piatto' value='{$row['des_piatto']}'>";
                    echo "<input type='hidden' name='prezzo' value='{$row['prezzo']}'>";
                    echo "<input type='hidden' name='tipologia' value='$tipologia'>";
                    echo "<button type='submit' name='aggiungi_prodotto' style='width: 200px; height: 100px; background-color: white; color: black; font-size: 16px; text-align: left; padding: 10px;'>";
                    echo "<strong>{$row['des_piatto']}</strong><br>";
                    echo "€{$row['prezzo']}";
                    echo "</button>";
                    echo "</form>";
                }
                echo "</div>";
            } else {
                echo "<p>Nessun prodotto disponibile per questa tipologia.</p>";
            }
        } else {
            echo "<div class='alert' style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 15px;'>
                    <h3>Nessuna categoria selezionata</h3>
                    <p>Torna alla pagina delle categorie per selezionarne una.</p>
                  </div>";
        }
        
        echo "<a href='selezionaTipologia.php?n_tavolo=$n_tavolo'>
                <button type='button' style='width: 100%; height: 60px; margin: 20px auto; display: block;'>Torna alle categorie</button>
              </a>";
        
        echo "</div>";

        // Chiusura connessione
        $conn->close();
    ?>
  </body>
</html>