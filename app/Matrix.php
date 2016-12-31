<?php

namespace App;

class Matrix{
    private $matrix;

    function __construct($n){
        $this->construirMatrix($n);
    }

    private function construirMatrix($n){
        for ($i = 0; $i <= $n; $i++) {
            for ($j = 0; $j <= $n; $j++) {
                for ($k = 0; $k <= $n; $k++) {
                    $this->matrix[$i][$j][$k] = 0;
                }
            }
        }
    }

    public function updateMatrix($x, $y, $z, $value){
        $this->matrix[$x][$y][$z] = $value;
    }

    public function queryMatrix($x1, $y1, $z1, $x2, $y2, $z2){
        $sum = 0;
        for ($x = $x1; $x <= $x2; $x++) {
            for ($y = $y1; $y <= $y2; $y++) {
                for ($z = $z1; $z <= $z2; $z++) {
                    $sum += $this->matrix[$x][$y][$z];
                }
            }
        }
        return $sum;
    }

    public function getMatrix(){
        return $this->matrix;
    }
}
