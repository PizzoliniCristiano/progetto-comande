<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
    <?php
        session_start();
        include "collegamentoDB.php";

        $n_tavolo = isset($_GET['n_tavolo']) ? intval($_GET['n_tavolo']) : 0;
        
        // Inizializza l'array della comanda nella sessione se non esiste
        if (!isset($_SESSION['comanda_corrente'])) {
            $_SESSION['comanda_corrente'] = [];
        }

        // Gestisci la rimozione di un prodotto dalla comanda
        if (isset($_POST['rimuovi_prodotto'])) {
            $id_piatto = $_POST['id_piatto'];
            
            if (isset($_SESSION['comanda_corrente'][$id_piatto])) {
                // Decrementa la quantità
                $_SESSION['comanda_corrente'][$id_piatto]['quantita']--;
                
                // Se la quantità è 0, rimuovi il prodotto dalla comanda
                if ($_SESSION['comanda_corrente'][$id_piatto]['quantita'] <= 0) {
                    unset($_SESSION['comanda_corrente'][$id_piatto]);
                }
            }
            
            // Reindirizza per evitare il ricaricamento del form
            header("Location: visualizzaCarrello.php?n_tavolo=$n_tavolo");
            exit();
        }
        
        // Gestisci l'aggiunta di quantità
        if (isset($_POST['aggiungi_quantita'])) {
            $id_piatto = $_POST['id_piatto'];
            
            if (isset($_SESSION['comanda_corrente'][$id_piatto])) {
                // Incrementa la quantità
                $_SESSION['comanda_corrente'][$id_piatto]['quantita']++;
            }
            
            // Reindirizza per evitare il ricaricamento del form
            header("Location: visualizzaCarrello.php?n_tavolo=$n_tavolo");
            exit();
        }

        echo "<div id='lista_prodotti'>";
        
        echo "<h2 style='text-align: center;'>Riepilogo Ordine - Tavolo $n_tavolo</h2>";
        
        // Display del riepilogo della comanda corrente
        echo "<div style='background-color: white; padding: 10px; margin-bottom: 20px; border-radius: 10px; max-height: 500px; overflow-y: auto;'>";
        
        if (empty($_SESSION['comanda_corrente'])) {
            echo "<p style='text-align: center; font-size: 18px;'>Nessun prodotto selezionato</p>";
        } else {
            echo "<table style='width: 100%; margin-top: 5px;'>";
            echo "<tr><th>Prodotto</th><th>Prezzo</th><th>Qtà</th><th>Totale</th><th>Azioni</th></tr>";
            
            $totale_comanda = 0;
            
            foreach ($_SESSION['comanda_corrente'] as $id_piatto => $prodotto) {
                $totale_prodotto = $prodotto['prezzo'] * $prodotto['quantita'];
                $totale_comanda += $totale_prodotto;
                
                echo "<tr>";
                echo "<td>{$prodotto['des_piatto']}</td>";
                echo "<td>€{$prodotto['prezzo']}</td>";
                echo "<td>{$prodotto['quantita']}</td>";
                echo "<td>€" . number_format($totale_prodotto, 2) . "</td>";
                echo "<td>
                        <div style='display: flex; justify-content: space-between;'>
                            <form method='POST' style='display: inline;'>
                                <input type='hidden' name='id_piatto' value='$id_piatto'>
                                <button type='submit' name='rimuovi_prodotto' style='width: 30px; height: 30px; background-color: red;'>-</button>
                            </form>
                            <form method='POST' style='display: inline; margin-left: 5px;'>
                                <input type='hidden' name='id_piatto' value='$id_piatto'>
                                <button type='submit' name='aggiungi_quantita' style='width: 30px; height: 30px; background-color: green;'>+</button>
                            </form>
                        </div>
                      </td>";
                echo "</tr>";
            }
            
            echo "<tr><td colspan='3'><strong>Totale</strong></td><td colspan='2'><strong>€" . number_format($totale_comanda, 2) . "</strong></td></tr>";
            echo "</table>";
        }
        echo "</div>";
        
        echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>";
        echo "<a href='selezionaTipologia.php?n_tavolo=$n_tavolo'>
                <button type='button' style='width: 230px; height: 60px;'>Aggiungi altri prodotti</button>
              </a>";
        
        if (!empty($_SESSION['comanda_corrente'])) {
            echo "<a href='inserisciComanda.php?n_tavolo=$n_tavolo'>
                    <button type='button' style='width: 230px; height: 60px; background-color: green;'>Conferma ordine</button>
                  </a>";
        } else {
            echo "<button type='button' disabled style='width: 230px; height: 60px; background-color: gray;'>Conferma ordine</button>";
        }
        echo "</div>";
        
        
        echo "<a href='selezionaTipologia.php?n_tavolo=$n_tavolo' style='display: block; margin-top: 20px;'>
                <button type='button' style='width: 100%; height: 60px;'>INDIETRO</button>
              </a>";
        
        echo "</div>";

        // Chiusura connessione
        $conn->close();
    ?>
  </body>
</html>