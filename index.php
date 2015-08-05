<?php
   session_start();
?>
<!doctype html>
<html>

   <head>
      <meta charset="UTF-8">
      <title>Math Project</title>
      <link rel="stylesheet" type="text/css" href="css/default.css">
   </head>
<?php
   $error = "";
   ## By default Step 1 is on to enable use choose the operation to apply
   $step = 1;
   if (isset($_POST) && array_key_exists("action", $_POST)) {
      $operator = $_POST["operation"];
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
      if ($_POST["action"] == "save_step2") {
         ## Can go to step 3 Where the user should fill the matrices
         $step = 3;
      }
      if ($_POST["action"] == "save_step3") {
         ## Step For matrice operation
         require_once(__DIR__.'/lib/Matrix.php');


         $step = 4;
         $j = 0;
         $result = array();

         for ($i = 0; isset($_POST["matrixA_".$i."_".$j]); $i++) {
            for ($j = 0; isset($_POST["matrixA_".$i."_".$j]); $j++) {
               $matrixA[$i][$j] = $_POST["matrixA_".$i."_".$j];
            }
            $j = 0;
         }

         $j = 0;
         for ($i = 0; isset($_POST["matrixB_".$i."_".$j]); $i++) {
            for ($j = 0; isset($_POST["matrixB_".$i."_".$j]); $j++) {
               $matrixB[$i][$j] = $_POST["matrixB_".$i."_".$j];
            }
            $j = 0;
         }

         try {
            $a = new Matrix($matrixA);
            if (isset($matrixB) && is_array($matrixB)) {
               $b = new Matrix($matrixB);
            }
            switch ($operator) {
               case 'somme':
                  $result = $a->Add($b);
                  $result = $result->GetMatrix();
                  break;
               case 'produit':
                  $result = $a->Mult($b);
                  $result = $result->GetMatrix();
                  $resultBA = $b->Mult($a);
                  $resultBA = $resultBA->GetMatrix();
                  break;
               case 'transpose':
                  $result = $a->Transpose();
                  $result = $result->GetMatrix();
                  break;
               case 'trace':
                  $result = $a->Trace();
                  break;
               default:
                  break;
            }
         } catch (Exception $e) {
            ## An error occured. The user is redirected to step 2.
            //$step = 2;
            $error = $e;
         }

      }
   }

