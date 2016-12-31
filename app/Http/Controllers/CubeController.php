<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Matrix;
use App\CustomException;


class CubeController extends Controller{

    public function home(){
        return view('home');
    }
    
    public function limpiarLinea($linea){
       return trim(preg_replace('/\s\s+/', ' ', $linea));
    }
    
    public function leerLinea(&$data){
        $linea = $this->limpiarLinea(reset($data));
        array_shift($data);
        return $linea;
    }
    
    public function realizarOperaciones($n, $m, &$data){

        if($n > 100 || $n < 0){ //Validacion rango N
            throw new CustomException("Error", "Valor inválido de N");
        }
        
        if($m > 1000 || $n < 0){ //Validacion rango M
            throw new CustomException("Error", "Valor inválido de M");
        }
        
        $matrix = new Matrix($n);
        $respuesta = [];

        for($k = 1; $k <= $m; $k++){
            $operacion = explode(" ", $this->leerLinea($data));
            $tipoOperacion = $operacion[0];

            if($tipoOperacion == "UPDATE"){
                $x = (int)$operacion[1];
                $y = (int)$operacion[2];
                $z = (int)$operacion[3];
                $w = (int)$operacion[4];
                
                //Validaciones entrada UPDATE
                if( 
                    ($x>$n || $x<0) || 
                    ($y>$n || $y<0) || 
                    ($z>$n || $z<0) ||
                    ($w > pow(10, 9) || $w < pow(10, -9))){
                    
                    throw new CustomException("Error", "Valores inválidos en funcion UPDATE");
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
                    throw new CustomException("Error", "Valores inválidos en funcion QUERY");
                }
            }
        }
        
        return $respuesta;    
    }


    public function postHome(Request $request){
        $respuesta = [];
        
        try{
            if(!$request->hasFile('entrada')){
               return view('home', [
                        'status' => 0, 
                        'respuesta' => $respuesta ,
                        'mensaje' => "No se pudo encontrar el archivo"]);
            }
            
            $entrada=$request->file('entrada');
            $data = file($entrada);

            $testCases = $this->leerLinea($data);
            
            if($testCases < 0 || $testCases > 50){ //Validacion rango T
                throw new CustomException("Error", "Valor inválidos de T");
            }

            for ($t = 1; $t <= $testCases; $t++) { //Ejecucion de operaciones
                $dataMatrix = explode(" ", $this->leerLinea($data));
                $n = $dataMatrix[0];
                $m = $dataMatrix[1];
                
                $respuesta[] = $this->realizarOperaciones($n, $m, $data);
            }
            
             return view('home', [
                        'status' => 1, 
                        'respuesta' => $respuesta ,
                        'mensaje' => ""]);
            //return json_encode(['status' => 1, 'respuesta' => $respuesta]);

        }catch(\Exception $e){
            $mensaje = "Ha ocurrido un error. Verifique qla correcta estructura del archivo";
            
            if ($e instanceof CustomException) {
                $mensaje = $e->getMessage();
            }
            
            return view('home', [
                        'status' => -1, 
                        'respuesta' => $respuesta ,
                        'mensaje' => ""]);
            //return json_encode(['status' => -1, 'respuesta' => $respuesta, 'mensaje' => $mensaje]);
        } 
    }

}