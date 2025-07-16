<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        // 1. CRÉER LES PROMOTIONS
        $promotions = [
            [
                'id' => 1,
                'name' => 'Black Friday 2024',
                'slug' => 'black-friday-2024',
                'description' => 'Les plus grandes remises de l\'année ! Jusqu\'à 40% de réduction sur une sélection de parfums et cosmétiques de luxe.',
                'type' => 'percentage',
                'value' => 30.00,
                'minimum_amount' => 50.00,
                'maximum_discount' => 150.00,
                'starts_at' => now()->subDays(10),
                'ends_at' => now()->addDays(20),
                'usage_limit' => 1000,
                'usage_limit_per_user' => 3,
                'usage_count' => 234,
                'priority' => 10,
                'is_active' => true,
                'is_combinable' => false,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'min_items' => 2,
                    'excluded_brands' => ['La Mer', 'Tom Ford'],
                    'customer_groups' => ['premium', 'vip']
                ]),
                'total_savings' => 15670.50,
                'revenue_impact' => 78350.25,
                'views_count' => 15630,
            ],
            [
                'id' => 2,
                'name' => 'Parfums Femme -20%',
                'slug' => 'parfums-femme-20',
                'description' => 'Découvrez notre collection de parfums féminins avec 20% de réduction sur toute la gamme.',
                'type' => 'percentage',
                'value' => 20.00,
                'minimum_amount' => 80.00,
                'maximum_discount' => 100.00,
                'starts_at' => now()->subDays(5),
                'ends_at' => now()->addDays(30),
                'usage_limit' => 500,
                'usage_limit_per_user' => 2,
                'usage_count' => 89,
                'priority' => 7,
                'is_active' => true,
                'is_combinable' => true,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'category_ids' => [2], // Parfums Femme
                    'min_purchase_amount' => 80
                ]),
                'total_savings' => 2890.40,
                'revenue_impact' => 14452.00,
                'views_count' => 4560,
            ],
            [
                'id' => 3,
                'name' => 'Livraison Gratuite',
                'slug' => 'livraison-gratuite',
                'description' => 'Livraison gratuite pour toute commande supérieure à 75 FCFA. Profitez-en !',
                'type' => 'free_shipping',
                'value' => 7.90,
                'minimum_amount' => 75.00,
                'maximum_discount' => 7.90,
                'starts_at' => now()->subDays(30),
                'ends_at' => now()->addDays(90),
                'usage_limit' => null,
                'usage_limit_per_user' => null,
                'usage_count' => 1567,
                'priority' => 5,
                'is_active' => true,
                'is_combinable' => true,
                'apply_to_shipping' => true,
                'conditions' => json_encode([
                    'min_purchase_amount' => 75,
                    'shipping_zones' => ['France', 'Europe']
                ]),
                'total_savings' => 12379.30,
                'revenue_impact' => 98234.60,
                'views_count' => 25670,
            ],
            [
                'id' => 4,
                'name' => 'Nouveaux Clients -15 FCFA',
                'slug' => 'nouveaux-clients-15',
                'description' => 'Bienvenue ! Profitez de 15 FCFA de réduction sur votre première commande de plus de 100 FCFA.',
                'type' => 'fixed_amount',
                'value' => 15.00,
                'minimum_amount' => 100.00,
                'maximum_discount' => 15.00,
                'starts_at' => now()->subDays(60),
                'ends_at' => now()->addDays(365),
                'usage_limit' => null,
                'usage_limit_per_user' => 1,
                'usage_count' => 456,
                'priority' => 8,
                'is_active' => true,
                'is_combinable' => false,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'new_customers_only' => true,
                    'min_purchase_amount' => 100,
                    'first_order_only' => true
                ]),
                'total_savings' => 6840.00,
                'revenue_impact' => 45670.80,
                'views_count' => 8920,
            ],
            [
                'id' => 5,
                'name' => 'Pack Beauté 3+1',
                'slug' => 'pack-beaute-3-plus-1',
                'description' => 'Achetez 3 produits cosmétiques et recevez le moins cher gratuitement !',
                'type' => 'buy_x_get_y',
                'value' => 1.00, // Nombre d'articles gratuits
                'minimum_amount' => null,
                'maximum_discount' => 200.00,
                'starts_at' => now()->subDays(15),
                'ends_at' => now()->addDays(45),
                'usage_limit' => 200,
                'usage_limit_per_user' => 2,
                'usage_count' => 67,
                'priority' => 6,
                'is_active' => true,
                'is_combinable' => false,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'buy_quantity' => 3,
                    'get_quantity' => 1,
                    'apply_to_cheapest' => true,
                    'category_ids' => [5, 6, 7, 8] // Cosmétiques
                ]),
                'total_savings' => 3456.78,
                'revenue_impact' => 23456.90,
                'views_count' => 6780,
            ],
            [
                'id' => 6,
                'name' => 'Bundle Soin Visage',
                'slug' => 'bundle-soin-visage',
                'description' => 'Offre spéciale soins visage : 25% de réduction sur l\'achat de 2 produits ou plus.',
                'type' => 'bundle',
                'value' => 25.00,
                'minimum_amount' => null,
                'maximum_discount' => 120.00,
                'starts_at' => now()->subDays(7),
                'ends_at' => now()->addDays(60),
                'usage_limit' => 150,
                'usage_limit_per_user' => 1,
                'usage_count' => 23,
                'priority' => 7,
                'is_active' => true,
                'is_combinable' => true,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'min_items' => 2,
                    'category_ids' => [10], // Soins Visage
                    'bundle_discount' => 25
                ]),
                'total_savings' => 1234.56,
                'revenue_impact' => 8765.43,
                'views_count' => 2340,
            ],
            [
                'id' => 7,
                'name' => 'Marques Premium -10%',
                'slug' => 'marques-premium-10',
                'description' => 'Réduction exclusive sur les marques de luxe : Chanel, Dior, YSL et plus encore.',
                'type' => 'percentage',
                'value' => 10.00,
                'minimum_amount' => 150.00,
                'maximum_discount' => 75.00,
                'starts_at' => now()->subDays(3),
                'ends_at' => now()->addDays(14),
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'usage_count' => 45,
                'priority' => 9,
                'is_active' => true,
                'is_combinable' => false,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'premium_brands_only' => true,
                    'min_purchase_amount' => 150,
                    'vip_customers' => true
                ]),
                'total_savings' => 2340.50,
                'revenue_impact' => 18765.40,
                'views_count' => 3450,
            ],
            [
                'id' => 8,
                'name' => 'Soldes Fin de Saison',
                'slug' => 'soldes-fin-saison',
                'description' => 'Dernière chance ! Jusqu\'à 50% de réduction sur les fins de série et éditions limitées.',
                'type' => 'percentage',
                'value' => 40.00,
                'minimum_amount' => null,
                'maximum_discount' => 200.00,
                'starts_at' => now()->addDays(10),
                'ends_at' => now()->addDays(40),
                'usage_limit' => 300,
                'usage_limit_per_user' => 5,
                'usage_count' => 0,
                'priority' => 8,
                'is_active' => true,
                'is_combinable' => false,
                'apply_to_shipping' => false,
                'conditions' => json_encode([
                    'end_of_season' => true,
                    'clearance_items' => true,
                    'limited_editions' => true
                ]),
                'total_savings' => 0.00,
                'revenue_impact' => 0.00,
                'views_count' => 890,
            ],
        ];

        foreach ($promotions as $promotion) {
            DB::table('promotions')->insert(array_merge($promotion, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2. CRÉER LES CODES PROMO
        $promotion_codes = [
            // Black Friday
            ['promotion_id' => 1, 'code' => 'BLACKFRIDAY24', 'usage_count' => 156, 'usage_limit' => 500, 'is_active' => true],
            ['promotion_id' => 1, 'code' => 'BLACK30', 'usage_count' => 78, 'usage_limit' => 300, 'is_active' => true],
            ['promotion_id' => 1, 'code' => 'FRIDAY2024', 'usage_count' => 0, 'usage_limit' => 200, 'is_active' => false],
            
            // Parfums Femme
            ['promotion_id' => 2, 'code' => 'PARFUMFEMME20', 'usage_count' => 45, 'usage_limit' => 200, 'is_active' => true],
            ['promotion_id' => 2, 'code' => 'FEMME20', 'usage_count' => 44, 'usage_limit' => 300, 'is_active' => true],
            
            // Nouveaux clients
            ['promotion_id' => 4, 'code' => 'BIENVENUE15', 'usage_count' => 234, 'usage_limit' => null, 'is_active' => true],
            ['promotion_id' => 4, 'code' => 'WELCOME15', 'usage_count' => 156, 'usage_limit' => null, 'is_active' => true],
            ['promotion_id' => 4, 'code' => 'NOUVEAU15', 'usage_count' => 66, 'usage_limit' => null, 'is_active' => true],
            
            // Pack Beauté
            ['promotion_id' => 5, 'code' => 'BEAUTE3PLUS1', 'usage_count' => 34, 'usage_limit' => 100, 'is_active' => true],
            ['promotion_id' => 5, 'code' => 'PACK3PLUS1', 'usage_count' => 33, 'usage_limit' => 100, 'is_active' => true],
            
            // Bundle Soin
            ['promotion_id' => 6, 'code' => 'SOINVISAGE25', 'usage_count' => 23, 'usage_limit' => 75, 'is_active' => true],
            
            // Marques Premium
            ['promotion_id' => 7, 'code' => 'PREMIUM10', 'usage_count' => 28, 'usage_limit' => 50, 'is_active' => true],
            ['promotion_id' => 7, 'code' => 'LUXE10', 'usage_count' => 17, 'usage_limit' => 50, 'is_active' => true],
            
            // Soldes (futurs)
            ['promotion_id' => 8, 'code' => 'SOLDES50', 'usage_count' => 0, 'usage_limit' => 150, 'is_active' => true],
            ['promotion_id' => 8, 'code' => 'CLEARANCE40', 'usage_count' => 0, 'usage_limit' => 150, 'is_active' => true],
        ];

        foreach ($promotion_codes as $code) {
            DB::table('promotion_codes')->insert(array_merge($code, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 3. RELATIONS PROMOTIONS-CATÉGORIES
        $promotion_categories = [
            // Black Friday - Toutes catégories sauf accessoires
            ['promotion_id' => 1, 'category_id' => 1], // Parfums
            ['promotion_id' => 1, 'category_id' => 2], // Parfums Femme
            ['promotion_id' => 1, 'category_id' => 3], // Parfums Homme
            ['promotion_id' => 1, 'category_id' => 5], // Cosmétiques
            ['promotion_id' => 1, 'category_id' => 9], // Soins
            
            // Parfums Femme
            ['promotion_id' => 2, 'category_id' => 2], // Parfums Femme
            
            // Pack Beauté - Cosmétiques uniquement
            ['promotion_id' => 5, 'category_id' => 5], // Cosmétiques
            ['promotion_id' => 5, 'category_id' => 6], // Maquillage Yeux
            ['promotion_id' => 5, 'category_id' => 7], // Maquillage Lèvres
            ['promotion_id' => 5, 'category_id' => 8], // Maquillage Teint
            
            // Bundle Soin Visage
            ['promotion_id' => 6, 'category_id' => 10], // Soins Visage
            
            // Marques Premium - Parfums et cosmétiques haut de gamme
            ['promotion_id' => 7, 'category_id' => 1], // Parfums
            ['promotion_id' => 7, 'category_id' => 2], // Parfums Femme
            ['promotion_id' => 7, 'category_id' => 3], // Parfums Homme
            ['promotion_id' => 7, 'category_id' => 5], // Cosmétiques
        ];

        foreach ($promotion_categories as $relation) {
            DB::table('promotion_categories')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 4. RELATIONS PROMOTIONS-MARQUES
        $promotion_brands = [
            // Black Friday - Marques moyennes gammes
            ['promotion_id' => 1, 'brand_id' => 6], // Hugo Boss
            ['promotion_id' => 1, 'brand_id' => 7], // Calvin Klein
            ['promotion_id' => 1, 'brand_id' => 8], // Versace
            ['promotion_id' => 1, 'brand_id' => 9], // MAC
            ['promotion_id' => 1, 'brand_id' => 10], // NARS
            ['promotion_id' => 1, 'brand_id' => 11], // Urban Decay
            
            // Parfums Femme - Marques spécialisées
            ['promotion_id' => 2, 'brand_id' => 1], // Chanel
            ['promotion_id' => 2, 'brand_id' => 2], // Dior
            ['promotion_id' => 2, 'brand_id' => 5], // YSL
            ['promotion_id' => 2, 'brand_id' => 15], // Byredo
            
            // Pack Beauté - Marques cosmétiques
            ['promotion_id' => 5, 'brand_id' => 9], // MAC
            ['promotion_id' => 5, 'brand_id' => 10], // NARS
            ['promotion_id' => 5, 'brand_id' => 11], // Urban Decay
            ['promotion_id' => 5, 'brand_id' => 5], // YSL
            
            // Bundle Soin - Marques soins
            ['promotion_id' => 6, 'brand_id' => 12], // La Mer
            ['promotion_id' => 6, 'brand_id' => 13], // SK-II
            ['promotion_id' => 6, 'brand_id' => 14], // Clinique
            
            // Marques Premium - Luxe uniquement
            ['promotion_id' => 7, 'brand_id' => 1], // Chanel
            ['promotion_id' => 7, 'brand_id' => 2], // Dior
            ['promotion_id' => 7, 'brand_id' => 3], // Tom Ford
            ['promotion_id' => 7, 'brand_id' => 4], // Hermès
            ['promotion_id' => 7, 'brand_id' => 5], // YSL
        ];

        foreach ($promotion_brands as $relation) {
            DB::table('promotion_brands')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 5. RELATIONS PROMOTIONS-PRODUITS SPÉCIFIQUES
        $promotion_products = [
            // Black Friday - Produits phares
            ['promotion_id' => 1, 'product_id' => 3], // Dior Sauvage
            ['promotion_id' => 1, 'product_id' => 5], // YSL Rouge
            ['promotion_id' => 1, 'product_id' => 6], // MAC Ruby Woo
            
            // Parfums Femme - Bestsellers féminins
            ['promotion_id' => 2, 'product_id' => 1], // Chanel N°5
            ['promotion_id' => 2, 'product_id' => 2], // Coco Mademoiselle
            ['promotion_id' => 2, 'product_id' => 9], // Miss Dior Limited
            
            // Pack Beauté - Produits maquillage
            ['promotion_id' => 5, 'product_id' => 5], // YSL Rouge
            ['promotion_id' => 5, 'product_id' => 6], // MAC Ruby Woo
            
            // Bundle Soin - Produits soins
            ['promotion_id' => 6, 'product_id' => 7], // La Mer Crème
            
            // Marques Premium - Produits luxe
            ['promotion_id' => 7, 'product_id' => 1], // Chanel N°5
            ['promotion_id' => 7, 'product_id' => 4], // Tom Ford Oud Wood
            ['promotion_id' => 7, 'product_id' => 7], // La Mer Crème
            
            // Soldes - Édition limitée
            ['promotion_id' => 8, 'product_id' => 9], // Miss Dior Limited
        ];

        foreach ($promotion_products as $relation) {
            DB::table('promotion_products')->insert(array_merge($relation, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Promotions et relations seedées avec succès!');
        $this->command->info('📊 Créées: 8 promotions, 15 codes promo, et toutes leurs relations');
    }
}