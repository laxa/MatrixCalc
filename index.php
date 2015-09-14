<?php
   session_start();
?>
<!doctype html>
<html>

   <head>
      <meta charset="UTF-8">
      <title>Math Project (Calcul Matriciels)</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
            $step = 2;
            $error = $e->getMessage();
         }

      }
   }

?>
   <body>
      <div id="navigation">
         <a href="#" class="active">Calcul Matriciels</a>
         <a href="./gauss.php">Algorithme de Gauss</a>
      </div>

      <div id="bg_div">
         <h1>Calcul Matriciels</h1>
         <?php if ($step == 4) { ?>
            <div id="step4">
               <form name='FORM_STEP4' method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" style="width:100%">
                  <input type="hidden" name="action" value="" />
                  <fieldset style="margin-left:30px;margin-right:30px;">
                     <legend> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etape 4 : Resultat de l'operation demandé &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
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
                     <legend> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etape 3 : Saisi des parametres &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
                     <br />
                     <table width="100%">
                        <col width="30%"></col>
                        <col></col>
                        <tr>
                     <?php if ($operator == "trace") { ?>
                        <td>
                           <script type="math/mml">
                           <math>
                              <mstyle displaystyle="true">
                                 <mrow>
                                    <mi>A</mi>
                                    <mo>=</mo>
                                 
                                    <mfenced open="(" close=")">
                                 
                                       <mtable>
                                          <?php for ($i=0; $i < $_POST["tailleA"]; $i++) { ?>
                                          <mtr>
                                             <?php for ($j=0; $j < $_POST["tailleA"]; $j++) { ?>

                                                   <mtd>
                                                   <semantics>
                                                      <annotation-xml encoding="application/xhtml+xml">
                                                        <input  xmlns="http://www.w3.org/1999/xhtml" type="text" name="matrixA_<?=$i?>_<?=$j?>" size="3" class="matrixA" onChange="checkValue.call(this);" />
                                                      </annotation-xml>
                                                    </semantics>
                                                   </mtd>
                                              
                                             <?php } ?>
                                          </mtr>
                                          <?php } ?>
                                       </mtable>
                                       
                                    </mfenced>
                                 </mrow>
                              </mstyle>
                           </math>
                           </script>
                        </td>
                        <td></td>
                     <?php } else { ?>
                           <td>
                              <script type="math/mml">
                              <math>
                                 <mstyle displaystyle="true">
                                    <mrow>
                                       <mi>A</mi>
                                       <mo>=</mo>
                                    
                                       <mfenced open="(" close=")">
                                    
                                          <mtable>
                                             <?php for ($i=0; $i < $_POST["lineA"]; $i++) { ?>
                                             <mtr>
                                                <?php for ($j=0; $j < $_POST["colA"]; $j++) { ?>
                                                      <mtd>
                                                         <semantics>
                                                            <annotation-xml encoding="application/xhtml+xml">
                                                               <input type="text" xmlns="http://www.w3.org/1999/xhtml" name="matrixA_<?=$i?>_<?=$j?>" class="matrixA" size="3" onChange="checkValue.call(this);" />
                                                            </annotation-xml>
                                                       </semantics>
                                                      </mtd>
                                                       
                                                <?php } ?>
                                             </mtr>
                                             <?php } ?>
                                          </mtable>
                                          
                                       </mfenced>
                                    </mrow>
                                 </mstyle>
                              </math>
                              </script>
                        </td>
                        <td>
                        <?php
                           switch ($operator) {
                              case 'somme'   :
                              case 'produit' :
                        ?>
                              <script type="math/mml">
                                 <math>
                                   <mstyle displaystyle="true">
                                    <mrow>
                                       <mi>B</mi>
                                       <mo>=</mo>
                                    
                                       <mfenced open="(" close=")">
                                    
                                          <mtable>
                                             <?php for ($i=0; $i < $_POST["lineB"]; $i++) { ?>
                                             <mtr>
                                                <?php for ($j=0; $j < $_POST["colB"]; $j++) { ?>
                                                      <mtd>
                                                         <semantics>
                                                            <annotation-xml encoding="application/xhtml+xml">
                                                                  <input type="text" xmlns="http://www.w3.org/1999/xhtml" name="matrixB_<?=$i?>_<?=$j?>" class="matrixB" size="3" onChange="checkValue.call(this);"/>
                                                            </annotation-xml>
                                                         </semantics>
                                                      </mtd>
                                                <?php } ?>
                                             </mtr>
                                             <?php } ?>
                                          </mtable>
                                          
                                       </mfenced>
                                    </mrow>
                                 </mstyle>
                                 </math>
                              </script>
                        <?php
                                 break;
                              default:
                                 # code...
                                 break;
                           } 
                        ?>
                     </td>
                     <?php } ?>
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
                     <legend> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etape 2 : Définir la taille de la matrice &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
                     <br />
                     <span class="error"><?= $error; ?></span>
                     <br />
                     <table width="100%">
                     <?php
                        if ($operator == "trace") {
                     ?>
                        <col width="10%"></col>
                        <col></col>
                        <tr>
                           <td>L'ordre de la Matrice A</td>
                           <td><input type="number" min="2" name="tailleA" max="99" maxlength="3" size="3" /></td>
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
                     <legend> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etape 1 : Choisir l'op&eacute;ration &agrave; &eacute;ffectuer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
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
      <div id="footer">
         Realised By <b>egloff_j & mouafo_a</b> <br/>
         Project given By <b>ETNA</b>
      </div>
      <script src="./js/checks.js"></script>
      <script type="text/javascript" src="./js/MathJax/MathJax.js?config=MML_HTMLorMML-full"></script>
      <script src="./js/jquery_1.6.3.js"></script>
   </body>
</html>