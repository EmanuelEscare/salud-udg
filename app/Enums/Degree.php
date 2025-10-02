<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self physics()
 * @method static self mathematics()
 * @method static self chemistry()
 * @method static self pharmaceutical()
 * @method static self materials_engineering()
 * @method static self civil_engineering()
 * @method static self food_biotechnology()
 * @method static self geomatic_surveying()
 * @method static self industrial_engineering()
 * @method static self mechanical_electrical()
 * @method static self chemical_engineering()
 * @method static self logistics_transport()
 * @method static self computer_engineering()
 * @method static self biomedical_engineering()
 * @method static self software_development()
 * @method static self mechatronics_engineering()
 * @method static self robotics_engineering()
 * @method static self photonics_engineering()
 * @method static self smart_mechatronics()
 * @method static self electromobility_autotronics()
 * @method static self electronics_intelligent_systems()
 * @method static self information_technologies()
 */
final class Degree extends Enum
{
    protected static function labels(): array
    {
        return [
            'physics'                        => 'Licenciatura en Física',
            'mathematics'                    => 'Licenciatura en Matemáticas',
            'chemistry'                      => 'Licenciatura en Química',
            'pharmaceutical'                 => 'Químico Farmacéutico Biólogo',
            'materials_engineering'          => 'Ingeniería en Ciencia de Materiales',
            'civil_engineering'              => 'Ingeniería Civil',
            'food_biotechnology'             => 'Ingeniería en Alimentos y Biotecnología',
            'geomatic_surveying'             => 'Ingeniería en Topografía Geomática',
            'industrial_engineering'         => 'Ingeniería Industrial',
            'mechanical_electrical'          => 'Ingeniería Mecánica Eléctrica',
            'chemical_engineering'           => 'Ingeniería Química',
            'logistics_transport'            => 'Ingeniería en Logística y Transporte',
            'computer_engineering'           => 'Ingeniería Informática',
            'biomedical_engineering'         => 'Ingeniería Biomédica',
            'software_development'           => 'Licenciatura en Desarrollo de Sistemas Web',
            'mechatronics_engineering'       => 'Ingeniería en Computación',
            'robotics_engineering'           => 'Ingeniería Robótica',
            'photonics_engineering'          => 'Ingeniería Fotónica',
            'smart_mechatronics'             => 'Ingeniería en Mecatrónica Inteligente',
            'electromobility_autotronics'    => 'Ingeniería en Electromovilidad y Autotrónica',
            'electronics_intelligent_systems' => 'Ingeniería en Electrónica y Sistemas Inteligentes',
            'information_technologies'       => 'Licenciatura en Tecnologías e Información',
        ];
    }
}
