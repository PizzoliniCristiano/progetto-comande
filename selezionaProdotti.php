<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
    <?php
        include "collegamentoDB.php";

        $n_tavolo = isset($_GET['n_tavolo']) ? intval($_GET['n_tavolo']) : 0;

        $tipologia = isset($_POST['tipologia']) ? $_POST['tipologia'] : '';

        // Controlla se il valore è stato passato correttamente

        echo "<div id= 'lista_prodotti'>";
        if (!empty($tipologia)) {
    
            // Query per filtrare i prodotti in base alla tipologia
            $sql = "SELECT * FROM piatto WHERE id_tipologia = '$tipologia'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                echo "<button type='submit' style='width: 200px; height: 100px; margin-left: 35px; background-color: white; color: black; margin-top: 20px; font-size: 10x;text-align:left'>{$row['des_piatto']} </button>";

                }
            } 
            echo "<a href='selezionaTipologia.php?n_tavolo=$n_tavolo'>
                    <button type='button' style='width: 400px; height: 100px; margin-left: 50px; margin-top: 10px;'>INDIETRO</button>
                 </a>";

            }
        echo "</div>";

        // Chiusura connessione
        $conn->close();
    ?>
  </body>
</html>

