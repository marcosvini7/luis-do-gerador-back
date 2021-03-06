<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Servico;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Servico::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $servico = json_decode($request->dados, true);
       
       if($request->hasFile('arquivo')) {
          $arquivo = $request->file('arquivo');
          $extensao = strtolower($arquivo->getClientOriginalExtension());
          if(in_array($extensao, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'ico'])){
            if(env('APP_ENV') == 'local'){
                $path = $arquivo->store('imagensServicos', 'public');
            } else {                    
                $path = $arquivo->store('imagensServicos');
            }                  
            $servico['urlImagem'] = $path;
          }
       }
       Servico::create($servico);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servico = Servico::find($id);
        return json_encode($servico);
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
        $servico = Servico::find($id);
        if($request->hasFile('arquivo')){
            $arquivo = $request->file('arquivo');
            $extensao = strtolower($arquivo->getClientOriginalExtension());
            if(in_array($extensao, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'ico'])){
                if(env('APP_ENV') == 'local'){
                    $path = $arquivo->store('imagensServicos', 'public');
                    Storage::disk('public')->delete($servico->urlImagem);
                } else {                    
                    $path = $arquivo->store('imagensServicos');
                    Storage::delete($servico->urlImagem);
                }                  
                $dados['urlImagem'] = $path;
            }
        } 
  
        $servico->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servico $servico)
    {
        if(env('APP_ENV') == 'local'){
            Storage::disk('public')->delete($servico->urlImagem);
        } else {                    
            Storage::delete($servico->urlImagem);
        }                  
        $servico->delete();
    }
}
