<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Matrix;


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


    public function postLeerArchivo(Request $request){
        $respuesta = [];
        
        try{
            if(!$request->hasFile('entrada')){
                return json_encode(['status' => 0, 'respuesta' => $respuesta]);
            }
            
            $entrada=$request->file('entrada');
            $data = file($entrada);

            $testCases = $this->leerLinea($data);

            for ($t = 1; $t <= $testCases; $t++) {
                $dataMatrix = explode(" ", $this->leerLinea($data));
                $n = $dataMatrix[0];
                $m = $dataMatrix[1];

                echo($m."<br>");

                for($k = 1; $k <= $m; $k++){
                    $operacion = explode(" ", $this->leerLinea($data));
                    $tipoOperacion = $operacion[0];

                    if($tipoOperacion == "UPDATE"){
                        //$matrix->update($operacion[1],$operacion[2],$operacion[3],$operacion[4]);
                    }else if($tipoOperacion == "QUERY"){
                        //$matrix->query($operacion[1],$operacion[2],$operacion[3],$operacion[4],$operacion[5]);
                    }
                    echo($tipoOperacion."<br>");
                } 
            }

            return json_encode(['status' => 1, 'respuesta' => $respuesta]);

        }catch(\Exception $e){
            return json_encode(['status' => -1, 'respuesta' => $respuesta]);
        } 
    }

}