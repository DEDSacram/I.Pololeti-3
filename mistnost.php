<?php
require ('basecode.php');
?>
 <?php
    include "dbcon.php";
    $mistnostId = filter_input(INPUT_GET,"mistnostId");
    if($mistnostId == null){
      header('HTTP/1.0 404 Not Found');
      echo "<h1>404 Not Found</h1>";
      echo "Stránka nenalezena.";
      exit();
    }
    $html ="";
    $stmt = $pdo->prepare("SELECT room.name,phone,room.no FROM room WHERE room_id = ?");
    $stmt->execute([$mistnostId]);

    $stmtplat = $pdo->prepare("SELECT ROUND(AVG(wage),2) as plat FROM employee WHERE employee.room = ?");
    $stmtplat->execute([$mistnostId]);

    $stmtosoba = $pdo->prepare("SELECT employee.wage,employee.surname,CONCAT(LEFT(employee.name, 1),'.') as nameshort,employee_id FROM employee WHERE employee.room = ?");
    $stmtosoba->execute([$mistnostId]);

    $stmtkeys = $pdo->prepare("SELECT employee_id,employee.surname,CONCAT(LEFT(employee.name, 1),'.') as nameshort FROM `key` as c INNER JOIN employee ON c.employee = employee_id WHERE c.room = ?");
    $stmtkeys->execute([$mistnostId]);
    if ($stmt->rowCount() > 0) {
   
        while ($row = $stmt->fetch())  {
          echo "<title>Místnost č. ".$row['no'] . "</title>";
        $html .= "<h1>" . "Místnost č. ".$row['no']."</h1>";
        $html .= "<h2>" . "Číslo: ".$row['no']."</h2>";
        $html .= "<h2>" . "Název: ".$row['name']."</h2>";
        $html .= "<h2>" . "Telefon: ".$row['phone']."</h2>";
        $html .= "<h2>Lidé:</h2>";
        while ($row2 = $stmtosoba->fetch()) {
            $html .= "<a href='clovek.php?clovekId=".$row2['employee_id']."'>". $row2['surname']. " ". $row2['nameshort']."</a><br>";
           }
        while($plat = $stmtplat->fetch()){
            $html .= "<h2> Průměrný plat: " . $plat['plat'] ."</h2>";
        }
     
        $html .= "<h2>Klíče:</h2>";
      
         while ($row3 = $stmtkeys->fetch()) {
          $html .= "<a href='clovek.php?clovekId=".$row3['employee_id']."'>". $row3['surname']. " ". $row3['nameshort']."</a><br>";
         }
        
       
        }
        $html .= "<br><a href=mistnosti.php>Zpět</a>";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo "<h1>400 Bad Request</h1>";
        echo "Stránka nenalezena.";
        exit();
      }
    ?>
    </head>
    <body class="container">
    
   

    <?php
        echo $html;
    ?>
   

</body>
</html>