<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

trait IssueTokenTrait
{
    public function issueToken(Request $request, $grantType, $scope = "*") {

        $params = [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->username ?: $request->email,
            'scope' => $scope,
        ];

        // dd($params);
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);

    }
}