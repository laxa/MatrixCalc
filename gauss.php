<?php
   session_start();
?>
<!doctype html>
<html>

   <head>
      <meta charset="UTF-8">
      <title>2 - Math Project (GAUSS)</title>
      <link rel="stylesheet" type="text/css" href="css/default.css">
   </head>
<?php
   $error = "";
   ## By default Step 1 is on to enable use choose the operation to apply
   $step = 1;
   if (isset($_POST) && array_key_exists("action", $_POST)) {

      if ($_POST["action"] == "save_step4") {
         ## Return Back to step 1
         unset($_POST);
         $operator = "";
         $step = 1;
      }
      if ($_POST["action"] == "save_step1") {
         ## Can go to step 2 where user should give the size of the matrice
         $step = 2;
      }
      if ($_POST["action"] == "save_step3") {
         ## Step For matrice operation
         require_once(__DIR__.'/lib/Matrix.php');


         $step = 3;
         $j = 0;
         $result = array();
         $matrixA = array();
         $matrixY = array();
         $G = array();
         $A = array();
         $Y = array();

         for ($i = 0; isset($_POST["matrixA_".$i."_".$j]); $i++) {
            for ($j = 0; isset($_POST["matrixA_".$i."_".$j]); $j++) {
               $matrixA[$i][$j] = $_POST["matrixA_".$i."_".$j];
            }
            $j = 0;
         }

         $j = 0;
         for ($i = 0; isset($_POST["matrixY_".$i."_".$j]); $i++) {
            for ($j = 0; isset($_POST["matrixY_".$i."_".$j]); $j++) {
               $matrixY[$i][$j] = $_POST["matrixY_".$i."_".$j];
            }
            $j = 0;
         }
            ## Class code to calculate the gauss value of the matrices

            # matrice G = Array(G1, G2, G3); 
            # A = Array(A2, A3, A4); 
            # Y = Array(Y2, Y3, Y4);

      }
   }

?>
   <body>

      <div id="bg_div">
         <?php if ($step == 3) { ?>
            <div id="step4">
               <form name='FORM_STEP3' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 4 : Resultat de l'operation demandé &nbsp;--&nbsp;</legend>
                        <table width="100%">
                           <tr>
                        <?php
                                 
                                 $_SESSION["matrixIntG"] = $G;
                                 $_SESSION["matrixIntA"] = $A;
                                 $_SESSION["matrixIntY"] = $Y;
                                 $_SESSION["matrixA"] = $matrixA;
                                 $_SESSION["matrixY"] = $matrixY;
                                 $_SESSION["result"] = $result;
                                 
                        ?>
                        <!-- The result for the gauss operation -->
                           <td>
                            <?php require_once (__DIR__.'/files/gaussResult.php'); ?>
                           </td>
                     </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr style="text-align:right;">
                        <td><input type="button" style="margin-right:30px;" name="step3" id="validate_step3" value="Terminer" onClick="check_step4(document.FORM_STEP3)"/></td>
                     </tr>
                  </table>
               </form>
            </div>
         <?php }
         else if ($step == 2) {
            ## Etape pour le choix des dimension des matrices
         ?>
            <div id="step2">
               <form name='FORM_STEP2' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 3 : Saisi des parametres &nbsp;--&nbsp;</legend>
                     <br />
                     <table width="100%">
                        <col width="45%"></col>
                        <col></col>
                        <tr>
                        <td>
                        <math xmlns="http://www.w3.org/1998/Math/MathML">
                           <mrow>
                              <mi>A</mi>
                              <mo>=</mo>
                           
                              <mfenced open="(" close=")">
                           
                                 <mtable>
                                    <?php for ($i=0; $i < $_POST["tailleN"]; $i++) { ?>
                                    <mtr>
                                       <?php for ($j=0; $j < $_POST["tailleN"]; $j++) { ?>
                                             <mtd><mi><input type="text" name="matrixA_<?=$i?>_<?=$j?>" size="3" class="matrixA" onChange="checkValue.call(this);" /></mi></mtd>
                                       <?php } ?>
                                    </mtr>
                                    <?php } ?>
                                 </mtable>
                                 
                              </mfenced>
                           </mrow>
                        </math>
                        </td>
                        <td>
                        <math xmlns="http://www.w3.org/1998/Math/MathML">
                           <mrow>
                              <mi>Y</mi>
                              <mo>=</mo>
                           
                              <mfenced open="(" close=")">
                           
                                 <mtable>
                                    <?php for ($i=0; $i < $_POST["tailleN"]; $i++) { ?>
                                    <mtr>
                                       <?php for ($j=0; $j < 1; $j++) { ?>
                                             <mtd><mi><input type="text" name="matrixY_<?=$i?>_<?=$j?>" size="3" class="matrixA" onChange="checkValue.call(this);" /></mi></mtd>
                                       <?php } ?>
                                    </mtr>
                                    <?php } ?>
                                 </mtable>
                                 
                              </mfenced>
                           </mrow>
                        </math>
                        </td>
                  </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr>
                        <td style="text-align:left;"><input type="button" name="btn_pre_step2" style="margin-left:30px;" id="back_step1" value="Annuler" onClick="check_step4(document.FORM_STEP2)"/></td>
                        <td style="text-align:right;"><input type="button" name="step2" style="margin-right:30px;" id="validate_step2" value="Continuer" onClick="validate_size2(document.FORM_STEP2)"/></td>
                     </tr>
                  </table>
               </form>
            </div>
         <?php }
         else {
         ?>
            <div id="step1">
               <form name='FORM_STEP1' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 2 : Définir la taille de la matrice &nbsp;--&nbsp;</legend>
                     <br />
                     <table width="100%">
                        <col width="10%"></col>
                        <col></col>
                        <tr>
                           <td> <span title="nombre 'n' d’équations du système">n </span> =</td>
                           <td><input type="number" min="1" name="tailleN" max="10" maxlength="3" size="3" /></td>
                        </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr style="text-align:right;">
                        <td><input type="button" name="step1" style="margin-right:30px;" id="validate_step1" value="Continuer" onClick="validate_size(document.FORM_STEP1)"/></td>
                     </tr>
                  </table>
               </form>
            </div>
         <?php } ?>
      </div>
      <script src="./js/checks.js"></script>
      <script src="./js/jquery_1.6.3.js"></script>
   </body>
</html>