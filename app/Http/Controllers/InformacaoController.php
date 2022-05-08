<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informacao;
use Illuminate\Support\Facades\Storage;

class InformacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Informacao::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Informacao::find($id);
        return json_encode($info);
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
        $dados = json_decode($request->dados, true);
        $info = Informacao::find($id);

        if($request->hasFile('arquivo')){
            $arquivo = $request->file('arquivo');
            $extensao = strtolower($arquivo->getClientOriginalExtension());
            if(in_array($extensao, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg'])){  
                if(env('APP_ENV') == 'local'){
                    $path = $arquivo->store('imagemHome', 'public');
                    Storage::disk('public')->delete($info->urlImagem);
                } else {                    
                    $path = $arquivo->store('imagemHome');
                    Storage::delete($info->urlImagem);
                }                  
                $dados['urlImagem'] = $path;                                     
            }
        } 
  
        $info->update($dados);
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
