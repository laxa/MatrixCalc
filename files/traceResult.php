<?php
if (!isset($_COOKIE['PHPSESSID'])) {
	session_start();
}
$matrixA = $_SESSION["matrixA"];
$result = $_SESSION["result"];
?>

tr(A) = 
<math xmlns="http://www.w3.org/1998/Math/MathML">
  <mrow>
     <mi></mi>
     <mo>tr</mo>
  
     <mfenced open="(" close=")">
  
        <mtable>
           <?php for ($i=0; $i < count($matrixA); $i++) { ?>
           <mtr>
              <?php for ($j=0; $j < count($matrixA[$i]); $j++) { ?>
                    <mtd><mi><?= $matrixA[$i][$j]; ?></mi></mtd>
              <?php } ?>
           </mtr>
           <?php } ?>
        </mtable>
        
     </mfenced>
  </mrow>
</math>
= <?= $result; ?>