<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OpenAI;

class UserController extends Controller


{

    public function indexAll(){

        $response = User::all();
        return $response;
    }
    

    public function indexMail()
    {
        $response = User::select('id', 'name', 'email')->get()->toArray();
        $emails = [];
        foreach ($response as $item) {
            // Agrega cada correo electrónico al array $emails
            $details[] = [
                'id' => $item['id'],
                'email' => $item['email']
            ];
        }

        return $details;
    }


    public function chat(Request $request)
    {
        //Se consultan los usuarios y correos existentes en BD
        $valores = $this->indexMail();

        $emails = [];

        foreach ($valores as $item) {
            $emails[] = $item['email'];
            $id_user[] = $item['id'];
        }

        $correos = implode(', ', $emails);

        if(empty($correos)){
            $correos = 'admin@gmail.com';
        }
        //Se formula la pregunta para insertar los correos y nombre de usuarios y que no se repitan
        $message = "¿Puedes generar 4 correos electrónicos que no sean repetidos y que no incluyan el correo ".$correos." y 4 nombres, Todo en formato JSON que toda la respuesta este dentro de personas[]";

        $response = $this->GPT($message);
        // Accede a la propiedad "choices" del objeto de respuesta
        $choices = $response->choices;

        // Verifica si hay opciones disponibles
        if (!empty($choices)) {
            // Supongamos que la primera opción contiene el array de personas
            $primerChoice = $choices[0];

            // Verifica si la opción tiene la propiedad "text"
            if (property_exists($primerChoice, 'text')) {
                // Decodifica el JSON dentro de la propiedad "text"
                $jsonText = json_decode($primerChoice->text);

                // Verifica si el JSON tiene la propiedad "personas"
                if (property_exists($jsonText, 'personas')) {
                    // Accede a la lista de personas
                    $personas = $jsonText->personas;
                    // Accede a cada persona en el array
                    foreach ($personas as $persona) {
                        // Accede a los atributos de cada persona
                        $nombre = $persona->nombre;
                        $correo = $persona->correo;

                        $user = new User();
                        $user->name = $nombre;
                        $user->email = $correo;
                        $user->save();

                        // Haz lo que necesites con la información de cada persona
                        echo "Se inserto de forma exitosa a la BD ";
                        echo "Nombre: $nombre, Correo: $correo\n";
                    }
                } else {
                    echo "El JSON no tiene la propiedad 'personas'.\n";
                }
            } else {
                echo "La opción no tiene la propiedad 'text'.\n";
            }
        } else {
            echo "No hay opciones disponibles en la respuesta.\n";
        }

        /** Seguidamente se hace la insercion en la tabla de companies */
        
    }


}
