<html>
<head>
    <link rel="stylesheet" href="stl.css">
</head>
<body>
    <?php
    include "collegamentoDB.php";

    // Query per ottenere lo stato di ciascun tavolo
    $sql = "SELECT n_tavolo, stato FROM comanda WHERE stato IN (0, 1)";
    $result = $conn->query($sql);

    // Array per mappare lo stato dei tavoli
    $tavoliStato = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tavoliStato[$row['n_tavolo']] = $row['stato'];
        }
    }

    echo "<div id='layoutTavoli'>";

    // Crea i pulsanti dei tavoli con colore basato sullo stato
    for ($i = 1; $i <= 5; $i++) {
        $statoTavolo = isset($tavoliStato[$i]) && $tavoliStato[$i] == 1 ? 'tavolo-occupato' : 'tavolo-libero';
        echo "<div id='tavolo'>"; 
        if ($statoTavolo[$i]==1)
        {
            echo "<a href='index.php'>
                <button type='button' class='$statoTavolo'>Tavolo $i</button>";
             echo "</a>"; 
        } 
        else{
            echo "<a href='aggiungiComanda.php'>
                <button type='button' class='$statoTavolo'>Tavolo $i</button>";
            echo "</a>"; 
        }
        
        echo "</div>";
    }
 
    echo "<a href='index.php'>
        <button type='button' style='width: 400px; height: 100px; margin-left:65px;'>INDIETRO</button>";
    echo "</a>"; 

    echo "</div>";

    $conn->close();
    ?>
</body>
</html>