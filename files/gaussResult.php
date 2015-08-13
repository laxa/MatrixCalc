<?php
if (!isset($_COOKIE['PHPSESSID'])) {
	session_start();
}
$matrixA = $_SESSION["matrixA"];
$matrixY = $_SESSION["matrixY"];
$result = $_SESSION["resultGauss"];
?>

<h2>Matrices saisi en cours</h2>

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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
et 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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

<br/><br/><br/><hr/><br/>
   <h2> Résultat intermediaire </h2>
   <table width="100%">
      <col width="40%"></col>
      <col width="40%"></col>
      <col></col>
<?php
for ($k=1; $k < count($matrixA); $k++) {
   $G = "";
   $A = "";
   $Y = "";
   if (isset($result["G".$k])) {
      $G = $result["G".$k]->GetMatrix();
   }
   if (isset($result["A".($k + 1)]) && isset($result["Y".($k + 1)])) {
      $A = $result["A".($k + 1)]->GetMatrix();
      $Y = $result["Y".($k + 1)]->GetMatrix();
   }
?>
   <tr style="height:25px">
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
         <br/><br/>
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
         <br/><br/>
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
         <br/><br/>
      </td> 
   </tr>
<?php
}
?>
</table>
<br/><hr/><br/>
<h2>Résultat final</h2>
L'ensemble des solutions est = 
<?php
   $val = "";
   for ($i=0; $i < count($result["solutions"]); $i++) {
      $val .= $result["solutions"][$i].", ";
   }
   $val = preg_replace("/, $/", "", $val);
   echo "{(".$val.")}";
?>
<!--
<math xmlns="http://www.w3.org/1998/Math/MathML">
   <mrow>
      <mi>Result</mi>
      <mo>=</mo>

      <mfenced open="(" close=")">

         <mtable>
            <?php// for ($i=0; $i < count($result); $i++) { ?>
            <mtr>
               <?php //for ($j=0; $j < count($result[$i]); $j++) { ?>
                     <mtd><mi><?//= $result[$i][$j]; ?></mi></mtd>
               <?php //} ?>
            </mtr>
            <?php //} ?>
         </mtable>
         
      </mfenced>
   </mrow>
</math>
-->