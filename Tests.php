<?php

require_once(__DIR__.'/lib/Matrix.php');

/* Units test */

/* Testing Addition */

$a = new Matrix(array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)));
$b = new Matrix(array(array(9, 8, 7), array(6, 5, 4), array(3, 2, 1)));

echo "A :\n";
$a->printMatrix();
echo "B :\n";
$b->printMatrix();

try
{
  $c = $a->Add($b);
  echo "C :\n";
  $c->printMatrix();
}
catch (Exception $e)
{
  var_dump($e);
}
