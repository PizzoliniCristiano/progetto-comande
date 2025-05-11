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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div id='tipologia'>";
        echo "<form action='selezionaProdotti.php?n_tavolo=$n_tavolo' method='POST'>
                <input type='hidden' name='tipologia' value='{$row['id_tipologia']}'>
                <button type='submit' style='background-color:white; height:60px; color:black; margin-left:-12px; '>{$row['des_tipologia']}</button>
              </form>";
        echo "</div>";
    }
}

echo "<a href='inserisciComanda.php?n_tavolo=$n_tavolo'>
        <button type='button' style='width: 400px; height: 100px; margin-left:55px; margin-bottom: 40px; background-color: green;'>VISUALIZZA RESOCONTO</button>
      </a>";

echo "<a href='selezionaTavolo.php'>
        <button type='button' style='width: 400px; height: 100px; margin-left:55px;'>INDIETRO</button>
      </a>";
echo "</div>";



// Chiusura connessione
$conn->close();
?>

   
  </body>
</html>