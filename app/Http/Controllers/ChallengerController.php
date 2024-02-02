<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengerController extends Controller
{

    public function indexAll(){

        $response = Challenge::all();
        return $response;
    }

    public function chat(Request $request)
    {
        //Se consultan los usuarios y correos existentes en BD
        $User = new UserController;
        $Users = $User->indexMail();

        foreach ($Users as $item) {
            $id_user[] = $item['id'];
        }

        //Se formula la pregunta para insertar los correos y nombre de usuarios y que no se repitan
        $message = "Generar 4 titulos de desafios, 4 descripcion de esos desafios y un nivel de dificultad del 1 al 10. Todo en formato JSON que toda la respuesta este dentro de challenge[]";

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
                if (property_exists($jsonText, 'challenge')) {
                    // Accede a la lista de personas
                    $challenge = $jsonText->challenge;
                    // Accede a cada persona en el array
                    foreach ($challenge as $index =>  $challenges) {
                        // Accede a los atributos de cada persona
                        $titulo = $challenges->titulo;
                        $descripcion = $challenges->descripcion;
                        $dificultad = $challenges->dificultad;
                        $user_id = $id_user[$index];

                        $challenges = new Challenge();
                        $challenges->title = $titulo;
                        $challenges->description = $descripcion;
                        $challenges->difficulty = $dificultad;
                        $challenges->user_id = $user_id;

                        $challenges->save();

                        // Haz lo que necesites con la información de cada persona
                        echo "Se inserto de forma exitosa a la BD ";
                        echo "Nombre: $challenges, Descripcion: $challenges, Dificultad-> $dificultad\n";
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
