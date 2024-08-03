<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncryptRequest;
use App\Models\Encrypt;
use Illuminate\Http\Request;

class EncryptController extends Controller
{
    public function postCard(EncryptRequest $request){

        $document = $request->userDocument;
        $card = $request->creditCardToken;
        $value = $request->value;
        $Encrypt = new Encrypt();
        $Encrypt->userDocument = $document;
        $Encrypt->creditCardToken = $card;
        $Encrypt->value = $value;
        $Encrypt->save();

    }
}
