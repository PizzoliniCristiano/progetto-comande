<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
   
  <?php
include "collegamentoDB.php";

// Costruisci la query per ottenere le tipologie
$sql = "SELECT * FROM tipologiapiatto WHERE true";
$result = $conn->query($sql);

echo "<div id='sceltaTipologia'>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div id='tipologia'>";
        echo "<form action='selezionaProdotti.php' method='POST'>
                <input type='hidden' name='tipologia' value='{$row['id_tipologia']}'>
                <button type='submit' style='background-color:white; color:black'>{$row['des_tipologia']}</button>
              </form>";
        echo "</div>";
    }
}
echo "<a href='selezionaTavolo.php'>
        <button type='button' style='width: 400px; height: 100px; margin-left:65px;'>INDIETRO</button>
      </a>";
echo "</div>";



// Chiusura connessione
$conn->close();
?>

   
  </body>
</html>