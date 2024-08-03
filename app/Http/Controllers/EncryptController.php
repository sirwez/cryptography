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
        $card = \encrypt($request->creditCardToken);
        $value = $request->value;

        // Criar uma nova instância do modelo Encrypt e salvar os dados
        $encrypt = new Encrypt();
        $encrypt->userDocument = $document;
        $encrypt->creditCardToken = $card;
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

}
