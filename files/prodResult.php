<?php
if (!isset($_COOKIE['PHPSESSID'])) {
	session_start();
}
$matrixA = $_SESSION["matrixA"];
$matrixB = $_SESSION["matrixB"];
$result = $_SESSION["result"];
$resultBA = $_SESSION["resultBA"];
?>

A x B =

                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi></mi>
                                          <mo></mo>
                                       
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
                                    &nbsp;&nbsp;&nbsp;X
                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi></mi>
                                          <mo></mo>
                                       
                                          <mfenced open="(" close=")">
                                       
                                             <mtable>
                                                <?php for ($i=0; $i < count($matrixB); $i++) { ?>
                                                <mtr>
                                                   <?php for ($j=0; $j < count($matrixB[$i]); $j++) { ?>
                                                         <mtd><mi><?= $matrixB[$i][$j]; ?></mi></mtd>
                                                   <?php } ?>
                                                </mtr>
                                                <?php } ?>
                                             </mtable>
                                             
                                          </mfenced>
                                       </mrow>
                                    </math>
                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi>=</mi>
                                          <mo></mo>
                                       
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
                                    
                                    <br /><br /> <br />

                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi>B x A</mi>
                                          <mo>=</mo>
                                       
                                          <mfenced open="(" close=")">
                                       
                                             <mtable>
                                                <?php for ($i=0; $i < count($matrixB); $i++) { ?>
                                                <mtr>
                                                   <?php for ($j=0; $j < count($matrixB[$i]); $j++) { ?>
                                                         <mtd><mi><?= $matrixB[$i][$j]; ?></mi></mtd>
                                                   <?php } ?>
                                                </mtr>
                                                <?php } ?>
                                             </mtable>
                                             
                                          </mfenced>
                                       </mrow>
                                    </math>
                                    &nbsp;&nbsp;&nbsp;X
                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi></mi>
                                          <mo></mo>
                                       
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
                                    
                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                       <mrow>
                                          <mi>=</mi>
                                          <mo></mo>
                                       
                                          <mfenced open="(" close=")">
                                       
                                             <mtable>
                                                <?php
                                                   for ($i=0; $i < count($resultBA); $i++) {
                                                ?>
                                                <mtr>
                                                   <?php
                                                      for ($j=0; $j < count($resultBA[$i]); $j++) {
                                                   ?>
                                                         <mtd><mi><?= $resultBA[$i][$j]; ?></mi></mtd>
                                                   <?php
                                                      }
                                                   ?>
                                                </mtr>
                                                <?php
                                                   }
                                                ?>
                                             </mtable>
                                             
                                          </mfenced>
                                       </mrow>
                                    </math>