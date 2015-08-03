<?php

require_once(__DIR__.'/lib/Matrix.php');

/* Units test */
try
{
  /* Addition */
  $a = new Matrix(array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)));
  $b = new Matrix(array(array(9, 8, 7), array(6, 5, 4), array(3, 2, 1)));
  echo "A :\n";
  $a->PrintMatrix();
  echo "B :\n";
  $b->PrintMatrix();
  $c = $a->Add($b);
  echo "C :\n";
  $c->PrintMatrix();

  /* Multiplication */
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

  /* Transposition */
  echo "A:\n";
  $a->PrintMatrix();
  $tmp = $a->Transpose();
  echo "A transposed:\n";
  $tmp->PrintMatrix();
  echo "B:\n";
  $b->PrintMatrix();
  $tmp = $b->Transpose();
  echo "B transposed:\n";
  $tmp->PrintMatrix();
  echo "C:\n";
  $c->PrintMatrix();
  $tmp = $c->Transpose();
  echo "C transposed:\n";
  $tmp->PrintMatrix();

  /* Tracing */
  $a = new Matrix(array(array(1, 2, 3), array(-1, 2, 4), array(5, 7, 5)));
  echo "A:\n";
  $a->PrintMatrix();
  echo "Trace of A: ".$a->Trace()."\n";
  $b = new Matrix(array(array(1, 2), array(-1, 2)));
  echo "B:\n";
  $b->PrintMatrix();
  echo "Trace of B: ".$b->Trace()."\n";
}
catch (Exception $e)
{
  var_dump($e);
}
