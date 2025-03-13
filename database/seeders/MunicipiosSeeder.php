<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipio;
use Carbon\Carbon;

class MunicipiosSeeder extends Seeder
{
    public function run(): void
    {
        $municipios = [
            ['nombre' => 'Acatlán', 'cp' => '43540'],
            ['nombre' => 'Acaxochitlán', 'cp' => '43720'],
            ['nombre' => 'Actopan', 'cp' => '42500'],
            ['nombre' => 'Agua Blanca de Iturbide', 'cp' => '43460'],
            ['nombre' => 'Ajacuba', 'cp' => '42150'],
            ['nombre' => 'Alfajayucan', 'cp' => '42390'],
            ['nombre' => 'Almoloya', 'cp' => '43940'],
            ['nombre' => 'Apan', 'cp' => '43900'],
            ['nombre' => 'El Arenal', 'cp' => '42680'],
            ['nombre' => 'Atitalaquia', 'cp' => '42970'],
            ['nombre' => 'Atlapexco', 'cp' => '43060'],
            ['nombre' => 'Atotonilco de Tula', 'cp' => '42980'],
            ['nombre' => 'Atotonilco el Grande', 'cp' => '43300'],
            ['nombre' => 'Calnali', 'cp' => '43230'],
            ['nombre' => 'Cardonal', 'cp' => '42370'],
            ['nombre' => 'Cuautepec de Hinojosa', 'cp' => '43740'],
            ['nombre' => 'Chapantongo', 'cp' => '42900'],
            ['nombre' => 'Chapulhuacán', 'cp' => '42280'],
            ['nombre' => 'Chilcuautla', 'cp' => '42750'],
            ['nombre' => 'Eloxochitlán', 'cp' => '43330'],
            ['nombre' => 'Emiliano Zapata', 'cp' => '43960'],
            ['nombre' => 'Epazoyucan', 'cp' => '43580'],
            ['nombre' => 'Francisco I. Madero', 'cp' => '42660'],
            ['nombre' => 'Huasca de Ocampo', 'cp' => '43500'],
            ['nombre' => 'Huautla', 'cp' => '43050'],
            ['nombre' => 'Huazalingo', 'cp' => '43070'],
            ['nombre' => 'Huehuetla', 'cp' => '43420'],
            ['nombre' => 'Huejutla de Reyes', 'cp' => '43000'],
            ['nombre' => 'Huichapan', 'cp' => '42400'],
            ['nombre' => 'Ixmiquilpan', 'cp' => '42300'],
            ['nombre' => 'Jacala de Ledezma', 'cp' => '42200'],
            ['nombre' => 'Jaltocán', 'cp' => '43040'],
            ['nombre' => 'Juárez Hidalgo', 'cp' => '43190'],
            ['nombre' => 'Lolotla', 'cp' => '43140'],
            ['nombre' => 'Metepec', 'cp' => '43400'],
            ['nombre' => 'San Agustín Metzquititlán', 'cp' => '43380'],
            ['nombre' => 'Metztitlán', 'cp' => '43350'],
            ['nombre' => 'Mineral del Chico', 'cp' => '42120'],
            ['nombre' => 'Mineral del Monte', 'cp' => '42130'],
            ['nombre' => 'La Misión', 'cp' => '42260'],
            ['nombre' => 'Mixquiahuala de Juárez', 'cp' => '42700'],
            ['nombre' => 'Molango de Escamilla', 'cp' => '43100'],
            ['nombre' => 'Nicolás Flores', 'cp' => '42360'],
            ['nombre' => 'Nopala de Villagrán', 'cp' => '42470'],
            ['nombre' => 'Omitlán de Juárez', 'cp' => '43560'],
            ['nombre' => 'San Felipe Orizatlán', 'cp' => '43030'],
            ['nombre' => 'Pacula', 'cp' => '42240'],
            ['nombre' => 'Pachuca de Soto', 'cp' => '42000'],
            ['nombre' => 'Pisaflores', 'cp' => '42220'],
            ['nombre' => 'Progreso de Obregón', 'cp' => '42730'],
            ['nombre' => 'Mineral de la Reforma', 'cp' => '42180'],
            ['nombre' => 'San Agustín Tlaxiaca', 'cp' => '42160'],
            ['nombre' => 'San Bartolo Tutotepec', 'cp' => '43440'],
            ['nombre' => 'San Salvador', 'cp' => '42640'],
            ['nombre' => 'Santiago de Anaya', 'cp' => '42620'],
            ['nombre' => 'Santiago Tulantepec de Lugo Guerrero', 'cp' => '43760'],
            ['nombre' => 'Singuilucan', 'cp' => '43780'],
            ['nombre' => 'Tasquillo', 'cp' => '42380'],
            ['nombre' => 'Tecozautla', 'cp' => '42440'],
            ['nombre' => 'Tenango de Doria', 'cp' => '43480'],
            ['nombre' => 'Tepeapulco', 'cp' => '43970'],
            ['nombre' => 'Tepehuacán de Guerrero', 'cp' => '43120'],
            ['nombre' => 'Tepeji del Río de Ocampo', 'cp' => '42850'],
            ['nombre' => 'Tepetitlán', 'cp' => '42920'],
            ['nombre' => 'Tetepango', 'cp' => '42940'],
            ['nombre' => 'Villa de Tezontepec', 'cp' => '43880'],
            ['nombre' => 'Tezontepec de Aldama', 'cp' => '42760'],
            ['nombre' => 'Tianguistengo', 'cp' => '43270'],
            ['nombre' => 'Tizayuca', 'cp' => '43800'],
            ['nombre' => 'Tlahuelilpan', 'cp' => '42780'],
            ['nombre' => 'Tlahuiltepa', 'cp' => '43170'],
            ['nombre' => 'Tlanalapa', 'cp' => '43930'],
            ['nombre' => 'Tlanchinol', 'cp' => '43150'],
            ['nombre' => 'Tlaxcoapan', 'cp' => '42950'],
            ['nombre' => 'Tolcayuca', 'cp' => '43860'],
            ['nombre' => 'Tula de Allende', 'cp' => '42800'],
            ['nombre' => 'Tulancingo de Bravo', 'cp' => '43600'],
            ['nombre' => 'Xochiatipan', 'cp' => '43090'],
            ['nombre' => 'Xochicoatlán', 'cp' => '43250'],
            ['nombre' => 'Yahualica', 'cp' => '43080'],
            ['nombre' => 'Zacualtipán de Ángeles', 'cp' => '43200'],
            ['nombre' => 'Zapotlán de Juárez', 'cp' => '42190'],
            ['nombre' => 'Zempoala', 'cp' => '43830'],
            ['nombre' => 'Zimapán', 'cp' => '42330'],
        ];

        foreach ($municipios as $municipio) {
            Municipio::create([
                'nombre' => $municipio['nombre'],
                'codigo_postal' => $municipio['cp'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}