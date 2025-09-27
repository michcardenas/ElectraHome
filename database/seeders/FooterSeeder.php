<?php
// database/seeders/FooterSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Section;

class FooterSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear la página footer
        $footerPage = Page::firstOrCreate(
            ['slug' => 'footer'],
            [
                'title' => 'Footer del Sitio Web',
                'section' => 'footer',
                'content' => 'Tu tienda especializada en electrodomésticos de calidad. Ofrecemos las mejores marcas con garantía, servicio técnico especializado y atención personalizada.'
            ]
        );

        // 2. Definir las secciones
        $sections = [
            [
                'name' => 'social_links',
                'title' => 'Redes Sociales',
                'content' => 'Enlaces a redes sociales y datos de la empresa',
                'order' => 1,
                'custom_data' => [
                    'company_name' => 'ElectraHome',
                    'main_email' => 'info@electrahome.com',
                    'facebook_url' => '',
                    'instagram_url' => '',
                    'whatsapp_number' => ''
                ]
            ],
            [
                'name' => 'services_links',
                'title' => 'Navegación',
                'content' => 'Enlaces de navegación y categorías',
                'order' => 2,
                'custom_data' => [
                    'nav_inicio' => 'Inicio',
                    'nav_productos' => 'Productos',
                    'nav_about' => 'Quiénes Somos',
                    'nav_contacto' => 'Contacto',
                    'nav_servicios' => 'Servicios',
                    'cat_licuadoras' => 'Licuadoras',
                    'cat_freidoras' => 'Freidoras de Aire',
                    'cat_sanducheras' => 'Sanducheras',
                    'cat_pequenos' => 'Pequeños Electrodomésticos'
                ]
            ],
            [
                'name' => 'contact_info',
                'title' => 'Información de Contacto',
                'content' => 'Datos de contacto y horarios',
                'order' => 3,
                'custom_data' => [
                    'contact_email' => 'info@electrahome.com',
                    'contact_phone' => '+58 (412) 123-4567',
                    'contact_address' => '',
                    'hours_weekdays' => '8:00 AM - 6:00 PM',
                    'hours_saturday' => '8:00 AM - 4:00 PM',
                    'hours_sunday' => 'Cerrado'
                ]
            ],
            [
                'name' => 'legal_info',
                'title' => 'Información Legal',
                'content' => 'Copyright y certificaciones',
                'order' => 4,
                'custom_data' => [
                    'copyright_text' => 'ElectraHome. Todos los derechos reservados.',
                    'cert_warranty' => 'Garantía Oficial',
                    'cert_service' => 'Servicio Técnico',
                    'cert_quality' => 'Calidad Certificada'
                ]
            ]
        ];

        // 3. Crear las secciones
        foreach ($sections as $sectionData) {
            Section::firstOrCreate(
                [
                    'page_id' => $footerPage->id,
                    'name' => $sectionData['name']
                ],
                [
                    'title' => $sectionData['title'],
                    'content' => $sectionData['content'],
                    'order' => $sectionData['order'],
                    'is_active' => true,
                    'custom_data' => $sectionData['custom_data']
                ]
            );
        }

        $this->command->info('Footer page y secciones creadas exitosamente.');
    }
}