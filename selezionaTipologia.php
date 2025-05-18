<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
   
  <?php
    session_start();
    include "collegamentoDB.php";

    $n_tavolo = isset($_GET['n_tavolo']) ? intval($_GET['n_tavolo']) : 0;

    // Costruisci la query per ottenere le tipologie
    $sql = "SELECT * FROM tipologiapiatto WHERE true";
    $result = $conn->query($sql);
    echo "<div id='sceltaTipologia'>";

    // Mostra riepilogo dei prodotti selezionati
    if (isset($_SESSION['comanda_corrente']) && !empty($_SESSION['comanda_corrente'])) {
        $totale_comanda = 0;
        $totale_prodotti = 0;
    
        echo "<div style='background-color: white; padding: 10px; margin-bottom: 20px; border-radius: 10px; max-height: 150px; overflow-y: auto;'>";
        echo "<h3>Prodotti nel carrello:</h3>";
    
        foreach ($_SESSION['comanda_corrente'] as $prodotto) {
            $totale_prodotti += $prodotto['quantita'];
            $totale_comanda += $prodotto['prezzo'] * $prodotto['quantita'];
        }
    
        echo "<p><strong>Totale prodotti:</strong> $totale_prodotti</p>";
        echo "<p><strong>Totale comanda:</strong> €" . number_format($totale_comanda, 2) . "</p>";
      echo "</div>";
    }
    
    echo "<h2>Seleziona una categoria di piatti:</h2>";

    if ($result->num_rows > 0) {
        echo "<div style='display: flex; flex-wrap: wrap; justify-content: space-around;'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div id='tipologia' style='width: auto; height: auto; margin: 10px;'>";
            echo "<form action='selezionaProdotti.php?n_tavolo=$n_tavolo' method='POST'>
                    <input type='hidden' name='tipologia' value='{$row['id_tipologia']}'>
                    <button type='submit' style='background-color: white; height: 60px; color: black; width: 200px;'>{$row['des_tipologia']}</button>
                  </form>";
            echo "</div>";
        }
        echo "</div>";
    }

    echo "<div style='display: flex; justify-content: space-between; margin-top: 20px;'>";
    if (isset($_SESSION['comanda_corrente']) && !empty($_SESSION['comanda_corrente'])) {
        echo "<a href='inserisciComanda.php?n_tavolo=$n_tavolo'>
                <button type='button' style='width: 230px; height: 60px; background-color: green;'>PROCEDI ALL'ORDINE</button>
              </a>";
    } else {
        echo "<button type='button' style='width: 230px; height: 60px; background-color: gray; cursor: not-allowed;' disabled>PROCEDI ALL'ORDINE</button>";
    }

    echo "<a href='selezionaTavolo.php'>
          <button type='button' style='width: 230px; height: 60px;'>INDIETRO</button>
          </a>";
    echo "</div>";


    echo "</div>";

    // Chiusura connessione
    $conn->close();
  ?>

   
  </body>
</html>