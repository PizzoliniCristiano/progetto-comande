<html>
<head>
    <link rel="stylesheet" href="stl.css">
</head>
<body>
<?php
session_start();
include "collegamentoDB.php";

$sql = "SELECT n_tavolo, stato FROM comanda WHERE stato IN (0, 1)";
$result = $conn->query($sql);

$tavoliStato = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tavoliStato[$row['n_tavolo']] = $row['stato'];
    }
}

echo "<div id='layoutTavoli'>";

// Crea i pulsanti dei tavoli con colore basato sullo stato
for ($i = 1; $i <= 6; $i++) {
    $statoTavolo = isset($tavoliStato[$i]) && $tavoliStato[$i] == 1 ? 'tavolo-occupato' : 'tavolo-libero';
    
    echo "<div id='tavolo'>"; 

    if ($statoTavolo == 'tavolo-occupato') {

        echo "<button type='button' class='$statoTavolo' disabled style= 'margin-left: -10px'>Tavolo $i</button>";
    } 
    else {

        echo "<a href='selezionaTipologia.php?n_tavolo=$i'>
                <button type='button' class='$statoTavolo' style= 'margin-left: -10px'>Tavolo $i</button>
              </a>";
    }
    
    echo "</div>";
}

echo "<a href='index.php'>
        <button type='button' style='width: 400px; height: 100px; margin-left:50px;'>INDIETRO</button>
      </a>"; 

echo "</div>";

$conn->close();
?>
</body>
</html>