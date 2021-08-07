<?php

namespace App\Http\Controllers;

use App\Codes\Models\Accurate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AccurateController extends Controller
{
    protected $request;

    protected $input;

    protected $http;

    public function __construct(Request $request, Client $client)
    {
        $this->request = $request;
        $this->input = $request->all();
        $this->http = $client;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callback()
    {

        $response = Http::withHeaders([
                'Authorization' => "Basic " . base64_encode(env("ACCURATE_CLIENT_ID") . ":" . env("ACCURATE_CLIENT_SECRET")),
                ])->asForm()
                    ->post(env('ACCURATE_URL_OAUTH'), [
                        'code' => $this->input['code'],
                        'grant_type' => "authorization_code",
                        "redirect_uri" => env('ACCURATE_URL_CALLBACK'),
                    ]);

        return $response;

//        if ($response->failed()){
//
//            abort(404);
//
//        }
//
//        $responseBody = $response->json();
//
//        Accurate::create([
//            "access_token" => $responseBody['access_token'],
//            "token_type" => $responseBody['token_type'],
//            "refresh_token" => $responseBody['token_type'],
//            "expires_in" => $responseBody['expires_in'],
//            "scope" => $responseBody['scope'],
//            "name" => $responseBody['user']['name'],
//            "email" => $responseBody['user']['email']
//        ]);

        return back();
    }
}
