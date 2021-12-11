<?php
require ('basecode.php');
?>
  <?php
    include "dbcon.php";
    $clovekId = filter_input(INPUT_GET,"clovekId");
    if($clovekId == null){
      header('HTTP/1.0 404 Not Found');
      echo "<h1>404 Not Found</h1>";
      echo "Stránka nenalezena.";
      exit();
    }
    $html ="";
    $stmt = $pdo->prepare("SELECT room_id,employee.name,surname,CONCAT(LEFT(surname, 1),'.') as surnameshort,job,wage,room.name as RoomName FROM employee INNER JOIN room ON employee.room = room_id WHERE employee_id = ?");
    $stmt->execute([$clovekId]);
    $stmtkeys = $pdo->prepare("SELECT room_id,room.name as RoomName FROM `key` as c INNER JOIN room ON c.room = room_id WHERE employee = ?");
    $stmtkeys->execute([$clovekId]);
    if ($stmt->rowCount() > 0) {
   
        while ($row = $stmt->fetch())  {
        echo "<title>Karta osoby: " . $row['name'] . " ". $row['surnameshort'] . "</title>";
        $html .= "<h1>" . "Karta osoby: " . $row['name'] . " ". $row['surnameshort'] . "</h1>";

        $html .= "<h2>" . "Jméno: " . $row['name'] ."</h2>";
        $html .= "<h2>" . "Příjmení: " . $row['surname'] . "</h2>";
        $html .= "<h2>" . "Pozice: " . $row['job'] . "</h2>";
        $html .= "<h2>" . "Mzda: " . $row['wage'] . "</h2>";
        $html .= "<h2>" . "Místnost: ". "<a href='mistnost.php?mistnostId=".$row['room_id']."'>". $row['RoomName'] . "</a></h2>";
        $html .= "<h2>Klíče:</h2>" ;

        while ($row2 = $stmtkeys->fetch()) {

         $html .= "<a href='mistnost.php?mistnostId=".$row2['room_id']."'>". $row2['RoomName']."</a><br>";
      


        }
        
        }
        $html .= "<br><a href=lide.php>Zpět</a>";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo "<h1>400 Bad Request</h1>";
        echo "Stránka nenalezena.";
      }
    ?>

    </head>
    <body class="container">
    
    <?php
        echo $html;
    ?>

    
   

</body>
</html>