
<!DOCTYPE HTML>
<html lang = "en">
  <head>
    <title>basicTable.html</title>
    <meta charset = "UTF-8" />
    <style type = "text/css">
    table, td, th {
      border: 1px solid black;
    } 
    </style>
  </head>
  
  <body>
    <?php include 'header.php'; ?>
    <h1>A Basic Table</h1>
    
    <table>
    <?php
     
    $n=0;
    for($n=0;$n<=10;$n++){
      $m=0;
      print "<tr id= \"".$n."\"> ";
        print  "<td><div id=\"".$n."_".$m.  "\" onblur=\"updateRow(".$n.");\" contenteditable>"."col1"."</div></td>
                <td><div id=\"".$n."_".($m+1)."\" onblur=\"updateRow(".$n.");\" contenteditable>"."col2"."</div></td>
                <td><div id=\"".$n."_".($m+2)."\" onblur=\"updateRow(".$n.");\" contenteditable>".$n."</div></td>";
        print " </tr>";
    }
  ?>
    </table>
    <script type="text/javascript">
    function updateRow(n) {

            console.log(document.getElementById(n+"_0").innerHTML);
            console.log(document.getElementById(n+"_1").innerHTML);
            console.log(document.getElementById(n+"_2").innerHTML);
}

    </script>
  </body>

</html>