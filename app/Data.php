<?php

namespace App;

use App\Matrix;
use App\CustomException;

class Data{
    private $data;

    
    public function leerArchivo($entrada){
        $datos = file($entrada);

        if(count($datos) < 2){
            throw new \Exception();
        }
        
        $this->data = $datos;
    }

    public function limpiarLinea($linea){
       return trim(preg_replace('/\s\s+/', ' ', $linea));
    }
    
    public function leerLinea(){//Retorna la linea actual
        $linea = $this->limpiarLinea(reset($this->data));
        array_shift($this->data);
        return $linea;
    }
    
    public function realizarOperaciones($t, $n, $m){
        if($n > 100 || $n < 0){ //Validacion rango N
            throw new CustomException("Error", "Valor inválido de N - Caso de prueba ".$t);
        }
        
        if($m > 1000 || $n < 0){ //Validacion rango M
            throw new CustomException("Valor inválido de M - Caso de prueba ".$t);
        }
        
        $matrix = new Matrix($n); //Contrucción de la matriz
        $respuesta = [];

        for($k = 1; $k <= $m; $k++){ //Operaciones sobre la matriz
            $operacion = explode(" ", $this->leerLinea());
            $tipoOperacion = $operacion[0];

            if($tipoOperacion == "UPDATE"){
                $x = (int)$operacion[1];
                $y = (int)$operacion[2];
                $z = (int)$operacion[3];
                $w = (int)$operacion[4];

                //Validaciones entrada UPDATE
                if( 
                    ($x>$n || $x<1) || 
                    ($y>$n || $y<1) || 
                    ($z>$n || $z<1) ||
                    ($w > pow(10, 9) || $w < pow(10, -9))){
                    
                    throw new CustomException("Error", "Valores inválidos en funcion UPDATE - Caso de prueba ". $t. ", operación  ". $k);
                }
   
                $matrix->updateMatrix($x, $y, $z, $w);

            }else if($tipoOperacion == "QUERY"){
                $x1 = (int)$operacion[1];
                $y1 = (int)$operacion[2];
                $z1 = (int)$operacion[3];
                $x2 = (int)$operacion[4];
                $y2 = (int)$operacion[5];
                $z2 = (int)$operacion[6];
                
                //Validaciones entrada QUERY
                if( 
                    ($x1 >= 1 && $x2 >= 1 && $y1 >= 1 && $y2 >= 1 && $z1 >= 1 && $z2 >= 1) &&
                    ($x1<=$x2 && $x2<=$n) && 
                    ($y1<=$y2 && $y2<=$n) && 
                    ($z1<=$y2 && $z2<=$n)
                ){
                     $respuesta[] = $matrix->queryMatrix($x1, $y1, $z1, $x2, $y2, $z2);
                    
                }else{
                    throw new CustomException("Error", "Valores inválidos en funcion QUERY  - Caso de prueba ". $t. ", operación  ". $k);
                }
            }else{ //Nombre de operacion no válido o valor de M no coincide con cantidad de operaciones
                 throw new CustomException("Error", "Operación inválida  - Caso de prueba ". $t. ", operación  ". $k);
            }
        }
        return $respuesta;    
    }
    
    public function procesarData(){
        $testCases = $this->leerLinea();
        
        if($testCases < 0 || $testCases > 50){ //Validacion rango T
            throw new CustomException("Error", "Valor inválidos de T");
        }

        for ($t = 1; $t <= $testCases; $t++) { //Ejecucion de operaciones
            $dataMatrix = explode(" ", $this->leerLinea());
            $n = $dataMatrix[0];
            $m = $dataMatrix[1];

            $respuesta[] = $this->realizarOperaciones($t, $n, $m);
        }
            
        return $respuesta;
    }

}
