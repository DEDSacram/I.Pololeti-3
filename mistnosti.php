<?php
require ('basecode.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
        <title>Seznam Místnosti</title>
    </head>
    <body class="container">
        <h1>Seznam Místnosti</h1>
      
<table class="table">
  <thead>
    <tr>
      <th scope="col">Název<a href="mistnosti.php?poradi=nazev_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="mistnosti.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
      <th scope="col">Číslo<a href="mistnosti.php?poradi=cislo_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="mistnosti.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
      <th scope="col">Telefon<a href="mistnosti.php?poradi=telefon_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="mistnosti.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>

    </tr>
  </thead>
  <tbody>
    <?php
    include "dbcon.php";
    

    $poradi = filter_input(INPUT_GET,"poradi");
    switch($poradi){
    case "nazev_up":
        $stmt = $pdo->query("SELECT room_id,room.name,phone,room.no FROM room ORDER BY room.name DESC");
        break;
    case "cislo_up":
        $stmt = $pdo->query("SELECT room_id,room.name,phone,room.no FROM room ORDER BY room.no DESC");
        break;
    case "telefon_up":
        $stmt = $pdo->query("SELECT room_id,room.name,phone,room.no FROM room ORDER BY room.phone DESC");
        break;
    default:
    $stmt = $pdo->query("SELECT room_id,room.name,phone,room.no FROM room");

    }

    $html ="";
   
    if ($stmt->rowCount() > 0) {
   
        while ($row = $stmt->fetch())  {
          $html .= "<tr><td><a href='mistnost.php?mistnostId=" .$row['room_id'] ."'>". $row['name'] ."</a></td><td>". $row['no'] ."</td><td>" . $row['phone'] . "</td></tr>";
        }
  
        echo $html;
      } else {
        echo "0 results";
      }
    ?>

    
   
</tbody>
</table>
</body>
</html>