?>
   <body>

      <div id="bg_div">
         <?php if ($step == 4) { ?>
            <div id="step4">
               <form name='FORM_STEP4' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 4 : Resultat de l'operation demandé &nbsp;--&nbsp;</legend>
                        <table width="100%">
                           <tr>
                        <?php if ($operator == "trace") { 
                                 $_SESSION["matrixA"] = $matrixA;
                                 $_SESSION["result"] = $result;
                                 
                        ?>
                        <!-- The result for the trace operation -->
                           <td>
                            <?php require_once (__DIR__.'/files/traceResult.php'); ?>
                           </td>
                        <?php } else { ?>
                           <td>
                              <!-- This portion shows result of all other operations than 'trace' -->
                           <?php switch ($operator) {
                                 case 'somme':
                                    $_SESSION["matrixA"] = $matrixA;
                                    $_SESSION["matrixB"] = $matrixB;
                                    $_SESSION["result"] = $result;
                                    require_once (__DIR__.'/files/sumResult.php');
                                    break;
                                 case 'produit':
                                    $_SESSION["matrixA"] = $matrixA;
                                    $_SESSION["matrixB"] = $matrixB;
                                    $_SESSION["result"] = $result;
                                    $_SESSION["resultBA"] = $resultBA;
                                    require_once (__DIR__.'/files/prodResult.php');
                                    break;
                                 case 'transpose':
                                    $_SESSION["matrixA"] = $matrixA;
                                    $_SESSION["result"] = $result;
                                    require_once (__DIR__.'/files/transResult.php');
                                    break;
                              } 
                              echo $error;
                           ?>
                        </td>
                        <?php
                           }
                        ?>
                     </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr style="text-align:right;">
                        <td><input type="button" name="btn_step4" style="margin-right:30px;" id="validate_step4" value="Terminer" onClick="check_step4(document.FORM_STEP4)"/></td>
                     </tr>
                  </table>
               </form>
            </div>
         <?php }
         else if ($step == 3) {
            ## Etape pour saisir les parametres des matrices
         ?>
            <div id="step3">
               <form name='FORM_STEP3' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="operation" value="<?=$operator;?>" />
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 3 : Saisi des parametres &nbsp;--&nbsp;</legend>
                     <br />
                     <table width="100%">
                        <col width="30%"></col>
                        <col></col>
                        <tr>
                     <?php
                        if ($operator == "trace") {
                     ?>
                        <td>
                        <math xmlns="http://www.w3.org/1998/Math/MathML">
                           <mrow>
                              <mi>A</mi>
                              <mo>=</mo>
                           
                              <mfenced open="(" close=")">
                           
                                 <mtable>
                                    <?php
                                       for ($i=0; $i < $_POST["tailleA"]; $i++) {
                                    ?>
                                    <mtr>
                                       <?php
                                          for ($j=0; $j < $_POST["tailleA"]; $j++) {
                                       ?>
                                             <mtd><mi><input type="text" name="matrixA_<?=$i?>_<?=$j?>" size="3" class="matrixA" onChange="checkValue.call(this);" /></mi></mtd>
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
                        </td>
                        <td></td>
                     <?php
                        }
                        else {
                     ?>
                           <td>
                           <math xmlns="http://www.w3.org/1998/Math/MathML">
                              <mrow>
                                 <mi>A</mi>
                                 <mo>=</mo>
                              
                                 <mfenced open="(" close=")">
                              
                                    <mtable>
                                       <?php
                                          for ($i=0; $i < $_POST["lineA"]; $i++) {
                                       ?>
                                       <mtr>
                                          <?php
                                             for ($j=0; $j < $_POST["colA"]; $j++) {
                                          ?>
                                                <mtd><mi><input type="text" name="matrixA_<?=$i?>_<?=$j?>" class="matrixA" size="3" onChange="checkValue.call(this);" /></mi></mtd>
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
                        </td>
                        <td>
                        <?php
                           switch ($operator) {
                              case 'somme':
                              case 'produit':
                        ?>
                        <!--<br/><br/> -->
                                 <math xmlns="http://www.w3.org/1998/Math/MathML">
                                    <mrow>
                                       <mi>B</mi>
                                       <mo>=</mo>
                                    
                                       <mfenced open="(" close=")">
                                    
                                          <mtable>
                                             <?php
                                                for ($i=0; $i < $_POST["lineB"]; $i++) {
                                             ?>
                                             <mtr>
                                                <?php
                                                   for ($j=0; $j < $_POST["colB"]; $j++) {
                                                ?>
                                                      <mtd><mi><input type="text" name="matrixB_<?=$i?>_<?=$j?>" size="3" class="matrixB" onChange="checkValue.call(this);"/></mi></mtd>
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
                        <?php
                                 break;
                              default:
                                 # code...
                                 break;
                           } 
                        ?>
                     </td>
                     <?php
                        }
                     ?>
                  </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr style="text-align:right;">
                        <td style="text-align:left;"><input type="button" name="btn_pre_step3" style="margin-left:30px;" value="Annuler" onClick="check_step4(document.FORM_STEP3)"/></td>
                        <td><input type="button" style="margin-right:30px;" name="step3" id="validate_step3" value="Calculer" onClick="check_step3(document.FORM_STEP3)"/></td>
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
                  <input type="hidden" name="operation" value="<?=$operator;?>" />
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 2 : Définir la taille de la matrice &nbsp;--&nbsp;</legend>
                     <br />
                     <table width="100%">
                     <?php
                        if ($operator == "trace") {
                     ?>
                        <col width="10%"></col>
                        <col></col>
                        <tr>
                           <td>Taille de la Matrice A</td>
                           <td><input type="number" min="1" name="tailleA" max="99" maxlength="3" size="3" /></td>
                        </tr>
                     <?php
                        }
                        else {
                     ?>
                           <col width="5%"></col>
                           <col width="20%"></col>
                           <col></col>
                           <tr>
                              <td rowspan="2"> A = </td>
                              <td>Nombre de ligne</td>
                              <td><input type="number" min="1" max="99" name="lineA" maxlength="3" size="3" /></td>
                           </tr>
                           <tr>
                              <td>Nombre de colonne</td>
                              <td><input type="number" min="1" name="colA" max="99" maxlength="3" size="3" /></td>
                           </tr>
                        <?php
                           switch ($operator) {
                              case 'somme':
                              case 'produit':
                        ?>
                                 <tr>
                                    <td rowspan="2"> B = </td>
                                    <td>Nombre de ligne</td>
                                    <td><input type="number" min="1" name="lineB" max="99" maxlength="3" size="3" /></td>
                                 </tr>
                                 <tr>
                                    <td>Nombre de colonne</td>
                                    <td><input type="number" min="1" name="colB" max="99" maxlength="3" size="3" /></td>
                                 </tr> 
                        <?php
                                 break;
                              default:
                                 # code...
                                 break;
                           } 
                        }
                     ?>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr>
                        <td style="text-align:left;"><input type="button" name="btn_pre_step2" style="margin-left:30px;" id="back_step1" value="Annuler" onClick="check_step4(document.FORM_STEP2)"/></td>
                        <td style="text-align:right;"><input type="button" name="step2" style="margin-right:30px;" id="validate_step2" value="Continuer" onClick="check_step2(document.FORM_STEP2)"/></td>
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
                  <input type="hidden" name="operation" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;--&nbsp;Etape 1 : Choisir l'op&eacute;ration &agrave; &eacute;ffectuer &nbsp;--&nbsp;</legend>
                     <table width="100%">
                        <col width="15%"></col>
                        <col></col>
                        <tr>
                           <td>Somme</td>
                           <td><input type="checkbox" class="op" name="add" id="add" value="somme" onChange="activateAdd()"/></td>
                        </tr>
                        <tr>
                           <td>Produit</td>
                           <td><input type="checkbox" class="op" name="prod" id="prod" value="produit" onChange="activateprod()"/></td>
                        </tr>
                        <tr>
                           <td>Transpos&eacute;e</td>
                           <td><input type="checkbox" class="op" name="trans" id="trans" value="transpose" onChange="activatetrans()"/></td>
                        </tr>
                        <tr>
                           <td>Trace</td>
                           <td><input type="checkbox" class="op" name="trace" id="trace" value="trace" onChange="activatetrace()"/></td>
                        </tr>
                     </table>
                  </fieldset>
                  <table width="100%">
                     <tr style="text-align:right;">
                        <td><input type="button" name="step1" style="margin-right:30px;" id="validate_step1" value="Continuer" onClick="check_step1(document.FORM_STEP1)"/></td>
                     </tr>
                  </table>
               </form>
            </div>
         <?php } ?>
      </div>
      <script type="text/javascript">
         function activateAdd() {
            $("#add").attr('checked', true);
            $("#prod").attr('checked', false);
            $("#trans").attr('checked', false);
            $("#trace").attr('checked', false);
         }

         function activateprod() {
            $("#add").attr('checked', false);
            $("#prod").attr('checked', true);
            $("#trans").attr('checked', false);
            $("#trace").attr('checked', false);
         }

         function activatetrans() {
            $("#add").attr('checked', false);
            $("#prod").attr('checked', false);
            $("#trans").attr('checked', true);
            $("#trace").attr('checked', false);
         }

         function activatetrace() {
            $("#add").attr('checked', false);
            $("#prod").attr('checked', false);
            $("#trans").attr('checked', false);
            $("#trace").attr('checked', true);
         }

         function checkValue() {
            if (isNaN(this.value)) {
               alert(this.value + " is not a number");
               this.value = "";
               return false;
            }
            return true;
         }

         function check_step1(myform) {
            var count;
            var op;

            count = 0;
            $('.op').each(function(i, obj) {
               if (obj.checked) {
                  count++;
                  op = obj.value;
               }
            });
            if (count == 0) {
               alert("Vous devez Choisir 1 operation a effectuer sur les matrices pour pouvoir continuer");
            }
            else if (count > 1) {
               alert("Seulement une seul operation est possible. Recommencer s'il vous plais");
            }
            else {
               alert("Le choix de votre operation a ete sauvegarder avec succes");
               myform.operation.value = op;
               myform.action.value = "save_step1";
               $("#step1").hide();
               $("#step2").show();
               myform.submit();
            }
         }

         function check_step2(myform) {
            if (myform.operation.value == "trace") {
               if (myform.tailleA.value < 1) {
                  alert("La taille de la matrice A ne peut pas etre inferieur a 1");
                  return false;
               }
            }
            else if (myform.operation.value == "transpose") {
               if (myform.lineA.value < 1 || myform.colA.value < 1) {
                  alert("La taille de la matrice A ne peut pas etre inferieur a 1");
                  return false;
               }
            }
            else {
               if (myform.lineA.value < 1 || myform.colA.value < 1) {
                  alert("Le nombre de lignes de la matrice A ne peut pas etre inferieur a 1");
                  return false;
               }
               if (myform.lineB.value < 1 || myform.colB.value < 1) {
                  alert("Le nombre de colonne de la matrice B ne peut pas etre inferieur a 1");
                  return false;
               }
            }
            myform.action.value = "save_step2";
            $("#step2").hide();
            $("#step3").show();
            myform.submit();
         }

         function check_step3(myform) {
            var op = myform.operation.value;
            var test = 0;
            $('.matrixA').each(function(i, objA) {
               if (objA.value == "" ){
                  alert("Remplisser toutes les valeurs de la matrice A s'il vous plais ...");
                  objA.focus();
                  test = 1;
                  return false;
               }
            });

            if ( (op == "somme" || op == "produit") && test == 0) {
               $('.matrixB').each(function(i, objB) {
                  if (objB.value == "" ){
                     alert("Remplisser toutes les valeurs de la matrice B s'il vous plais ...");
                     objB.focus();
                     test = 1;
                     return false;
                  }
               });
            }

            if (test > 0) {
               return false;
            }

            myform.action.value = "save_step3";
            $("#step3").hide();
            $("#step4").show();
            myform.submit();
         }

         function check_step4(myform) {
            $("#step4").hide();
            $("#step1").show();
            myform.action.value = "save_step4";
            myform.submit();
         }
         </script>
         <script src="./js/jquery_1.6.3.js"></script>
   </body>
</html>