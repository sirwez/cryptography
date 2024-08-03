<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncryptRequest;
use App\Models\Encrypt;
use Illuminate\Http\Request;

class EncryptController extends Controller
{
    public function postCard(EncryptRequest $request)
    {
        // Criptografar o documento do usuário e o token do cartão de crédito
        $document = \encrypt($request->userDocument);
        $token = \encrypt($request->creditCardToken);
        $value = $request->value;

        // Criar uma nova instância do modelo Encrypt e salvar os dados
        $encrypt = new Encrypt();
        $encrypt->userDocument = $document;
        $encrypt->creditCardToken = $token;
        $encrypt->value = $value;
        $encrypt->save();

        // Retornar uma resposta JSON
        return response()->json([
            'success' => true,
            'message' => 'Dados criptografados e salvos com sucesso.',
            'data' => [
                'userDocument' => $encrypt->userDocument,
                'userDocumentt' => decrypt($document),
            ]
        ], 201);
    }

    public function getCard(Request $request){
        $validatedData = $request->validate ([
            'id' => 'required|numeric'
        ]);
        $CardData = Encrypt::where('id', $validatedData['id'])->first();
        $document = decrypt ($CardData->userDocument);
        $token = decrypt($CardData->creditCardToken);
        $value = $CardData->value;
        return response ()->json ([
            'success' => true,
            'message' => 'Dados descriptografados com sucesso.',
            'data' => [
                'document' => $document,
                'token' => $token ,
                'value' => $value
            ]
        ]);
    }
}
