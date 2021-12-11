<?php
require ('basecode.php');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
        <title>Seznam zaměstnanců</title>
    </head>
    <body class="container">
        <h1>Seznam zaměstnanců</h1>
      
<table class="table">
  <thead>
    <tr>
      <th scope="col">Jméno <a href="lide.php?poradi=nazev_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="lide.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
      <th scope="col">Místnost <a href="lide.php?poradi=mistnost_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="lide.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
      <th scope="col">Telefon <a href="lide.php?poradi=telefon_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="lide.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
      <th scope="col">Pozice <a href="lide.php?poradi=pozice_up"><i class="bi bi-arrow-up-circle-fill"></i></a><a href="lide.php"><i class="bi bi-arrow-down-circle-fill"></i></a></th>
    </tr>
  </thead>
  <tbody>
    <?php
    include "dbcon.php";

    $poradi = filter_input(INPUT_GET,"poradi");
    switch($poradi){
    case "nazev_up":
        $stmt = $pdo->query("SELECT employee_id,employee.name,surname,job,room.name as RoomName,phone FROM employee INNER JOIN room ON employee.room = room_id ORDER BY surname DESC");
        break;
    case "mistnost_up":
        $stmt = $pdo->query("SELECT employee_id,employee.name,surname,job,room.name as RoomName,phone FROM employee INNER JOIN room ON employee.room = room_id ORDER BY room.name DESC");
        break;
    case "telefon_up":
        $stmt = $pdo->query("SELECT employee_id,employee.name,surname,job,room.name as RoomName,phone FROM employee INNER JOIN room ON employee.room = room_id ORDER BY phone DESC");
        break;
    case "pozice_up":
        $stmt = $pdo->query("SELECT employee_id,employee.name,surname,job,room.name as RoomName,phone FROM employee INNER JOIN room ON employee.room = room_id ORDER BY job DESC");
        break;
    default:
        $stmt = $pdo->query("SELECT employee_id,employee.name,surname,job,room.name as RoomName,phone FROM employee INNER JOIN room ON employee.room = room_id");

    }
 

    $html ="";
    if ($stmt->rowCount() > 0) {
   
        while ($row = $stmt->fetch())  {
          $html .= "<tr><td><a href='clovek.php?clovekId=" .$row['employee_id'] ."'>" . $row['surname']. " " . $row['name'] ."</a></td><td>". $row['RoomName'] ."</td><td>" .$row['phone'] . "</td><td>" .$row['job']. "</td></tr>";
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