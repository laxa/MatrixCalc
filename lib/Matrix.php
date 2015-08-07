<?php

class Matrix
{
  /* floats to print */
  private $floats = 2;
  /* Matrix is stored in that array */
  private $matrix;
  private $columns;
  private $lines;

  /* Construct a Matrix */
  /* array must contains an array for each line of the matrix */
  /* the values inside arrays are expected to be valid number with is_numeric() */
  /* A matrix should be something like this : */
  /* $matrix = array(array(0, 1, 2), array(3, 4, 5), array(6, 7, 8)); */
  public function __construct($array)
  {
    if ($array === null) throw new Exception('Null array given');
    if (sizeof($array) == 0) throw new Exception('Can\'t construct Matrix, array given is invalid');
    $this->columns = sizeof($array[0]);
    $this->lines = sizeof($array);
    $this->checkArray($array);
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
        printf("%6.2f ", $this->matrix[$l][$c]);
      echo "\n";
    }
  }

  public function GaussMethod(Matrix $b)
  {
    /* checking size of Matrix to be sure we don't need to check out of bounds later */
    if ($this->columns != $this->lines) throw new Exception('Matrix isn\'t square, can\'t do gauss method');
    if ($b->GetLines() != $this->lines) throw new Exception('Needs to have same number of lines');
    /* ret will contain a list of Matrix corresponding to what's asked in the subject */
    $ret = array();
    for ($l = 0; $l < $this->lines - 1; $l++)
    {
      if ($this->matrix[$l][$l] === 0)
      {
        $swap = $this->findNotNull($l);
        if ($swap) $this->swapLine($b, $l, $swap);
      }
      $g = $this->getG($l);
      if ($g === null) throw new Exception('Can\'t solve this equation');
      $ret['G'.($l + 1)] = $g;
      $tmp = $g->Mult($this);
      $b = $g->Mult($b);
      $ret['Y'.($l + 2)] = $b;
      $this->matrix = $tmp->GetMatrix();
      $ret['A'.($l + 2)] = $this;
    }
    /* We can solve the equations now */
    $sol = array();
    $b = $b->GetMatrix();
    for ($l = $this->lines - 1; $l >= 0; $l--)
    {
      $tmp = $b[$l][0];
      if ($this->matrix[$l][$l] === 0) throw new Exception('No valid solution found');
      /* we evaluate each line with the x that we already know */
      foreach ($sol as $key => $value)
        $tmp -= $this->matrix[$l][$key] * $value;
      $sol[$l] = $tmp / $this->matrix[$l][$l];
    }
    /* Need to revert $sol array */
    /* Now we add $sol to the return */
    foreach ($sol as $key => $val)
      $sol[$key] = round($val, $this->floats);
    $sol = array_values($sol);
    $sol = array_reverse($sol);
    $ret['solutions'] = $sol;
    /* ret contains all the information about the gauss like 'G1', 'A2', 'Y2' and also the 'solutions' */
    return $ret;
  }

  private function roundMatrix()
  {
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
        $this->matrix[$l][$c] = round($this->matrix[$l][$c], $this->floats);
    }
  }

  private function getG($line)
  {
    /* We need to display a standart Matrix if that happens */
    if ($this->matrix[$line][$line] === 0) return null;
    $new = $this->getDefaultG();
    $array = $new->GetMatrix();
    for ($l = $line + 1; $l < $this->lines; $l++)
      $array[$l][$line] = -1 * ($this->matrix[$l][$line] / $this->matrix[$line][$line]);
    return new Matrix($array);
  }

  /* generate an anti-diagonal matrix of the size of the Matrix object */
  private function getDefaultG()
  {
    $new = array();
    for ($l = 0; $l < $this->lines; $l++)
    {
      $new[$l] = array();
      for ($c = 0; $c < $this->columns; $c++)
        $new[$l][$c] = 0;
    }
    for ($i = 0; $i < $this->lines; $i++)
      $new[$i][$i] = 1;
    return new Matrix($new);
  }

  private function findNotNull($index)
  {
    for ($i = $index + 1; $i < $this->lines; $i++)
      if ($this->matrix[$i][$index] !== 0) return $i;
    return null;
  }

  /* $line is the index of the line we swap with the index of the other swaped line */
  private function swapLine(Matrix &$y, $line, $swapLine)
  {
    $tmp = $this->matrix[$line];
    $this->matrix[$line] = $this->matrix[$swapLine];
    $this->matrix[$swapLine] = $tmp;
    $matrix = $y->GetMatrix();
    $tmp = $matrix[$line];
    $matrix[$line] = $matrix[$swapLine];
    $matrix[$swapLine] = $tmp;
    $y = new Matrix($matrix);
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

  private function checkArray($array)
  {
    for ($l = 0; $l < $this->lines; $l++)
    {
      for ($c = 0; $c < $this->columns; $c++)
      {
        if (!isset($array[$l][$c])) throw new Exception('Array given have unsetted values');
        if (!is_numeric($array[$l][$c])) throw new Exception('Non numerical value detected inside array');
      }
    }
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
