<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncryptRequest;
use App\Models\Encrypt;
use Illuminate\Http\Request;

class EncryptController extends Controller
{
    //Responsavel por criar as carteiras com o saldo
    public function postCardBalance(EncryptRequest $request)
    {
        $document = \encrypt($request->userDocument);
        $token = \encrypt($request->creditCardToken);
        $value = $request->value;

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

    public function BuyItem(EncryptRequest $request){

        $CardData = Encrypt::where('id', $request->id)->first();
        $document = decrypt ($CardData->userDocument);
        $token = decrypt($CardData->creditCardToken);
        if($document != $request->userDocument && $token != $request->creditCardToken){
            return response ()->json ([
                'success' => false,
                'message' => 'Credenciais incorretas'
            ]);
        }
        $value = $CardData->value;
        if (($value - $request->value) > 0){
            return response ()->json ([
                'success' => false,
                'message' => 'Saldo insuficiente'
            ]);
        }

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
