<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
    <?php
        include "collegamentoDB.php";

        $tipologia = isset($_POST['tipologia']) ? $_POST['tipologia'] : '';

        // Controlla se il valore è stato passato correttamente

        echo "<div id= 'lista_prodotti'>";
        if (!empty($tipologia)) {
    
            // Query per filtrare i prodotti in base alla tipologia
            $sql = "SELECT * FROM piatto WHERE id_tipologia = '$tipologia'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                echo "<button type='submit' style='width: 200px; height: 100px;'>{$row['des_piatto']}</button>";
                }
            } 
            echo "<a href='selezionaTavolo.php'>
                    <button type='button' style='width: 400px; height: 100px; '>INDIETRO</button>
                 </a>";

            }
        echo "</div>";

        // Chiusura connessione
        $conn->close();
    ?>
  </body>
</html>

