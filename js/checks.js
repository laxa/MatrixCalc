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

function validate_size(myform) {
   if (myform.tailleN.value == "") {
      alert("The value of 'n' is not a number");
      return false;
   }
   myform.action.value = "save_step1";
   myform.submit();
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
      myform.operation.value = op;
      myform.action.value = "save_step1";
      $("#step1").hide();
      $("#step2").show();
      myform.submit();
   }
}

function check_step2(myform) {
   var op = myform.operation.value;
   if (op == "trace") {
      if (myform.tailleA.value < 1) {
         alert("La taille de la matrice A ne peut pas etre inferieur a 1");
         return false;
      }
   }
   else if (op == "transpose") {
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

      if (op == "somme" && 
         (myform.lineA.value != myform.lineB.value || myform.colA.value != myform.colB.value)) {
         alert("Somme A + B non calculable. Les matrices A et B doivent être de même taille.");
         return false;
      }

      if (op == "produit" && myform.lineB.value != myform.colA.value) {
         alert("Produit AB non calculable. Le nombre de lignes de B doit être égal au nombre de colonnes de A");
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

function validate_size2(myform) {
   var test = 0;
   $('.matrixA').each(function(i, objA) {
      if (objA.value == "" ){
         alert("Remplisser toutes les valeurs de la matrice A s'il vous plais ...");
         objA.focus();
         test = 1;
         return false;
      }
   });

   if (test > 0) {
      return false;
   }

   myform.action.value = "save_step3";
   $("#step3").hide();
   $("#step4").show();
   myform.submit();
}

function check_step4(myform) {
   myform.action.value = "save_step4";
   $("#step4").hide();
   $("#step1").show();
   myform.submit();
}