<?php

require_once(__DIR__.'/lib/Matrix.php');

/* Units test */
try
{
  $a = new Matrix(array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)));
  $b = new Matrix(array(array(9, 8, 7), array(6, 5, 4), array(3, 2, 1)));
  echo "A :\n";
  $a->PrintMatrix();
  echo "B :\n";
  $b->PrintMatrix();
  $c = $a->Add($b);
  echo "C :\n";
  $c->PrintMatrix();
  $c = $a->Mult($b);
  echo "Doing AB:\n";
  $c->PrintMatrix();
  $a = new Matrix(array(array(1, 2, 3), array(1, -1, 2)));
  echo "New matrix A:\n";
  $a->PrintMatrix();
  $b = new Matrix(array(array(1, 2), array(0, -1), array(1, 1)));
  echo "New matrix B:\n";
  $b->PrintMatrix();
  $c = $a->Mult($b);
  echo "AB gives us:\n";
  $c->PrintMatrix();
  $c = $b->Mult($a);
  echo "BA gives us:\n";
  $c->PrintMatrix();
}
catch (Exception $e)
{
  var_dump($e);
}
