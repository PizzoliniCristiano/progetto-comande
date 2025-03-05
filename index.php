<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
   
    <?php
      include "collegamentoDB.php";


      $filtraComande = isset($_POST['filtraComande']) ? $_POST['filtraComande'] : 1;


      // Costruisci la query in base al valore del filtro


      $sql = "SELECT * FROM comanda WHERE true";


        if ($filtraComande == 1 || $filtraComande == 0) {
          // Filtra per Attive / Chiuse
          $sql .= " AND stato = " . intval($filtraComande);
     
          }

      $result = $conn->query($sql);
   
    echo "<div id= 'listaComande'>";


    //Menù a tendina per filtrare le comande in base allo stato
    echo "<form method='POST'>";
    echo "<select name='filtraComande' id='filtraComande'>
          <option value='1'>COMANDE ATTIVE</option>
          <option value='0'>COMANDE PAGATE</option>
          <option value='3'>COMANDE ATTIVE/PAGATE</option>
          </select>";
    echo "<button type='submit' style='margin-top: 50px; width: 250px; height: 50px; '>Filtra</button>";
    echo "</form>";


    //Bottone per aggiungere una nuova comanda alla lista
    echo "<a href='selezionaTavolo.php'>
            <button type='button' style='width: 500px; height: 50px;'>NUOVA COMANDA</button>";
    echo "</a>";
   


    //Tabella per visualizzare le comande
    echo "<table>";
    echo "<tr><th>id</th><th>n_coperti</th><th>n_tavolo</th><th>data</th><th>ora</th><th>cameriere</th><th>stato</th></tr>";


    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_comanda']}</td>";
        echo "<td>{$row['n_coperti']}</td>";
        echo "<td>{$row['n_tavolo']}</td>";
        echo "<td>{$row['data']}</td>";
        echo "<td>{$row['ora']}</td>";
        echo "<td>{$row['cameriere']}</td>";
        echo "<td>{$row['stato']}</td>";
        echo "</tr>";
    }
    } else {
      echo "0 results";
    }


    echo "</table>";

    echo "<a href='login.php'>
            <button type='button' style='width: 500px; height: 50px; background-color: red; margin-top: 10px'>ESCI</button>";
    echo "</a>";

    echo "</div>";


    //chiusura connessione con il d.b.
    $conn->close();
    ?>
   
  </body>
</html>