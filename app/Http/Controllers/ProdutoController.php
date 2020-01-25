<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produtos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produtos.produto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $url = "http://localhost:5500/api/v1/produtos/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request->all());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result =  curl_exec($ch);
        $data = json_decode($result, true);

        if( curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200 ){
            return back()->with('status',"Dados salvos com sucesso");
        }else{
            // dd($data);
            $message = "";
            foreach($data[0] as $msg)
                $message = $message.' '.$msg[0];
        }

        curl_close($ch);

        return back()->withErrors($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = "http://localhost:5500/api/v1/produtos/".$id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);

        $produto = new Produto($data);

        return view('produtos.produto', compact('produto') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
