<?php
if (!isset($_COOKIE['PHPSESSID'])) {
	session_start();
}
$matrixA = $_SESSION["matrixA"];
$matrixY = $_SESSION["matrixY"];
$G = $_SESSION["matrixIntG"];
$A = $_SESSION["matrixIntA"];
$Y = $_SESSION["matrixIntY"];
$result = $_SESSION["result"];
?>

<h2>Operation in Progress</h2>

<math xmlns="http://www.w3.org/1998/Math/MathML">
      <mrow>
         <mi>A</mi>
         <mo>=</mo>
      
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

and 

<math xmlns="http://www.w3.org/1998/Math/MathML">
      <mrow>
         <mi>Y</mi>
         <mo>=</mo>
      
         <mfenced open="(" close=")">
      
            <mtable>
               <?php for ($i=0; $i < count($matrixY); $i++) { ?>
               <mtr>
                  <?php for ($j=0; $j < count($matrixY[$i]); $j++) { ?>
                        <mtd><mi><?= $matrixY[$i][$j]; ?></mi></mtd>
                  <?php } ?>
               </mtr>
               <?php } ?>
            </mtable>
            
         </mfenced>
      </mrow>
   </math>


   <h2> Resultat intermediaire </h2>
   <table width="100%">
      <col width="30%"></col>
      <col width="30%"></col>
      <col></col>
<?php
for ($k=1; $k < count($matrixA); $k++) {
?>
   <tr>
      <td>
         G<sub>(<?=$k;?>)</sub>
         <math xmlns="http://www.w3.org/1998/Math/MathML">
            <mrow>
               <mi></mi>
               <mo>=</mo>
            
               <mfenced open="(" close=")">
            
                  <mtable>
                     <?php for ($i=0; $i < count($G); $i++) { ?>
                     <mtr>
                        <?php for ($j=0; $j < count($G[$i]); $j++) { ?>
                              <mtd><mi><?= $G[$i][$j]; ?></mi></mtd>
                        <?php } ?>
                     </mtr>
                     <?php } ?>
                  </mtable>
                  
               </mfenced>
            </mrow>
         </math>
      </td>
      <td>
         A<sub>(<?=($k + 1);?>)</sub>
         <math xmlns="http://www.w3.org/1998/Math/MathML">
            <mrow>
               <mi></mi>
               <mo>=</mo>
            
               <mfenced open="(" close=")">
            
                  <mtable>
                     <?php for ($i=0; $i < count($A); $i++) { ?>
                     <mtr>
                        <?php for ($j=0; $j < count($A[$i]); $j++) { ?>
                              <mtd><mi><?= $A[$i][$j]; ?></mi></mtd>
                        <?php } ?>
                     </mtr>
                     <?php } ?>
                  </mtable>
                  
               </mfenced>
            </mrow>
         </math>
      </td> 
      <td>
         Y<sub>(<?=($k + 1);?>)</sub>
         <math xmlns="http://www.w3.org/1998/Math/MathML">
            <mrow>
               <mi></mi>
               <mo>=</mo>
            
               <mfenced open="(" close=")">
            
                  <mtable>
                     <?php for ($i=0; $i < count($Y); $i++) { ?>
                     <mtr>
                        <?php for ($j=0; $j < count($Y[$i]); $j++) { ?>
                              <mtd><mi><?= $Y[$i][$j]; ?></mi></mtd>
                        <?php } ?>
                     </mtr>
                     <?php } ?>
                  </mtable>
                  
               </mfenced>
            </mrow>
         </math>
      </td> 
   </tr>
<?php
}
?>
</table>
<br/>
<h2>Final Result</h2>

<math xmlns="http://www.w3.org/1998/Math/MathML">
   <mrow>
      <mi>Result</mi>
      <mo>=</mo>

      <mfenced open="(" close=")">

         <mtable>
            <?php for ($i=0; $i < count($result); $i++) { ?>
            <mtr>
               <?php for ($j=0; $j < count($result[$i]); $j++) { ?>
                     <mtd><mi><?= $result[$i][$j]; ?></mi></mtd>
               <?php } ?>
            </mtr>
            <?php } ?>
         </mtable>
         
      </mfenced>
   </mrow>
</math>
