<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            // MARQUES DE LUXE PARFUMS
            [
                'name' => 'Chanel',
                'slug' => 'chanel',
                'description' => 'Maison de haute couture française fondée en 1910, symbole d\'élégance et de raffinement',
                'logo' => 'brands/chanel-logo.png',
                'website' => 'https://www.chanel.com',
                'country_origin' => 'France',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 100,
                'social_links' => json_encode([
                    'instagram' => '@chanel',
                    'facebook' => 'chanel',
                    'youtube' => 'chanel'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1910,
                    'founder' => 'Gabrielle Chanel',
                    'specialties' => ['Parfums', 'Haute Couture', 'Cosmétiques']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Dior',
                'slug' => 'dior',
                'description' => 'Maison de couture française créée en 1946, référence mondiale du luxe et de la beauté',
                'logo' => 'brands/dior-logo.png',
                'website' => 'https://www.dior.com',
                'country_origin' => 'France',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 98,
                'social_links' => json_encode([
                    'instagram' => '@dior',
                    'facebook' => 'dior',
                    'youtube' => 'dior'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1946,
                    'founder' => 'Christian Dior',
                    'specialties' => ['Parfums', 'Maquillage', 'Soins']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Tom Ford',
                'slug' => 'tom-ford',
                'description' => 'Marque de luxe américaine réputée pour ses parfums audacieux et sophistiqués',
                'logo' => 'brands/tom-ford-logo.png',
                'website' => 'https://www.tomford.com',
                'country_origin' => 'États-Unis',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 95,
                'social_links' => json_encode([
                    'instagram' => '@tomford',
                    'facebook' => 'tomford'
                ]),
                'meta_data' => json_encode([
                    'founded' => 2005,
                    'founder' => 'Tom Ford',
                    'specialties' => ['Parfums Privés', 'Maquillage', 'Mode']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Hermès',
                'slug' => 'hermes',
                'description' => 'Maison française de luxe fondée en 1837, symbole d\'excellence et d\'artisanat',
                'logo' => 'brands/hermes-logo.png',
                'website' => 'https://www.hermes.com',
                'country_origin' => 'France',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 92,
                'social_links' => json_encode([
                    'instagram' => '@hermes',
                    'facebook' => 'hermes'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1837,
                    'founder' => 'Thierry Hermès',
                    'specialties' => ['Parfums', 'Maroquinerie', 'Soie']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Yves Saint Laurent',
                'slug' => 'yves-saint-laurent',
                'description' => 'Maison de couture française iconique, pionnière de la beauté moderne',
                'logo' => 'brands/ysl-logo.png',
                'website' => 'https://www.yslbeauty.com',
                'country_origin' => 'France',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 94,
                'social_links' => json_encode([
                    'instagram' => '@yslbeauty',
                    'facebook' => 'yslbeauty',
                    'youtube' => 'yslbeauty'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1961,
                    'founder' => 'Yves Saint Laurent',
                    'specialties' => ['Parfums', 'Maquillage', 'Mode']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],

            // MARQUES PARFUMS MOYEN GAMME
            [
                'name' => 'Hugo Boss',
                'slug' => 'hugo-boss',
                'description' => 'Marque allemande de mode et parfums, symbole d\'élégance masculine moderne',
                'logo' => 'brands/hugo-boss-logo.png',
                'website' => 'https://www.hugoboss.com',
                'country_origin' => 'Allemagne',
                'is_featured' => true,
                'is_premium' => false,
                'popularity_score' => 85,
                'social_links' => json_encode([
                    'instagram' => '@hugoboss',
                    'facebook' => 'hugoboss'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1924,
                    'founder' => 'Hugo Boss',
                    'specialties' => ['Parfums Homme', 'Mode Masculine']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Calvin Klein',
                'slug' => 'calvin-klein',
                'description' => 'Marque américaine moderne, connue pour ses parfums unisexes iconiques',
                'logo' => 'brands/calvin-klein-logo.png',
                'website' => 'https://www.calvinklein.com',
                'country_origin' => 'États-Unis',
                'is_featured' => true,
                'is_premium' => false,
                'popularity_score' => 88,
                'social_links' => json_encode([
                    'instagram' => '@calvinklein',
                    'facebook' => 'calvinklein'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1968,
                    'founder' => 'Calvin Klein',
                    'specialties' => ['Parfums Unisexes', 'Mode', 'Sous-vêtements']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Versace',
                'slug' => 'versace',
                'description' => 'Maison italienne de haute couture, synonyme de glamour et d\'audace',
                'logo' => 'brands/versace-logo.png',
                'website' => 'https://www.versace.com',
                'country_origin' => 'Italie',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 90,
                'social_links' => json_encode([
                    'instagram' => '@versace',
                    'facebook' => 'versace'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1978,
                    'founder' => 'Gianni Versace',
                    'specialties' => ['Parfums', 'Haute Couture', 'Accessoires']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],

            // MARQUES COSMÉTIQUES
            [
                'name' => 'MAC Cosmetics',
                'slug' => 'mac-cosmetics',
                'description' => 'Marque professionnelle de maquillage, référence mondiale des make-up artists',
                'logo' => 'brands/mac-logo.png',
                'website' => 'https://www.maccosmetics.com',
                'country_origin' => 'Canada',
                'is_featured' => true,
                'is_premium' => false,
                'popularity_score' => 87,
                'social_links' => json_encode([
                    'instagram' => '@maccosmetics',
                    'facebook' => 'maccosmetics',
                    'youtube' => 'maccosmetics'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1984,
                    'founder' => 'Frank Angelo & Frank Toskan',
                    'specialties' => ['Maquillage Professionnel', 'Rouge à Lèvres', 'Fonds de Teint']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'NARS',
                'slug' => 'nars',
                'description' => 'Marque de maquillage audacieuse et innovante, créée par François Nars',
                'logo' => 'brands/nars-logo.png',
                'website' => 'https://www.narscosmetics.com',
                'country_origin' => 'France',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 83,
                'social_links' => json_encode([
                    'instagram' => '@narsissist',
                    'facebook' => 'narscosmetics'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1994,
                    'founder' => 'François Nars',
                    'specialties' => ['Blush', 'Rouge à Lèvres', 'Maquillage Artistique']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Urban Decay',
                'slug' => 'urban-decay',
                'description' => 'Marque rebelle de maquillage, pionnière des couleurs audacieuses',
                'logo' => 'brands/urban-decay-logo.png',
                'website' => 'https://www.urbandecay.com',
                'country_origin' => 'États-Unis',
                'is_featured' => false,
                'is_premium' => false,
                'popularity_score' => 78,
                'social_links' => json_encode([
                    'instagram' => '@urbandecaycosmetics',
                    'facebook' => 'urbandecay'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1996,
                    'founder' => 'Wende Zomnir',
                    'specialties' => ['Palettes Yeux', 'Eyeliner', 'Maquillage Rock']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],

            // MARQUES SOINS
            [
                'name' => 'La Mer',
                'slug' => 'la-mer',
                'description' => 'Marque de soins de luxe, légendaire pour sa Crème de la Mer',
                'logo' => 'brands/la-mer-logo.png',
                'website' => 'https://www.cremedelamer.com',
                'country_origin' => 'États-Unis',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 89,
                'social_links' => json_encode([
                    'instagram' => '@cremedelamer',
                    'facebook' => 'cremedelamer'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1965,
                    'founder' => 'Dr. Max Huber',
                    'specialties' => ['Soins Anti-âge', 'Crèmes Luxe', 'Sérums']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'SK-II',
                'slug' => 'sk-ii',
                'description' => 'Marque japonaise de soins prestigieuse, innovante en biotechnologie',
                'logo' => 'brands/sk-ii-logo.png',
                'website' => 'https://www.sk-ii.com',
                'country_origin' => 'Japon',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 86,
                'social_links' => json_encode([
                    'instagram' => '@skii',
                    'facebook' => 'skii'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1980,
                    'specialties' => ['Essence Faciale', 'Soins Premium', 'Biotechnologie']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Clinique',
                'slug' => 'clinique',
                'description' => 'Marque dermatologique de référence, pionnière des soins sur mesure',
                'logo' => 'brands/clinique-logo.png',
                'website' => 'https://www.clinique.com',
                'country_origin' => 'États-Unis',
                'is_featured' => false,
                'is_premium' => false,
                'popularity_score' => 80,
                'social_links' => json_encode([
                    'instagram' => '@clinique',
                    'facebook' => 'clinique'
                ]),
                'meta_data' => json_encode([
                    'founded' => 1968,
                    'specialties' => ['Soins Dermatologiques', 'Nettoyants', 'Hydratants']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],

            // MARQUES ÉMERGENTES/NICHE
            [
                'name' => 'Byredo',
                'slug' => 'byredo',
                'description' => 'Maison de parfums suédoise moderne, créative et minimaliste',
                'logo' => 'brands/byredo-logo.png',
                'website' => 'https://www.byredo.com',
                'country_origin' => 'Suède',
                'is_featured' => true,
                'is_premium' => true,
                'popularity_score' => 75,
                'social_links' => json_encode([
                    'instagram' => '@byredo',
                    'facebook' => 'byredo'
                ]),
                'meta_data' => json_encode([
                    'founded' => 2006,
                    'founder' => 'Ben Gorham',
                    'specialties' => ['Parfums Niche', 'Bougies', 'Soins Corps']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Le Labo',
                'slug' => 'le-labo',
                'description' => 'Parfumerie artisanale new-yorkaise, fraîcheur et authenticité',
                'logo' => 'brands/le-labo-logo.png',
                'website' => 'https://www.lelabofragrances.com',
                'country_origin' => 'États-Unis',
                'is_featured' => false,
                'is_premium' => true,
                'popularity_score' => 70,
                'social_links' => json_encode([
                    'instagram' => '@lelabofragrances',
                    'facebook' => 'lelabofragrances'
                ]),
                'meta_data' => json_encode([
                    'founded' => 2006,
                    'founder' => 'Fabrice Penot & Edouard Roschi',
                    'specialties' => ['Parfums Artisanaux', 'Soins Corps', 'Bougies']
                ]),
                'is_active' => true,
                'products_count' => 0,
            ],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert(array_merge($brand, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Brands seedées avec succès!');
    }
}