<?php

namespace App\Http\Controllers;

use App\Models\Criptomoedas;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CriptomoedasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regCriptos = Criptomoedas::All();
        $contador = $regCriptos->count();

        return Response()->json($regCriptos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $registros = Criptomoedas::create($request->all());

        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda cadastrada com sucesso',
                'data' => $registros
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'erro ao cadastrar a criptomoeda'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Criptomoedas $criptomoedas)
    {
        #conferir a digitação
        $regCriptos = Criptomoedas::find($id);

        if ($regCriptos){
            return 'Criptomoedas Localizadas:'.$regCriptos.Response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return 'Criptomoedas não localizadas'.Response()->json([],Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criptomoedas $criptomoedas)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $regCriptosBanco = Criptomoedas::find($id);

        if (!$regCriptosBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Criptomoeda não encontrada'
            ], 400);
        }

        $regCriptosBanco->Sigla = $request->Sigla;
        $regCriptosBanco->Nome = $request->Nome;
        $regCriptosBanco->Valor = $request->Valor;

        if ($regCriptosBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda atualizada com sucesso',
                'data' => $regCriptosBanco
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'erro ao atualizar a criptomoeda'
            ], 500);
        }
    }
    
            
        
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criptomoedas $criptomoedas)
    {
        $regCriptos = Criptomoedas::find($id);

        if (!$regCriptos) {
            return response()->json([
                'success' => false,
                'message' => 'criptomoedas não encontrada'
            ], 404);
        }

        if ($regCriptos->delete()) {
            return response()->json([
                'success' => false,
                'message' => 'criptomoeda delteda com sucesso'
            ], 200);
        }
    }
}
