<?php

namespace Database\Seeders;

use App\Models\ZipCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ZipCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xml = @simplexml_load_file(base_path('dataset.xml'));

        $lastZipcode = null; //Código postal de la iteración pasada.
        $currentZipcode = null; //Model created;
        $settlements = []; //settlements acumulados del código postal que se está por guardar.

        /**
         * Recorrer el archivo xml y obtener los valores de cada código postal.
         * Si el código se repite, guarda en el arreglo $settlements para guardar todo junto
         * en un solo registro.
         * 
         * Cuando el código postal ya no se repite (acumuló todos sus settlements), guarda el código postal.
         */
        foreach($xml->children() as $zipcode) {
            
            if((string) $zipcode->d_codigo != (string) $lastZipcode) {
                
                if($currentZipcode) {
                    $currentZipcode->settlements = json_encode($settlements);
                    $currentZipcode->save();
                    $settlements = [];
                }
                $currentZipcode = new ZipCode();
                $currentZipcode->zip_code = $zipcode->d_codigo ? $zipcode->d_codigo : null;
                $currentZipcode->locality = $zipcode->d_ciudad ? Str::upper($zipcode->d_ciudad) : null;
                $currentZipcode->federal_entity = json_encode([
                    'key' => (int) $zipcode->c_estado,
                    'name' => Str::upper($zipcode->d_estado),
                    'code' => null
                ]);

                $currentZipcode->municipality = json_encode([
                    'key' => (int) $zipcode->c_mnpio,
                    'name' => Str::upper($zipcode->D_mnpio)
                ]);
            }

           
            array_push($settlements, [
                'key' => ((int) $zipcode->id_asenta_cpcons),
                'name' => Str::upper($zipcode->d_asenta),
                'zone_type' => Str::upper($zipcode->d_zona),
                'settlement_type' => [
                    "name" => (string) $zipcode->d_tipo_asenta
                ]
            ]);
            
            $lastZipcode = $zipcode->d_codigo;
        }

        $currentZipcode->save(); //Guarda el último código postal que no entró en la iteración.
        
    }
}
