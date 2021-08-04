<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccurateController extends Controller
{
    protected $request;

    protected $input;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->input = $request->all();
    }

    public function connect(){

        return $response = Http::get(env("ACCURATE_HOST", "https://accurate.id/oauth/authorize"), [
            'client_id' => env('accurate_client_id'),
            'response_type' => env('accurate_response_type'),
            'redirect_uri' => env('accurate_url_callback'),
            'scope' => "item_view item_save sales_invoice_view"
        ]);

    }

    public function callback(){
//        withBasicAuth(env("ACCURATE_CLIENT_ID"), env("ACCURATE_CLIENT_SECRET"))
        return Http::contentType("application/x-www-form-urlencoded")
            ->withToken("YTZmOTVhMjUtOGVjNy00OTVjLTg5YTktZGQ0ZjMyZWFjOTZkOmU4MzJjMzliYjE4YzU4YjVjMmFmYjA1MmQ1MjExZTBj", "Basic")
//        withHeaders([
//            "Content-Type" => "application/x-www-form-urlencoded",
//            "Authorization" => "Basic YTZmOTVhMjUtOGVjNy00OTVjLTg5YTktZGQ0ZjMyZWFjOTZkOmU4MzJjMzliYjE4YzU4YjVjMmFmYjA1MmQ1MjExZTBj"
//        ])->
            ->post("https://account.accurate.id/oauth/token", [
//                "code" => "SZyKcCY5c8sIi8Nbnglh",
//                "grant_type" => "authorization_code",
//                "redirect_uri" => "http://stock.beliayam.test/accurate/callback",
            ]);

        return $response;
    }

    public function oauthCallback(){

        return "wlkw";
    }
}
