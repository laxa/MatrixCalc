<?php

class Matrix
{
  /* Matrix is stored in that array */
  private $matrix;
  /* string who contains error */
  private $error;
  private $columns;
  private $lines;

  /* Construct a Matrix */
  /* array must contains an array for each line of the matrix */
  /* A matrix should be something like this : */
  /* $matrix = array(array(0, 1, 2), array(3, 4, 5), array(6, 7, 8)); */
  public function __construct($array)
  {
    if (sizeof($array) == 0)
      return false;
    $this->columns = sizeof($array[0]);
    $this->lines = sizeof($array);
    $this->matrix = $array;
    return $this;
  }

  public function Add(Matrix $b)
  {
    $this->checkMatrix($b);
    $tmp = array();
    $matrix = $b->getMatrix();
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
        $tmp[$l][$c] = $this->matrix[$l][$c] + $matrix[$l][$c];
    }
    return new Matrix($tmp);
  }

  public function printMatrix()
  {
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
        echo $this->matrix[$l][$c].' ';
      echo "\n";
    }
  }

  /* Check if matrix have the same columns and size */
  private function checkMatrix(Matrix $b)
  {
    if ($this->getLines() != $b->getLines())
      throw new Exception('The matrixs have not the same size');
    if ($this->getColumns() != $b->getColumns())
      throw new Exception('The matrixs have not the same size');
  }

  /* getters */
  public function getMatrix()
  {
    return $this->matrix;
  }

  public function getColumns()
  {
    return $this->columns;
  }

  public function getLines()
  {
    return $this->lines;
  }
}
