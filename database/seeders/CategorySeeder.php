<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // PARFUMS
            [
                'name' => 'Parfums',
                'slug' => 'parfums',
                'description' => 'Découvrez notre collection exclusive de parfums pour homme et femme',
                'image' => 'categories/parfums.jpg',
                'icon' => '🌸',
                'color' => '#8B5CF6',
                'meta_data' => json_encode([
                    'meta_title' => 'Parfums de Luxe - Collection Premium',
                    'meta_description' => 'Parfums authentiques des plus grandes marques. Livraison gratuite et garantie qualité.',
                    'keywords' => ['parfum', 'fragrance', 'eau de parfum', 'eau de toilette']
                ]),
                'parent_id' => null,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            
            // SOUS-CATÉGORIES PARFUMS
            [
                'name' => 'Parfums Femme',
                'slug' => 'parfums-femme',
                'description' => 'Collection de parfums féminins, des plus délicats aux plus intenses',
                'image' => 'categories/parfums-femme.jpg',
                'icon' => '💐',
                'color' => '#EC4899',
                'meta_data' => json_encode([
                    'meta_title' => 'Parfums Femme - Fragrances Féminines',
                    'meta_description' => 'Parfums femme de luxe : floraux, orientaux, fruités. Les plus grandes marques.',
                    'keywords' => ['parfum femme', 'fragrance féminine', 'eau de parfum femme']
                ]),
                'parent_id' => 1, // Référence à 'Parfums'
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Parfums Homme',
                'slug' => 'parfums-homme',
                'description' => 'Parfums masculins sophistiqués, des plus frais aux plus boisés',
                'image' => 'categories/parfums-homme.jpg',
                'icon' => '🌲',
                'color' => '#059669',
                'meta_data' => json_encode([
                    'meta_title' => 'Parfums Homme - Fragrances Masculines',
                    'meta_description' => 'Parfums homme de prestige : boisés, frais, épicés. Authentiques et originaux.',
                    'keywords' => ['parfum homme', 'fragrance masculine', 'eau de toilette homme']
                ]),
                'parent_id' => 1,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Parfums Unisexe',
                'slug' => 'parfums-unisexe',
                'description' => 'Fragrances mixtes pour tous les styles',
                'image' => 'categories/parfums-unisexe.jpg',
                'icon' => '⚡',
                'color' => '#7C3AED',
                'meta_data' => json_encode([
                    'meta_title' => 'Parfums Unisexe - Fragrances Mixtes',
                    'meta_description' => 'Parfums unisexe modernes et audacieux. Pour elle et lui.',
                    'keywords' => ['parfum unisexe', 'fragrance mixte', 'parfum neutre']
                ]),
                'parent_id' => 1,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => false,
                'products_count' => 0,
            ],

            // COSMÉTIQUES
            [
                'name' => 'Cosmétiques',
                'slug' => 'cosmetiques',
                'description' => 'Maquillage et cosmétiques de haute qualité',
                'image' => 'categories/cosmetiques.jpg',
                'icon' => '💄',
                'color' => '#EF4444',
                'meta_data' => json_encode([
                    'meta_title' => 'Cosmétiques de Luxe - Maquillage Premium',
                    'meta_description' => 'Maquillage et cosmétiques des plus grandes marques. Qualité professionnelle.',
                    'keywords' => ['cosmétiques', 'maquillage', 'beauté', 'makeup']
                ]),
                'parent_id' => null,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],

            // SOUS-CATÉGORIES COSMÉTIQUES
            [
                'name' => 'Maquillage Yeux',
                'slug' => 'maquillage-yeux',
                'description' => 'Mascaras, ombres à paupières, eyeliners',
                'image' => 'categories/maquillage-yeux.jpg',
                'icon' => '👁️',
                'color' => '#3B82F6',
                'meta_data' => json_encode([
                    'meta_title' => 'Maquillage Yeux - Mascaras & Ombres',
                    'meta_description' => 'Maquillage yeux professionnel : mascaras, ombres à paupières, eyeliners.',
                    'keywords' => ['mascara', 'ombre à paupières', 'eyeliner', 'maquillage yeux']
                ]),
                'parent_id' => 5,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Maquillage Lèvres',
                'slug' => 'maquillage-levres',
                'description' => 'Rouges à lèvres, gloss, baumes',
                'image' => 'categories/maquillage-levres.jpg',
                'icon' => '💋',
                'color' => '#DC2626',
                'meta_data' => json_encode([
                    'meta_title' => 'Maquillage Lèvres - Rouges à Lèvres',
                    'meta_description' => 'Rouges à lèvres, gloss et baumes. Toutes les nuances tendance.',
                    'keywords' => ['rouge à lèvres', 'gloss', 'baume à lèvres', 'maquillage lèvres']
                ]),
                'parent_id' => 5,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Maquillage Teint',
                'slug' => 'maquillage-teint',
                'description' => 'Fonds de teint, correcteurs, poudres',
                'image' => 'categories/maquillage-teint.jpg',
                'icon' => '✨',
                'color' => '#F59E0B',
                'meta_data' => json_encode([
                    'meta_title' => 'Maquillage Teint - Fonds de Teint',
                    'meta_description' => 'Fonds de teint, correcteurs et poudres pour un teint parfait.',
                    'keywords' => ['fond de teint', 'correcteur', 'poudre', 'maquillage teint']
                ]),
                'parent_id' => 5,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],

            // SOINS
            [
                'name' => 'Soins',
                'slug' => 'soins',
                'description' => 'Soins visage et corps pour tous types de peau',
                'image' => 'categories/soins.jpg',
                'icon' => '🧴',
                'color' => '#10B981',
                'meta_data' => json_encode([
                    'meta_title' => 'Soins Visage & Corps - Cosmétiques de Soin',
                    'meta_description' => 'Soins visage et corps premium. Hydratants, anti-âge, nettoyants.',
                    'keywords' => ['soins visage', 'soins corps', 'crème hydratante', 'anti-âge']
                ]),
                'parent_id' => null,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],

            // SOUS-CATÉGORIES SOINS
            [
                'name' => 'Soins Visage',
                'slug' => 'soins-visage',
                'description' => 'Crèmes, sérums, nettoyants pour le visage',
                'image' => 'categories/soins-visage.jpg',
                'icon' => '🌺',
                'color' => '#F97316',
                'meta_data' => json_encode([
                    'meta_title' => 'Soins Visage - Crèmes & Sérums',
                    'meta_description' => 'Soins visage professionnels : crèmes, sérums, nettoyants anti-âge.',
                    'keywords' => ['soins visage', 'crème visage', 'sérum', 'nettoyant visage']
                ]),
                'parent_id' => 9,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],
            [
                'name' => 'Soins Corps',
                'slug' => 'soins-corps',
                'description' => 'Crèmes corporelles, huiles, gommages',
                'image' => 'categories/soins-corps.jpg',
                'icon' => '🌿',
                'color' => '#84CC16',
                'meta_data' => json_encode([
                    'meta_title' => 'Soins Corps - Crèmes & Huiles Corporelles',
                    'meta_description' => 'Soins corps luxueux : crèmes hydratantes, huiles, gommages.',
                    'keywords' => ['soins corps', 'crème corps', 'huile corporelle', 'gommage']
                ]),
                'parent_id' => 9,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'products_count' => 0,
            ],

            // CHEVEUX
            [
                'name' => 'Cheveux',
                'slug' => 'cheveux',
                'description' => 'Soins capillaires professionnels',
                'image' => 'categories/cheveux.jpg',
                'icon' => '💇‍♀️',
                'color' => '#A855F7',
                'meta_data' => json_encode([
                    'meta_title' => 'Soins Cheveux - Shampooings & Masques',
                    'meta_description' => 'Soins capillaires professionnels pour tous types de cheveux.',
                    'keywords' => ['shampooing', 'après-shampooing', 'masque cheveux', 'soins capillaires']
                ]),
                'parent_id' => null,
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'products_count' => 0,
            ],

            // ACCESSOIRES
            [
                'name' => 'Accessoires',
                'slug' => 'accessoires',
                'description' => 'Pinceaux, éponges et accessoires beauté',
                'image' => 'categories/accessoires.jpg',
                'icon' => '🖌️',
                'color' => '#6366F1',
                'meta_data' => json_encode([
                    'meta_title' => 'Accessoires Beauté - Pinceaux & Outils',
                    'meta_description' => 'Accessoires beauté professionnels : pinceaux, éponges, outils.',
                    'keywords' => ['pinceaux maquillage', 'éponge beauté', 'accessoires beauté']
                ]),
                'parent_id' => null,
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => false,
                'products_count' => 0,
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Categories seedées avec succès!');
    }
}