<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function indexAll(){

        $response = Company::all();
        return $response;
    }

    public function chat(){

        //Se consultan los usuarios y correos existentes en BD
        $User = new UserController;
        $Users = $User->indexMail();

        foreach ($Users as $item) {
            $id_user[] = $item['id'];
        }

        $message = "¿Puedes generar 4 nombres de compañias, 4 nombres de localizacion y 4 nombres de industrias. Todo en formato JSON que toda la respuesta este dentro de Company[]";
        $response = $this->GPT($message);
        $choices = $response->choices;

        // Verifica si hay opciones disponibles
        if (!empty($choices)) {
            // Supongamos que la primera opción contiene el array de company
            $primerChoice = $choices[0];

            // Verifica si la opción tiene la company "text"
            if (property_exists($primerChoice, 'text')) {
                // Decodifica el JSON dentro de la company "text"
                $jsonText = json_decode($primerChoice->text);

                // Verifica si el JSON tiene la company "company"
                if (property_exists($jsonText, 'companies')) {
                    // Accede a la lista de company
                    $company = $jsonText->companies;
                    // Accede a cada persona en el array
                    foreach ($company as $index => $companys) {
                        // Accede a los atributos de cada persona
                        $nombre = $companys->nombre;
                        $location = $companys->localizacion;
                        $industry = $companys->industria;
                        $user_id = $id_user[$index];

                        $user = new Company();
                        $user->name = $nombre;
                        $user->location = $location;
                        $user->industry = $industry;
                        $user->user_id = $user_id;

                        $user->save();

                        // Haz lo que necesites con la información de cada persona
                        echo "Se inserto de forma exitosa a la BD ";
                        echo "Nombre: $nombre, location: $location, Industria: $industry\n";
                    }
                } else {
                    echo "El JSON no tiene la company 'company'.\n";
                }
            } else {
                echo "La opción no tiene la company 'text'.\n";
            }
        } else {
            echo "No hay opciones disponibles en la respuesta.\n";
        }
    }
}
