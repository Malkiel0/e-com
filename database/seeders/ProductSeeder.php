<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // PARFUMS FEMME CHANEL
            [
                'name' => 'Chanel N°5 Eau de Parfum',
                'slug' => 'chanel-n5-eau-de-parfum',
                'short_description' => 'Le parfum le plus iconique au monde, symbole d\'élégance intemporelle',
                'description' => '<p>Chanel N°5 est le parfum le plus mythique de tous les temps. Créé en 1921 par Ernest Beaux à la demande de Gabrielle Chanel, il révolutionne la parfumerie avec sa composition florale-aldéhydée unique.</p><p>Un bouquet floral sophistiqué où se mélangent harmonieusement rose de mai, jasmin de Grasse, ylang-ylang et iris, sublimés par des aldéhydes scintillants et une base sensuelle de santal et musc.</p><p>Porté par les plus grandes icônes comme Marilyn Monroe, N°5 incarne la féminité moderne et l\'élégance parisienne.</p>',
                'sku' => 'CHA-N5-EDP-100',
                'category_id' => 2, // Parfums Femme
                'brand_id' => 1, // Chanel
                'price' => 145.00,
                'original_price' => null,
                'cost_price' => 87.00,
                'stock_quantity' => 50,
                'low_stock_threshold' => 10,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 320.0,
                'length' => 8.5,
                'width' => 8.5,
                'height' => 12.0,
                'volume' => '100ml',
                'concentration' => 'Eau de Parfum',
                'fragrance_notes' => json_encode([
                    'top' => ['Aldéhydes', 'Néroli', 'Citron de Sicile'],
                    'heart' => ['Rose de Mai', 'Jasmin de Grasse', 'Ylang-ylang', 'Iris'],
                    'base' => ['Santal', 'Cèdre', 'Vanille', 'Musc']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Limonene', 'Linalool', 'Citronellol', 'Geraniol']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'Chanel N°5 Eau de Parfum 100ml - Le Parfum Iconique',
                'meta_description' => 'Chanel N°5 Eau de Parfum, le parfum le plus mythique. Floral aldéhydé unique. Livraison gratuite et authentique.',
                'meta_keywords' => json_encode(['chanel n5', 'parfum chanel', 'eau de parfum', 'parfum femme', 'chanel numero 5']),
                'rating_average' => 4.8,
                'reviews_count' => 1247,
                'views_count' => 15430,
                'sales_count' => 892,
                'wishlist_count' => 234,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 160.00,
            ],
            [
                'name' => 'Chanel Coco Mademoiselle Eau de Parfum',
                'slug' => 'chanel-coco-mademoiselle-edp',
                'short_description' => 'Un parfum oriental-frais moderne, pétillant et audacieux',
                'description' => '<p>Coco Mademoiselle incarne l\'esprit libre et audacieux de Gabrielle Chanel. Ce parfum oriental-frais capture l\'essence de la femme moderne : indépendante, provoquante et irrésistible.</p><p>L\'orange fraîche et pétillante s\'associe à la rose et au jasmin, tandis que le patchouli et la vanille apportent une sensualité moderne et sophistiquée.</p><p>Une fragrance qui révèle toutes les facettes de la féminité contemporaine.</p>',
                'sku' => 'CHA-COCO-EDP-100',
                'category_id' => 2,
                'brand_id' => 1,
                'price' => 139.00,
                'original_price' => null,
                'cost_price' => 83.40,
                'stock_quantity' => 75,
                'low_stock_threshold' => 15,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 320.0,
                'length' => 8.5,
                'width' => 8.5,
                'height' => 12.0,
                'volume' => '100ml',
                'concentration' => 'Eau de Parfum',
                'fragrance_notes' => json_encode([
                    'top' => ['Orange de Sicile', 'Bergamote', 'Pamplemousse'],
                    'heart' => ['Rose de Mai', 'Jasmin', 'Litchi'],
                    'base' => ['Patchouli', 'Vanille', 'Musc Blanc', 'Vétiver']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Limonene', 'Linalool', 'Citronellol']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'Chanel Coco Mademoiselle EDP 100ml - Parfum Oriental Frais',
                'meta_description' => 'Coco Mademoiselle de Chanel, oriental frais moderne. Pétillant et audacieux. Authentique.',
                'meta_keywords' => json_encode(['coco mademoiselle', 'chanel parfum', 'oriental frais', 'parfum moderne']),
                'rating_average' => 4.7,
                'reviews_count' => 956,
                'views_count' => 12890,
                'sales_count' => 734,
                'wishlist_count' => 189,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 155.00,
            ],

            // PARFUMS HOMME
            [
                'name' => 'Dior Sauvage Eau de Toilette',
                'slug' => 'dior-sauvage-edt',
                'short_description' => 'Un parfum sauvage et noble, frais et puissant',
                'description' => '<p>Sauvage de Dior est un concentré de force brute et de noblesse. François Demachy a composé ce parfum comme un paysage olfactif aux accents sauvages.</p><p>La bergamote de Calabre, fraîche et juteuse, révèle toute sa dimension sur un cœur d\'ambroxan minéral et une base de vanille de Papouasie Nouvelle-Guinée.</p><p>Un parfum masculin intense et indomptable qui célèbre la nature à l\'état brut.</p>',
                'sku' => 'DIO-SAU-EDT-100',
                'category_id' => 3, // Parfums Homme
                'brand_id' => 2, // Dior
                'price' => 89.00,
                'original_price' => null,
                'cost_price' => 53.40,
                'stock_quantity' => 120,
                'low_stock_threshold' => 20,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 350.0,
                'length' => 9.0,
                'width' => 6.0,
                'height' => 13.5,
                'volume' => '100ml',
                'concentration' => 'Eau de Toilette',
                'fragrance_notes' => json_encode([
                    'top' => ['Bergamote de Calabre', 'Poivre'],
                    'heart' => ['Ambroxan', 'Géranium', 'Lavande'],
                    'base' => ['Vanille', 'Cèdre', 'Santal']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Limonene', 'Linalool', 'Coumarin']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'Dior Sauvage EDT 100ml - Parfum Homme Sauvage',
                'meta_description' => 'Dior Sauvage Eau de Toilette, parfum homme intense. Bergamote et ambroxan. Authentique.',
                'meta_keywords' => json_encode(['dior sauvage', 'parfum homme', 'eau de toilette', 'masculin']),
                'rating_average' => 4.6,
                'reviews_count' => 2134,
                'views_count' => 18750,
                'sales_count' => 1456,
                'wishlist_count' => 367,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 95.00,
            ],
            [
                'name' => 'Tom Ford Oud Wood Eau de Parfum',
                'slug' => 'tom-ford-oud-wood-edp',
                'short_description' => 'Un oud raffiné et accessible, boisé oriental de luxe',
                'description' => '<p>Oud Wood de Tom Ford rend accessible l\'un des ingrédients les plus précieux de la parfumerie. Cette composition sophistiquée révèle l\'oud sous un jour moderne et raffiné.</p><p>L\'oud rare se mélange harmonieusement au bois de rose et au santal, créant une symphonie boisée d\'une élégance rare.</p><p>Un parfum unisexe d\'exception qui incarne le luxe et la sophistication à l\'état pur.</p>',
                'sku' => 'TOM-OUD-EDP-50',
                'category_id' => 4, // Parfums Unisexe
                'brand_id' => 3, // Tom Ford
                'price' => 245.00,
                'original_price' => null,
                'cost_price' => 147.00,
                'stock_quantity' => 25,
                'low_stock_threshold' => 5,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 280.0,
                'length' => 7.0,
                'width' => 7.0,
                'height' => 11.0,
                'volume' => '50ml',
                'concentration' => 'Eau de Parfum',
                'fragrance_notes' => json_encode([
                    'top' => ['Oud', 'Bois de Rose', 'Cardamome'],
                    'heart' => ['Santal', 'Palissandre', 'Cannelle'],
                    'base' => ['Vanille', 'Ambre', 'Tonka']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Linalool', 'Coumarin', 'Eugenol']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => false,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'Tom Ford Oud Wood EDP 50ml - Parfum Oud Luxe',
                'meta_description' => 'Tom Ford Oud Wood, oud raffiné et moderne. Boisé oriental de luxe. Unisexe.',
                'meta_keywords' => json_encode(['tom ford oud wood', 'parfum oud', 'boisé oriental', 'luxe']),
                'rating_average' => 4.9,
                'reviews_count' => 478,
                'views_count' => 8930,
                'sales_count' => 234,
                'wishlist_count' => 567,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 260.00,
            ],

            // COSMÉTIQUES - MAQUILLAGE LÈVRES
            [
                'name' => 'YSL Rouge Pur Couture - Rouge Cardinal',
                'slug' => 'ysl-rouge-pur-couture-cardinal',
                'short_description' => 'Rouge à lèvres iconique, couleur intense et tenue longue durée',
                'description' => '<p>Le Rouge Pur Couture d\'Yves Saint Laurent est l\'incarnation du rouge à lèvres parfait. Sa formule révolutionnaire offre une couleur pure et intense dès la première application.</p><p>Enrichi en huiles précieuses, il glisse sur les lèvres comme une caresse tout en apportant une hydratation longue durée.</p><p>Rouge Cardinal : un rouge profond et sophistiqué, signature de l\'élégance parisienne.</p>',
                'sku' => 'YSL-RPC-01-CARDINAL',
                'category_id' => 7, // Maquillage Lèvres
                'brand_id' => 5, // YSL
                'price' => 42.00,
                'original_price' => null,
                'cost_price' => 21.00,
                'stock_quantity' => 150,
                'low_stock_threshold' => 25,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 45.0,
                'length' => 2.5,
                'width' => 2.5,
                'height' => 9.0,
                'volume' => '3.8g',
                'concentration' => null,
                'fragrance_notes' => null,
                'ingredients' => json_encode(['Dimethicone', 'Bis-Diglyceryl', 'Polyacyladipate-2', 'Hydrogenated Polydecene', 'Octyldodecanol']),
                'skin_type' => 'Tous types de lèvres',
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'YSL Rouge Pur Couture Cardinal - Rouge à Lèvres Iconique',
                'meta_description' => 'YSL Rouge Pur Couture Cardinal, rouge à lèvres intense. Hydratant longue tenue.',
                'meta_keywords' => json_encode(['ysl rouge', 'rouge à lèvres', 'pur couture', 'maquillage lèvres']),
                'rating_average' => 4.5,
                'reviews_count' => 687,
                'views_count' => 9450,
                'sales_count' => 567,
                'wishlist_count' => 123,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 46.00,
            ],
            [
                'name' => 'MAC Ruby Woo Lipstick',
                'slug' => 'mac-ruby-woo-lipstick',
                'short_description' => 'Le rouge iconique de MAC, mat intense et longue tenue',
                'description' => '<p>Ruby Woo est le rouge à lèvres le plus iconique de MAC. Cette teinte rouge pure au fini mat intense est devenue une référence mondiale.</p><p>Sa formule unique offre une couvrance parfaite et une tenue exceptionnelle sans effet desséchant.</p><p>Porté par les plus grandes stars, Ruby Woo est le rouge parfait pour toutes les occasions.</p>',
                'sku' => 'MAC-RW-LIPSTICK',
                'category_id' => 7,
                'brand_id' => 9, // MAC
                'price' => 25.00,
                'original_price' => null,
                'cost_price' => 12.50,
                'stock_quantity' => 200,
                'low_stock_threshold' => 30,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 35.0,
                'length' => 2.0,
                'width' => 2.0,
                'height' => 8.5,
                'volume' => '3g',
                'concentration' => null,
                'fragrance_notes' => null,
                'ingredients' => json_encode(['Octyldodecanol', 'Silica', 'Tricaprylin', 'Triisocetyl Citrate']),
                'skin_type' => 'Tous types de lèvres',
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'MAC Ruby Woo Lipstick - Rouge Mat Iconique',
                'meta_description' => 'MAC Ruby Woo, le rouge à lèvres mat iconique. Rouge intense longue tenue.',
                'meta_keywords' => json_encode(['mac ruby woo', 'rouge mat', 'lipstick', 'mac cosmetics']),
                'rating_average' => 4.4,
                'reviews_count' => 1234,
                'views_count' => 15670,
                'sales_count' => 987,
                'wishlist_count' => 234,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 28.00,
            ],

            // SOINS VISAGE
            [
                'name' => 'La Mer Crème de la Mer',
                'slug' => 'la-mer-creme-de-la-mer',
                'short_description' => 'La crème légendaire aux algues marines, soin anti-âge ultime',
                'description' => '<p>La Crème de la Mer est née d\'un miracle. Après un terrible accident, le Dr Max Huber a consacré 12 ans de sa vie à créer cette crème révolutionnaire.</p><p>Au cœur de sa formule : le Miracle Broth™, un élixir aux algues marines fermentées qui répare, protège et transforme la peau.</p><p>Cette crème d\'exception offre une hydratation intense et des résultats anti-âge visibles dès les premières applications.</p>',
                'sku' => 'LAM-CREME-60ML',
                'category_id' => 10, // Soins Visage
                'brand_id' => 12, // La Mer
                'price' => 385.00,
                'original_price' => null,
                'cost_price' => 192.50,
                'stock_quantity' => 30,
                'low_stock_threshold' => 8,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 180.0,
                'length' => 8.0,
                'width' => 8.0,
                'height' => 6.0,
                'volume' => '60ml',
                'concentration' => null,
                'fragrance_notes' => null,
                'ingredients' => json_encode(['Miracle Broth', 'Calcium Carbonate', 'Magnesium Carbonate', 'Sea Water']),
                'skin_type' => 'Tous types de peau',
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => false,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'La Mer Crème de la Mer 60ml - Soin Anti-âge Luxe',
                'meta_description' => 'La Mer Crème légendaire aux algues marines. Soin anti-âge ultime et hydratation intense.',
                'meta_keywords' => json_encode(['la mer creme', 'soin anti age', 'creme luxe', 'algues marines']),
                'rating_average' => 4.6,
                'reviews_count' => 345,
                'views_count' => 5670,
                'sales_count' => 123,
                'wishlist_count' => 456,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 420.00,
            ],

            // PARFUMS BYREDO (NICHE)
            [
                'name' => 'Byredo Gypsy Water Eau de Parfum',
                'slug' => 'byredo-gypsy-water-edp',
                'short_description' => 'Un parfum nomade et mystérieux, boisé épicé moderne',
                'description' => '<p>Gypsy Water de Byredo capture l\'esprit libre des communautés gitanes et leur relation intime avec la nature.</p><p>Cette composition olfactive évoque les feux de camp, les forêts de pins et la terre humide. Juniper, poivre et encens créent une atmosphère mystique et envoûtante.</p><p>Un parfum unisexe qui raconte une histoire de liberté et d\'errance poétique.</p>',
                'sku' => 'BYR-GYP-EDP-100',
                'category_id' => 4, // Parfums Unisexe
                'brand_id' => 15, // Byredo
                'price' => 165.00,
                'original_price' => null,
                'cost_price' => 99.00,
                'stock_quantity' => 35,
                'low_stock_threshold' => 8,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 290.0,
                'length' => 6.5,
                'width' => 6.5,
                'height' => 14.0,
                'volume' => '100ml',
                'concentration' => 'Eau de Parfum',
                'fragrance_notes' => json_encode([
                    'top' => ['Bergamote', 'Citron', 'Poivre', 'Juniper'],
                    'heart' => ['Encens', 'Pin', 'Orris'],
                    'base' => ['Vanille', 'Santal', 'Ambre']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Limonene', 'Linalool']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'is_limited_edition' => false,
                'available_from' => null,
                'available_until' => null,
                'meta_title' => 'Byredo Gypsy Water EDP 100ml - Parfum Niche Boisé',
                'meta_description' => 'Byredo Gypsy Water, parfum nomade mystérieux. Boisé épicé moderne unisexe.',
                'meta_keywords' => json_encode(['byredo gypsy water', 'parfum niche', 'boisé épicé', 'unisexe']),
                'rating_average' => 4.3,
                'reviews_count' => 156,
                'views_count' => 3450,
                'sales_count' => 67,
                'wishlist_count' => 189,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 180.00,
            ],

            // EDITION LIMITÉE
            [
                'name' => 'Dior Miss Dior Édition Limitée Couture',
                'slug' => 'dior-miss-dior-edition-limitee-couture',
                'short_description' => 'Édition limitée couture du parfum iconique Miss Dior',
                'description' => '<p>Miss Dior Édition Limitée Couture célèbre l\'héritage couture de la Maison Dior avec un flacon d\'exception orné du motif cannage.</p><p>Cette composition florale-chyprée révèle des notes de rose de Grasse, iris et musc blanc pour une féminité moderne et raffinée.</p><p>Un objet de collection pour les amatrices de beauté et de mode.</p>',
                'sku' => 'DIO-MD-EDT-LIM-100',
                'category_id' => 2, // Parfums Femme
                'brand_id' => 2, // Dior
                'price' => 125.00,
                'original_price' => 110.00,
                'cost_price' => 66.00,
                'stock_quantity' => 15,
                'low_stock_threshold' => 3,
                'track_stock' => true,
                'stock_status' => 'in_stock',
                'weight' => 350.0,
                'length' => 9.0,
                'width' => 7.0,
                'height' => 13.0,
                'volume' => '100ml',
                'concentration' => 'Eau de Toilette',
                'fragrance_notes' => json_encode([
                    'top' => ['Bergamote de Sicile', 'Mandarine', 'Feuilles Vertes'],
                    'heart' => ['Rose de Grasse', 'Iris', 'Pivoine'],
                    'base' => ['Patchouli', 'Musc Blanc', 'Bois Blonds']
                ]),
                'ingredients' => json_encode(['Alcohol', 'Parfum', 'Aqua', 'Limonene', 'Linalool', 'Citronellol']),
                'skin_type' => null,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'is_limited_edition' => true,
                'available_from' => now()->subDays(30),
                'available_until' => now()->addDays(60),
                'meta_title' => 'Dior Miss Dior Édition Limitée Couture - Collection Exclusive',
                'meta_description' => 'Miss Dior Édition Limitée Couture, flacon collector motif cannage. Exclusif et rare.',
                'meta_keywords' => json_encode(['miss dior', 'edition limitee', 'couture', 'collection']),
                'rating_average' => 4.7,
                'reviews_count' => 89,
                'views_count' => 2340,
                'sales_count' => 23,
                'wishlist_count' => 234,
                'status' => 'active',
                'is_active' => true,
                'compare_price' => 140.00,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Products seedés avec succès!');
    }
}