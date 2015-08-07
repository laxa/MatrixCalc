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

  /* Trying gauss resolution */
  $a = new Matrix(array(array(1, 2, 1), array(2, -1, 2), array(3, 1, -1)));
  echo "Printing the matrix we will use for gauss resolution:\n";
  $a->PrintMatrix();
  echo "Now gauss...\n";
  $a->GaussMethod(new Matrix(array(array(9), array(3), array(8))));
  $a = new Matrix(array(array(0, 2, 1), array(2, -1, 2), array(3, 1, -1)));
  echo "Printing the matrix we will use for gauss resolution:\n";
  $a->PrintMatrix();
  echo "Now gauss...\n";
  $a->GaussMethod(new Matrix(array(array(9), array(3), array(8))));
  $a = new Matrix(array(array(1, 2), array(2, 1)));
  $a->GaussMethod(new Matrix(array(array(7), array(5))));
  $a = new Matrix(array(array(2, 3, -1, 1), array(4, 7, 2, 4), array(2, 6, 3, 2), array(1, 1, 0, 1)));
  $a->GaussMethod(new Matrix(array(array(-2), array(5), array(4), array(1))));
  $a = new Matrix(array(array(1, 2), array(2, 1)));
  $ret = $a->GaussMethod(new Matrix(array(array(5), array(11))));
}
catch (Exception $e)
{
  var_dump($e);
}
