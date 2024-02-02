<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Program;
use App\Models\ProgramParticipant;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    public function indexAll(){

        $response = Program::all();
        return $response;
    }

    public function indexProgram()
    {
        $response = Program::select('id')->get()->toArray();
        foreach ($response as $item) {
            // Agrega cada correo electrónico al array $emails
            $details[] = $item['id'];
        }

        return $details;
    }
    
    public function chat(){

        $User = new UserController;
        $Users = $User->indexMail();

        foreach ($Users as $item) {
            $id_user[] = $item['id'];
        }

        $message = "¿Puedes generar 4 titulos de programas, 4 descripcion de esos programas y su fecha inicio y fin con formato mysql 'date'. Todo en formato JSON que toda la respuesta este dentro de programs[]";
        $response = $this->GPT($message);
        $choices = $response->choices; 
    
        // // Verifica si hay opciones disponibles
        if (!empty($choices)) {
            // Supongamos que la primera opción contiene el array de company
            $primerChoice = $choices[0];
            // Verifica si la opción tiene la company "text"
            if (property_exists($primerChoice, 'text')) {
                // Decodifica el JSON dentro de la company "text"
                $jsonText = json_decode($primerChoice->text);
                // Verifica si el JSON tiene la company "company"
                if (property_exists($jsonText, 'programs')) {
                    // Accede a la lista de company
                    $programs = $jsonText->programs;
                    // Accede a cada persona en el array
                    foreach ($programs as $index => $program) {
                        // Accede a los atributos de cada persona
                        $title = $program->titulo;
                        $description = $program->descripcion;
                        $start_date = $program->fecha_inicio;
                        $end_date = $program->fecha_fin;
                        $user_id = $id_user[$index];
                        
                        $program = new Program();
                        $program->title = $title;
                        $program->description = $description;
                        $program->start_date = $start_date;
                        $program->end_date = $end_date;
                        $program->user_id = $user_id;
                        // print_r($program); exit;
                        $program->save();

                        // Haz lo que necesites con la información de cada persona
                        echo "Se inserto de forma exitosa a la BD ";
                        echo "Titulo: $title, Descipcion: $description, Inicio programa: $start_date, Fin de programa: $end_date\n";
                    }
                    //Se inserta seguidamente inserProgramP
                    $this->insertProgramP();

                } else {
                    echo "El JSON no tiene la program 'program'.\n";
                }
            } else {
                echo "La opción no tiene la program 'text'.\n";
            }
        } else {
            echo "No hay opciones disponibles en la respuesta.\n";
        }
    }

    public function insertProgramP(){

        $program = $this->indexProgram();

        foreach ($program as $item) {
            $id_program[] = $item;
        }

        $message = "genera 4 tipos de entidad, 4 id unicos numericos. Todo en formato JSON que toda la respuesta este dentro de programs[]";
        $response = $this->GPT($message);
        $choices = $response->choices; 
        // // Verifica si hay opciones disponibles
        if (!empty($choices)) {
            // Supongamos que la primera opción contiene el array de company
            $primerChoice = $choices[0];
            // Verifica si la opción tiene la company "text"
            if (property_exists($primerChoice, 'text')) {
                // Decodifica el JSON dentro de la company "text"
                $jsonText = json_decode($primerChoice->text);
                // Verifica si el JSON tiene la company "company"
                if (property_exists($jsonText, 'programs')) {
                    // Accede a la lista de company
                    $programs = $jsonText->programs;
                    // Accede a cada persona en el array
                    foreach ($programs as $index => $program) {
                        // Accede a los atributos de cada persona
                        $id = $program->id;
                        $tipo = $program->tipo;
                        $user_id = $id_program[$index];
                        
                        $program = new ProgramParticipant();
                        $program->program_id = $user_id;
                        $program->entity_type = $tipo;
                        $program->entity_id = $id;
                        $program->save();

                        // Haz lo que necesites con la información de cada persona
                        echo "Se inserto de forma exitosa a la BD ";
                        echo "Tipo: $tipo, id: $id, user_id: $user_id\n";
                    }
                } else {
                    echo "El JSON no tiene la program 'program'.\n";
                }
            } else {
                echo "La opción no tiene la program 'text'.\n";
            }
        } else {
            echo "No hay opciones disponibles en la respuesta.\n";
        }
    }
    
}
