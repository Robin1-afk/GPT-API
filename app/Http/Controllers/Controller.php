<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use OpenAI;

class Controller extends BaseController
{
    //Conexion API GPT
    public function GPT($request){

        $client = $this->gtpConfig();
        $response  = $client->completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $request,
            
            /*De querer hacer peticiones mas grandes deben extender el max_tokens*/
            'max_tokens' => 1500,
            'temperature' => 0
        ]);

        return $response;
    }

    
    // Configuracion GPT
    private function gtpConfig()
    {
        $apiKey = getenv('OPEN_API_KEY');

        $guzzleClient = $client = new Client([
            'base_uri' => 'api.openai.com/v1',
            'verify' => base_path('cacert.pem'),
            'timeout'  => 60000,
        ]);

        return OpenAI::factory()
            ->withApiKey($apiKey)
            ->withOrganization(null)
            ->withHttpClient($guzzleClient)
            ->make();
    }
}
