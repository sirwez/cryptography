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
        $documentHashData = $this->createHash($request->userDocument);
        $tokenHashData = $this->createHash($request->creditCardToken);
        $value = $request->value;

        $encrypt = new Encrypt();
        $encrypt->userDocument = $documentHashData['hash'];
        $encrypt->documentSalt = $documentHashData['salt'];
        $encrypt->creditCardToken = $tokenHashData['hash'];
        $encrypt->tokenSalt = $tokenHashData['salt'];
        $encrypt->value = $value;
        $encrypt->save();

        // Retornar uma resposta JSON
        return response()->json([
            'success' => true,
            'message' => 'Dados criptografados e salvos com sucesso.',
        ], 201);
    }

    public function BuyItem(EncryptRequest $request)
    {
        $CardData = Encrypt::where('id', $request->id)->first();

        if (!$CardData) {
            return response()->json([
                'success' => false,
                'message' => 'Dados não encontrados'
            ]);
        }

        $documentBD = $CardData->userDocument;
        $documentSalt = $CardData->documentSalt;
        $tokenBD = $CardData->creditCardToken;
        $tokenSalt = $CardData->tokenSalt;

        $documentHash = $this->createHashWithSalt($request->userDocument, $documentSalt);
        $tokenHash = $this->createHashWithSalt($request->creditCardToken, $tokenSalt);

        if ($documentBD !== $documentHash || $tokenBD !== $tokenHash) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciais incorretas'
            ]);
        }

        $value = $CardData->value;
        if (($value - $request->value) < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo insuficiente'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Compra realizada com success.',
        ]);
    }

    public function createHash(string $input)
    {
        $iterations = 600000;
        $salt = bin2hex(random_bytes(16));
        $hash = hash_pbkdf2("sha512", $input, $salt, $iterations, 64);
        return ['hash' => $hash, 'salt' => $salt];
    }

    public function createHashWithSalt(string $input, string $salt)
    {
        $iterations = 600000;
        return hash_pbkdf2("sha512", $input, $salt, $iterations, 64);
    }

}
