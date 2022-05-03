<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pesquisa = $request->get('pesquisa');     
        $produtos = Produto::where('nome', 'like', '%' . $pesquisa . '%')
            ->orWhere('descricao', 'like', '%' . $pesquisa . '%')
            ->get();
        return json_encode($produtos);      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
       $produto = json_decode($request->dados, true);
       
       if($request->hasFile('arquivo')) {
          $arquivo = $request->file('arquivo');
          $extensao = strtolower($arquivo->getClientOriginalExtension());
          if(in_array($extensao, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'ico'])){
              $path = $arquivo->store('imagensProdutos', 'public');
              $produto['urlImagem'] = $path;
          }
       }
       Produto::create($produto);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::find($id);
        return json_encode($produto);
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
        $produto = Produto::find($id);
        if($request->hasFile('arquivo')){
            $arquivo = $request->file('arquivo');
            $extensao = strtolower($arquivo->getClientOriginalExtension());
            if(in_array($extensao, ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'ico'])){
                $path = $arquivo->store('imagensProdutos', 'public');
                $dados['urlImagem'] = $path;
                Storage::disk('public')->delete($produto->urlImagem);
            }
        } 
  
        $produto->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        Storage::disk('public')->delete($produto->urlImagem);
        $produto->delete();
    }
}
