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
    public function index()
    {
        
        // Obtener todos los usuarios de la base de datos
        $users = User::all();
    
        // Consumir la API externa de GPT para cada usuario
        foreach ($users as $user) {
            // Generar un título para el desafío
            $title = $this->generateTitleFromGPT($user);
    
            // Generar una descripción para el desafío
            $description = $this->generateDescriptionFromGPT($user);
    
            // Actualizar el usuario con el título y la descripción generados
            $user->title = $title;
            $user->description = $description;
            $user->save();
        }
    
        // Devolver los usuarios
        return $users;
    }



    public function chat(Request $request)
    {
        $message = 'Creame un json que contenga los datos de 5 personas, esos datos son nombre, apellido y numero de documento, los datos de cada persona deben ser siempre diferentes. Todo en formato JSON.';
        $response = $this->GPT($message);
        // print_r($response);
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
                        $apellido = $persona->apellido;
                        $numero_documento = $persona->numero_documento;

                        // Haz lo que necesites con la información de cada persona
                        echo "Nombre: $nombre, Apellido: $apellido, Número de documento: $numero_documento\n";
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
    }


}
