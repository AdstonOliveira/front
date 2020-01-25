<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
// use GuzzleHttp\Client;

class ClienteController extends Controller
{
    public function index(){

        return view('clientes.index');
    }

    public function show($id){

        $url = "http://localhost:5500/api/v1/clientes/".$id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);

        $cliente = new Cliente($data);

        return view('clientes.cliente', compact('cliente') );
    }


    public function novo(){

        return view('clientes.cliente');
    }

    public function save(Request $request){

        $url = "http://localhost:5500/api/v1/clientes/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request->all());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec($ch);
        $data = json_decode($result, true);


        if( curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200 ){
            return back()->with('status',"Dados salvos com sucesso");
        }else{
            $message = "";
            foreach($data[0] as $msg)
                $message = $message.' '.$msg[0];
        }

        curl_close($ch);

        return back()->withErrors($message);
    }



}
