<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomException;
use App\Data;

class CubeController extends Controller{

    public function home(){
        return view('home');
    }
    
    public function postHome(Request $request){
        $respuesta = [];
        $status = 0;
        $mensaje = "No se pudo encontrar el archivo";
        try{
            if($request->hasFile('entrada')){
                $data = new Data();
                $data->leerArchivo($request->file('entrada'));
                
                $respuesta = $data->procesarData();
                $mensaje = "";
                $status = 1;
            }
            
            return view('home', [
                      'status' => $status, 
                      'respuesta' => $respuesta ,
                      'mensaje' => $mensaje]);

        }catch(\Exception $e){
            $mensaje = "Ha ocurrido un error. Verifique la correcta estructura del archivo y la extensión";
            
            if ($e instanceof CustomException) {
                $mensaje = $e->getMessage();
            }
            
            return view('home', [
                        'status' => -1, 
                        'respuesta' => $respuesta ,
                        'mensaje' => $mensaje]);
        } 
    }

}