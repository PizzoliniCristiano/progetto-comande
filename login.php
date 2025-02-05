<html>
  <head>
    <link rel="stylesheet" href="stl.css">
  </head>
  
  <body>
    <?php
      include "collegamentoDB.php";

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $username = $_POST['username'];
          $password = $_POST['password'];

          // Controllo credenziali
          $sql = "SELECT * FROM cameriere WHERE username = ? AND password = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ss", $username, $password);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
              header("Location: index.php");
              exit();
          } 
          else {

              $error = "Username o password errati";
          }
          $stmt->close();
      }
      echo"<div id='login'>";

      echo "<div id='nomeLocale'> <h1> PALLE SUL TAVOLO </h1> </div> ";
      
      echo"<form method='POST'>";
      echo"<div id='nomeUtente'> Nome utente: <input type='text' name='username' required style='margin-top: 120px;'> </div> <br>";
      echo"<div id='password'> Password: <input type='password' name='password' required> </div> <br>";
      echo"<button type='submit' style='width: 250px; height: 50px; margin-left: 120px;'>ACCEDI</button>";
      echo"</form>";

        if (!empty($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        $conn->close();
      ?>
    </div>
  </body>
</html>
