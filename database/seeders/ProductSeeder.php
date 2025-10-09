<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            // PRODUCTOS EXISTENTES (los que ya tenías)
            [
                'name' => 'Filtro de Aceite',
                'description' => 'Filtro de aceite de alta calidad para todo tipo de vehículos',
                'price' => 15.99,
                'stock' => 100,
                'image' => 'filtro-aceite.jpg',
                'category_id' => 1, // Motor
                'brand' => 'Bosch',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pastillas de Freno',
                'description' => 'Pastillas de freno delanteras para sedanes',
                'price' => 45.50,
                'stock' => 50,
                'image' => 'pastillas-freno.jpg',
                'category_id' => 2, // Frenos
                'brand' => 'Brembo',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Batería 12V',
                'description' => 'Batería de 12V 60Ah para automóviles',
                'price' => 89.99,
                'stock' => 30,
                'image' => 'bateria-12v.jpg',
                'category_id' => 5, // Eléctrico
                'brand' => 'ACDelco',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Amortiguadores Delanteros',
                'description' => 'Amortiguadores delanteros para camionetas',
                'price' => 120.00,
                'stock' => 20,
                'image' => 'amortiguadores.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Monroe',
                'vehicle_type' => 'Camioneta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // NUEVOS PRODUCTOS - SUSPENSIÓN (Categoría 4)
            [
                'name' => 'Amortiguadores Traseros Toyota Corolla',
                'description' => 'Amortiguadores traseros de gas para Toyota Corolla 2014-2019',
                'price' => 85.99,
                'stock' => 12,
                'image' => 'amortiguadores-traseros-toyota.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Monroe',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit 4 Amortiguadores Honda Civic Completo',
                'description' => 'Kit completo de 4 amortiguadores para Honda Civic 2012-2015',
                'price' => 320.99,
                'stock' => 6,
                'image' => 'kit-amortiguadores-honda.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'KYB',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Rótula Suspensión Delantera Hyundai Tucson',
                'description' => 'Rótula de suspensión delantera original Hyundai Tucson 2010-2015',
                'price' => 45.99,
                'stock' => 18,
                'image' => 'rotula-hyundai.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Moog',
                'vehicle_type' => 'SUV',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Terminal de Dirección Toyota Hilux',
                'description' => 'Terminal de dirección para Toyota Hilux 2015-2020',
                'price' => 52.50,
                'stock' => 15,
                'image' => 'terminal-direccion-toyota.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'TRW',
                'vehicle_type' => 'Camioneta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Brazos de Suspensión Delanteros Chevrolet Spark',
                'description' => 'Brazos de control delanteros izquierdo y derecho Chevrolet Spark',
                'price' => 125.99,
                'stock' => 8,
                'image' => 'brazos-suspension-chevrolet.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'ACDelco',
                'vehicle_type' => 'Hatchback',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Buje Barra Estabilizadora Ford Focus',
                'description' => 'Buje de barra estabilizadora delantera Ford Focus 2012-2018',
                'price' => 28.99,
                'stock' => 25,
                'image' => 'buje-estabilizadora-ford.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Lemforder',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Completo Suspensión Delantera Nissan Versa',
                'description' => 'Kit completo suspensión delantera incluye rotulas, terminales y bujes',
                'price' => 189.99,
                'stock' => 5,
                'image' => 'kit-suspension-nissan.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Febi',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Resorte Suspensión Trasero Kia Sportage',
                'description' => 'Resorte o muelle de suspensión trasero Kia Sportage 2016-2020',
                'price' => 65.75,
                'stock' => 10,
                'image' => 'resorte-kia.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Sachs',
                'vehicle_type' => 'SUV',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Barra Estabilizadora Delantera Volkswagen Golf',
                'description' => 'Barra estabilizadora delantera completa Volkswagen Golf 2013-2017',
                'price' => 95.99,
                'stock' => 7,
                'image' => 'barra-estabilizadora-vw.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'TRW',
                'vehicle_type' => 'Hatchback',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Silentblock Suspensión Mazda 3',
                'description' => 'Kit de silentblocks y bujes para suspensión Mazda 3 2014-2019',
                'price' => 42.50,
                'stock' => 20,
                'image' => 'silentblocks-mazda.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Lemforder',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Amortiguador Trasero Gas Chevrolet Captiva',
                'description' => 'Amortiguador trasero de gas para Chevrolet Captiva 2011-2015',
                'price' => 78.99,
                'stock' => 9,
                'image' => 'amortiguador-captiva.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Monroe',
                'vehicle_type' => 'SUV',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Rótula Suspensión Trasera Toyota Fortuner',
                'description' => 'Rótula de suspensión trasera para Toyota Fortuner 2015-2020',
                'price' => 55.99,
                'stock' => 11,
                'image' => 'rotula-trasera-toyota.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Moog',
                'vehicle_type' => 'SUV',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Cremallera de Dirección Renault Logan',
                'description' => 'Kit completo cremallera de dirección para Renault Logan 2014-2019',
                'price' => 145.99,
                'stock' => 4,
                'image' => 'cremallera-renault.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'TRW',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bomba de Dirección Hidráulica Hyundai Accent',
                'description' => 'Bomba de dirección hidráulica para Hyundai Accent 2010-2017',
                'price' => 135.50,
                'stock' => 6,
                'image' => 'bomba-direccion-hyundai.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Mando',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Barras de Tensión Suspensión Ford Ranger',
                'description' => 'Kit barras de tensión y soportes para Ford Ranger 2015-2020',
                'price' => 89.99,
                'stock' => 8,
                'image' => 'barras-tension-ford.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Moog',
                'vehicle_type' => 'Camioneta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Buje Horquilla Suspensión Delantera Nissan March',
                'description' => 'Buje de horquilla de suspensión delantera Nissan March 2014-2019',
                'price' => 32.99,
                'stock' => 22,
                'image' => 'buje-horquilla-nissan.jpg',
                'category_id' => 4, // Suspensión
                'brand' => 'Febi',
                'vehicle_type' => 'Hatchback',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aceite Motor 5W-30',
                'description' => 'Aceite sintético 5W-30 1 litro',
                'price' => 12.75,
                'stock' => 200,
                'image' => 'aceite-motor.jpg',
                'category_id' => 1, // Motor
                'brand' => 'Mobil',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // NUEVOS PRODUCTOS - SISTEMA DE FRENOS (Categoría 2)
            [
                'name' => 'Disco Freno Delantero Toyota Corolla',
                'description' => 'Disco de freno delantero original para Toyota Corolla 2015-2020',
                'price' => 89.99,
                'stock' => 15,
                'image' => 'disco-freno-toyota.jpg',
                'category_id' => 2, // Frenos
                'brand' => 'Brembo',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Frenos Completo Honda Civic',
                'description' => 'Kit completo discos y pastillas delanteras Honda Civic 2012-2015',
                'price' => 189.99,
                'stock' => 8,
                'image' => 'kit-frenos-honda.jpg',
                'category_id' => 2, // Frenos
                'brand' => 'Bosch',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Líquido de Frenos DOT 4',
                'description' => 'Líquido de frenos DOT 4 500ml, alto punto de ebullición',
                'price' => 12.99,
                'stock' => 40,
                'image' => 'liquido-frenos.jpg',
                'category_id' => 2, // Frenos
                'brand' => 'Motul',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // NUEVOS PRODUCTOS - LUBRICANTES (Categoría 1 - Motor)
            [
                'name' => 'Aceite Motor 10W-40 Sintético 4L',
                'description' => 'Aceite sintético para motor, protección superior 10W-40',
                'price' => 45.99,
                'stock' => 25,
                'image' => 'aceite-10w40.jpg',
                'category_id' => 1, // Motor
                'brand' => 'Castrol',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aceite Transmisión Automática ATF',
                'description' => 'Aceite específico para transmisiones automáticas',
                'price' => 28.50,
                'stock' => 20,
                'image' => 'aceite-atf.jpg',
                'category_id' => 1, // Motor
                'brand' => 'Mobil',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anticongelante Concentrado 1 Galón',
                'description' => 'Protección contra congelamiento y sobrecalentamiento',
                'price' => 24.99,
                'stock' => 25,
                'image' => 'anticongelante.jpg',
                'category_id' => 1, // Motor
                'brand' => 'Prestone',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // NUEVOS PRODUCTOS - SISTEMA ELÉCTRICO (Categoría 5)
            [
                'name' => 'Alternador Toyota Corolla 2010-2013',
                'description' => 'Alternador original de alta eficiencia para Toyota Corolla',
                'price' => 189.99,
                'stock' => 6,
                'image' => 'alternador-toyota.jpg',
                'category_id' => 5, // Eléctrico
                'brand' => 'Denso',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Bombillos LED H4 para Faros',
                'description' => 'Bombillos LED blanca fría 6000K, fácil instalación',
                'price' => 35.99,
                'stock' => 40,
                'image' => 'bombillos-led-h4.jpg',
                'category_id' => 5, // Eléctrico
                'brand' => 'Philips',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Motor de Arranque Honda Civic',
                'description' => 'Motor de arranque de alta potencia Honda Civic 2012-2015',
                'price' => 155.99,
                'stock' => 8,
                'image' => 'motor-arranque-honda.jpg',
                'category_id' => 5, // Eléctrico
                'brand' => 'Denso',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // NUEVOS PRODUCTOS - MOTOR Y TRANSMISIÓN (Categoría 3)
            [
                'name' => 'Kit Embrague Volkswagen Gol',
                'description' => 'Kit completo de embrague para Volkswagen Gol 2010-2015',
                'price' => 189.99,
                'stock' => 5,
                'image' => 'kit-embrague-vw.jpg',
                'category_id' => 3, // Transmisión
                'brand' => 'Luk',
                'vehicle_type' => 'Hatchback',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sensor de Oxígeno Toyota Corolla',
                'description' => 'Sensor O2 original para optimizar consumo de combustible',
                'price' => 85.99,
                'stock' => 12,
                'image' => 'sensor-oxigeno.jpg',
                'category_id' => 3, // Transmisión
                'brand' => 'NGK',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit Correa Distribución Kia Rio',
                'description' => 'Kit completo correa distribución y tensores Kia Rio',
                'price' => 125.99,
                'stock' => 7,
                'image' => 'kit-correa.jpg',
                'category_id' => 3, // Transmisión
                'brand' => 'Gates',
                'vehicle_type' => 'Sedán',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // NUEVOS PRODUCTOS - ACCESORIOS (Categoría 6 - Carrocería)
            [
                'name' => 'Juego Escobillas Limpiaparabrisas',
                'description' => 'Escobillas de alta calidad 22"+18", silenciosas y eficientes',
                'price' => 25.99,
                'stock' => 30,
                'image' => 'escobillas.jpg',
                'category_id' => 6, // Carrocería
                'brand' => 'Bosch',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tapa de Rueda Aleación 15" Universal',
                'description' => 'Tapa decorativa para ruedas de aleación 15 pulgadas',
                'price' => 28.50,
                'stock' => 25,
                'image' => 'tapa-rueda.jpg',
                'category_id' => 6, // Carrocería
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Antena Corta Universal Deportiva',
                'description' => 'Antena corta para mejor recepción y estilo deportivo',
                'price' => 15.99,
                'stock' => 35,
                'image' => 'antena-corta.jpg',
                'category_id' => 6, // Carrocería
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // NUEVOS PRODUCTOS - ACCESORIOS (Categoría 7)
            [
                'name' => 'Cubre Asientos Universal Negro',
                'description' => 'Protector de asientos de tela resistente, fácil instalación',
                'price' => 45.99,
                'stock' => 20,
                'image' => 'cubre-asientos.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alfombras RubberTech para SUV',
                'description' => 'Alfombras de goma duraderas, fácil limpieza',
                'price' => 65.99,
                'stock' => 15,
                'image' => 'alfombras-goma.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'WeatherTech',
                'vehicle_type' => 'SUV/Camioneta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Porta Vasos Universal 2 Piezas',
                'description' => 'Porta vasos ajustable para consola central',
                'price' => 12.99,
                'stock' => 50,
                'image' => 'porta-vasos.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Organizador de Maletero Plegable',
                'description' => 'Organizador para maletero, múltiples compartimentos',
                'price' => 35.50,
                'stock' => 25,
                'image' => 'organizador-maletero.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'OxGord',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fundas para Volante de Cuero',
                'description' => 'Funda de cuero sintético para volante, cómodo agarre',
                'price' => 28.99,
                'stock' => 30,
                'image' => 'funda-volante.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kit de Limpieza Interior Premium',
                'description' => 'Kit completo para limpieza de interior del vehículo',
                'price' => 42.99,
                'stock' => 18,
                'image' => 'kit-limpieza.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Meguiars',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Soporte para Teléfono Magnético',
                'description' => 'Soporte magnético para smartphone, fuerte sujeción',
                'price' => 18.50,
                'stock' => 40,
                'image' => 'soporte-magnetico.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'iOttie',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cargador USB Doble 3.1A',
                'description' => 'Cargador rápido dual USB para encendedor',
                'price' => 15.99,
                'stock' => 35,
                'image' => 'cargador-usb.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Anker',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tapa de Sol para Parabrisas',
                'description' => 'Protector térmico para parabrisas, evita calor',
                'price' => 22.99,
                'stock' => 28,
                'image' => 'tapa-sol.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Generic',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aromatizante para Auto Lavanda',
                'description' => 'Aromatizante de larga duración, fragancia lavanda',
                'price' => 8.99,
                'stock' => 60,
                'image' => 'aromatizante.jpg',
                'category_id' => 7, // Accesorios
                'brand' => 'Little Trees',
                'vehicle_type' => 'Universal',
                'created_at' => now(),
                'updated_at' => now()
            ]
                    ]);
                }
            }