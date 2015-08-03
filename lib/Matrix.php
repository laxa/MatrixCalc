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
    $matrix = $b->GetMatrix();
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
        $tmp[$l][$c] = $this->matrix[$l][$c] + $matrix[$l][$c];
    }
    return new Matrix($tmp);
  }

  public function Mult(Matrix $b)
  {
    $this->checkMatrixMult($b);
    $tmp = array();
    $matrix = $b->GetMatrix();
    $col = $b->GetColumns();
    for ($l = 0; $l < $this->lines; $l++)
      for ($c = 0; $c < $col; $c++)
      {
        /* create tmp array for mult */
        $array = array();
        for ($linB = 0; $linB < $b->GetLines(); $linB++)
          $array[] = $matrix[$linB][$c];
        $tmp[$l][] = $this->arrayMult($this->matrix[$l], $array);
      }
    return new Matrix($tmp);
  }

  /* return an int that is the trace of the matrix */
  public function Trace()
  {
    if ($this->columns != $this->lines) throw new Exception('Can\'t Trace a matrix which isn\'t squared');
    $ret = 0;
    for ($i = 0; $i < $this->lines; $i++)
      $ret += $this->matrix[$i][$i];
    return $ret;
  }

  /* return a new Matrix */
  public function Transpose()
  {
    $ret = array();
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
      {
        if (!isset($this->matrix[$l][$c])) throw new Exception('Matrix failed to be transposed');
        $ret[$c][$l] = $this->matrix[$l][$c];
      }
    }
    return new Matrix($ret);
  }

  public function PrintMatrix()
  {
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
        printf("%3d ", $this->matrix[$l][$c]);
      echo "\n";
    }
  }

  /* $arr1 and $arr2 are suppose to be the same */
  private function arrayMult($arr1, $arr2)
  {
    $size = sizeof($arr1);
    if ($size != sizeof($arr2)) throw new Exception('Problem not suppose to happen!');
    $ret = 0;
    for ($i = 0; $i < $size; $i++)
      $ret += $arr1[$i] * $arr2[$i];
    return $ret;
  }

  private function checkMatrixMult(Matrix $b)
  {
    if ($b->GetLines() != $this->GetColumns())
      throw new Exception('Can\'t multiply when lines and columns are differnet');
  }

  /* Check if matrix have the same columns and size */
  private function checkMatrix(Matrix $b)
  {
    if ($this->GetLines() != $b->GetLines())
      throw new Exception('The matrixs have not the same size');
    if ($this->GetColumns() != $b->GetColumns())
      throw new Exception('The matrixs have not the same size');
  }

  /* getters */
  public function GetMatrix()
  {
    return $this->matrix;
  }

  public function GetColumns()
  {
    return $this->columns;
  }

  public function GetLines()
  {
    return $this->lines;
  }
}
