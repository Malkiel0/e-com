<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $product_images = [
            // CHANEL N°5 (product_id: 1)
            [
                'product_id' => 1,
                'original_name' => 'chanel-n5-main.jpg',
                'file_name' => 'chanel-n5-edp-100ml-main.jpg',
                'file_path' => 'products/chanel/n5/chanel-n5-edp-100ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 245680,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Chanel N°5 Eau de Parfum 100ml - Vue principale',
                'variations' => json_encode([
                    'thumbnail' => 'products/chanel/n5/thumbs/chanel-n5-edp-100ml-main-thumb.jpg',
                    'medium' => 'products/chanel/n5/medium/chanel-n5-edp-100ml-main-medium.jpg',
                    'large' => 'products/chanel/n5/large/chanel-n5-edp-100ml-main-large.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 1,
                'original_name' => 'chanel-n5-angle.jpg',
                'file_name' => 'chanel-n5-edp-100ml-angle.jpg',
                'file_path' => 'products/chanel/n5/chanel-n5-edp-100ml-angle.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 198450,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Chanel N°5 Eau de Parfum - Vue de côté',
                'variations' => json_encode([
                    'thumbnail' => 'products/chanel/n5/thumbs/chanel-n5-edp-100ml-angle-thumb.jpg',
                    'medium' => 'products/chanel/n5/medium/chanel-n5-edp-100ml-angle-medium.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],
            [
                'product_id' => 1,
                'original_name' => 'chanel-n5-packaging.jpg',
                'file_name' => 'chanel-n5-edp-100ml-packaging.jpg',
                'file_path' => 'products/chanel/n5/chanel-n5-edp-100ml-packaging.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 312890,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Chanel N°5 - Packaging et boîte',
                'variations' => json_encode([
                    'thumbnail' => 'products/chanel/n5/thumbs/chanel-n5-edp-100ml-packaging-thumb.jpg'
                ]),
                'sort_order' => 3,
                'is_primary' => false,
                'is_active' => true,
            ],

            // COCO MADEMOISELLE (product_id: 2)
            [
                'product_id' => 2,
                'original_name' => 'coco-mademoiselle-main.jpg',
                'file_name' => 'chanel-coco-mademoiselle-edp-100ml-main.jpg',
                'file_path' => 'products/chanel/coco-mademoiselle/chanel-coco-mademoiselle-edp-100ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 267890,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Chanel Coco Mademoiselle Eau de Parfum 100ml',
                'variations' => json_encode([
                    'thumbnail' => 'products/chanel/coco-mademoiselle/thumbs/main-thumb.jpg',
                    'medium' => 'products/chanel/coco-mademoiselle/medium/main-medium.jpg',
                    'large' => 'products/chanel/coco-mademoiselle/large/main-large.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 2,
                'original_name' => 'coco-mademoiselle-lifestyle.jpg',
                'file_name' => 'chanel-coco-mademoiselle-edp-lifestyle.jpg',
                'file_path' => 'products/chanel/coco-mademoiselle/chanel-coco-mademoiselle-edp-lifestyle.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 445670,
                'width' => 1200,
                'height' => 800,
                'alt_text' => 'Coco Mademoiselle - Image lifestyle',
                'variations' => json_encode([
                    'thumbnail' => 'products/chanel/coco-mademoiselle/thumbs/lifestyle-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // DIOR SAUVAGE (product_id: 3)
            [
                'product_id' => 3,
                'original_name' => 'dior-sauvage-main.jpg',
                'file_name' => 'dior-sauvage-edt-100ml-main.jpg',
                'file_path' => 'products/dior/sauvage/dior-sauvage-edt-100ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 298760,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Dior Sauvage Eau de Toilette 100ml',
                'variations' => json_encode([
                    'thumbnail' => 'products/dior/sauvage/thumbs/main-thumb.jpg',
                    'medium' => 'products/dior/sauvage/medium/main-medium.jpg',
                    'large' => 'products/dior/sauvage/large/main-large.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 3,
                'original_name' => 'dior-sauvage-spray.jpg',
                'file_name' => 'dior-sauvage-edt-spray-action.jpg',
                'file_path' => 'products/dior/sauvage/dior-sauvage-edt-spray-action.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 187650,
                'width' => 800,
                'height' => 600,
                'alt_text' => 'Dior Sauvage - Spray en action',
                'variations' => json_encode([
                    'thumbnail' => 'products/dior/sauvage/thumbs/spray-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // TOM FORD OUD WOOD (product_id: 4)
            [
                'product_id' => 4,
                'original_name' => 'tom-ford-oud-wood-main.jpg',
                'file_name' => 'tom-ford-oud-wood-edp-50ml-main.jpg',
                'file_path' => 'products/tom-ford/oud-wood/tom-ford-oud-wood-edp-50ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 234560,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Tom Ford Oud Wood Eau de Parfum 50ml',
                'variations' => json_encode([
                    'thumbnail' => 'products/tom-ford/oud-wood/thumbs/main-thumb.jpg',
                    'medium' => 'products/tom-ford/oud-wood/medium/main-medium.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 4,
                'original_name' => 'tom-ford-oud-wood-luxury.jpg',
                'file_name' => 'tom-ford-oud-wood-luxury-setting.jpg',
                'file_path' => 'products/tom-ford/oud-wood/tom-ford-oud-wood-luxury-setting.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 567890,
                'width' => 1200,
                'height' => 900,
                'alt_text' => 'Tom Ford Oud Wood - Ambiance luxe',
                'variations' => json_encode([
                    'thumbnail' => 'products/tom-ford/oud-wood/thumbs/luxury-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // YSL ROUGE PUR COUTURE (product_id: 5)
            [
                'product_id' => 5,
                'original_name' => 'ysl-rouge-cardinal-main.jpg',
                'file_name' => 'ysl-rouge-pur-couture-cardinal-main.jpg',
                'file_path' => 'products/ysl/rouge-pur-couture/ysl-rouge-pur-couture-cardinal-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 156780,
                'width' => 600,
                'height' => 600,
                'alt_text' => 'YSL Rouge Pur Couture Cardinal',
                'variations' => json_encode([
                    'thumbnail' => 'products/ysl/rouge-pur-couture/thumbs/cardinal-thumb.jpg',
                    'medium' => 'products/ysl/rouge-pur-couture/medium/cardinal-medium.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 5,
                'original_name' => 'ysl-rouge-swatch.jpg',
                'file_name' => 'ysl-rouge-pur-couture-cardinal-swatch.jpg',
                'file_path' => 'products/ysl/rouge-pur-couture/ysl-rouge-pur-couture-cardinal-swatch.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 89450,
                'width' => 600,
                'height' => 400,
                'alt_text' => 'YSL Rouge Cardinal - Swatch couleur',
                'variations' => json_encode([
                    'thumbnail' => 'products/ysl/rouge-pur-couture/thumbs/swatch-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],
            [
                'product_id' => 5,
                'original_name' => 'ysl-rouge-model.jpg',
                'file_name' => 'ysl-rouge-pur-couture-model.jpg',
                'file_path' => 'products/ysl/rouge-pur-couture/ysl-rouge-pur-couture-model.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 678900,
                'width' => 800,
                'height' => 1200,
                'alt_text' => 'YSL Rouge Pur Couture - Modèle',
                'variations' => json_encode([
                    'thumbnail' => 'products/ysl/rouge-pur-couture/thumbs/model-thumb.jpg'
                ]),
                'sort_order' => 3,
                'is_primary' => false,
                'is_active' => true,
            ],

            // MAC RUBY WOO (product_id: 6)
            [
                'product_id' => 6,
                'original_name' => 'mac-ruby-woo-main.jpg',
                'file_name' => 'mac-ruby-woo-lipstick-main.jpg',
                'file_path' => 'products/mac/ruby-woo/mac-ruby-woo-lipstick-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 134560,
                'width' => 600,
                'height' => 600,
                'alt_text' => 'MAC Ruby Woo Lipstick',
                'variations' => json_encode([
                    'thumbnail' => 'products/mac/ruby-woo/thumbs/main-thumb.jpg',
                    'medium' => 'products/mac/ruby-woo/medium/main-medium.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 6,
                'original_name' => 'mac-ruby-woo-texture.jpg',
                'file_name' => 'mac-ruby-woo-texture-detail.jpg',
                'file_path' => 'products/mac/ruby-woo/mac-ruby-woo-texture-detail.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 98760,
                'width' => 600,
                'height' => 400,
                'alt_text' => 'MAC Ruby Woo - Texture mate',
                'variations' => json_encode([
                    'thumbnail' => 'products/mac/ruby-woo/thumbs/texture-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // LA MER CRÈME (product_id: 7)
            [
                'product_id' => 7,
                'original_name' => 'la-mer-creme-main.jpg',
                'file_name' => 'la-mer-creme-de-la-mer-60ml-main.jpg',
                'file_path' => 'products/la-mer/creme/la-mer-creme-de-la-mer-60ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 278960,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'La Mer Crème de la Mer 60ml',
                'variations' => json_encode([
                    'thumbnail' => 'products/la-mer/creme/thumbs/main-thumb.jpg',
                    'medium' => 'products/la-mer/creme/medium/main-medium.jpg',
                    'large' => 'products/la-mer/creme/large/main-large.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 7,
                'original_name' => 'la-mer-texture.jpg',
                'file_name' => 'la-mer-creme-texture-luxe.jpg',
                'file_path' => 'products/la-mer/creme/la-mer-creme-texture-luxe.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 345670,
                'width' => 800,
                'height' => 600,
                'alt_text' => 'La Mer - Texture crème luxueuse',
                'variations' => json_encode([
                    'thumbnail' => 'products/la-mer/creme/thumbs/texture-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // BYREDO GYPSY WATER (product_id: 8)
            [
                'product_id' => 8,
                'original_name' => 'byredo-gypsy-water-main.jpg',
                'file_name' => 'byredo-gypsy-water-edp-100ml-main.jpg',
                'file_path' => 'products/byredo/gypsy-water/byredo-gypsy-water-edp-100ml-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 198760,
                'width' => 600,
                'height' => 800,
                'alt_text' => 'Byredo Gypsy Water Eau de Parfum 100ml',
                'variations' => json_encode([
                    'thumbnail' => 'products/byredo/gypsy-water/thumbs/main-thumb.jpg',
                    'medium' => 'products/byredo/gypsy-water/medium/main-medium.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 8,
                'original_name' => 'byredo-gypsy-water-minimal.jpg',
                'file_name' => 'byredo-gypsy-water-minimal-setting.jpg',
                'file_path' => 'products/byredo/gypsy-water/byredo-gypsy-water-minimal-setting.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 456890,
                'width' => 1000,
                'height' => 800,
                'alt_text' => 'Byredo Gypsy Water - Style minimaliste',
                'variations' => json_encode([
                    'thumbnail' => 'products/byredo/gypsy-water/thumbs/minimal-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],

            // MISS DIOR ÉDITION LIMITÉE (product_id: 9)
            [
                'product_id' => 9,
                'original_name' => 'miss-dior-limited-main.jpg',
                'file_name' => 'dior-miss-dior-limited-couture-main.jpg',
                'file_path' => 'products/dior/miss-dior-limited/dior-miss-dior-limited-couture-main.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 345670,
                'width' => 800,
                'height' => 800,
                'alt_text' => 'Dior Miss Dior Édition Limitée Couture',
                'variations' => json_encode([
                    'thumbnail' => 'products/dior/miss-dior-limited/thumbs/main-thumb.jpg',
                    'medium' => 'products/dior/miss-dior-limited/medium/main-medium.jpg',
                    'large' => 'products/dior/miss-dior-limited/large/main-large.jpg'
                ]),
                'sort_order' => 1,
                'is_primary' => true,
                'is_active' => true,
            ],
            [
                'product_id' => 9,
                'original_name' => 'miss-dior-limited-detail.jpg',
                'file_name' => 'dior-miss-dior-limited-cannage-detail.jpg',
                'file_path' => 'products/dior/miss-dior-limited/dior-miss-dior-limited-cannage-detail.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 234560,
                'width' => 600,
                'height' => 600,
                'alt_text' => 'Miss Dior Limited - Détail motif cannage',
                'variations' => json_encode([
                    'thumbnail' => 'products/dior/miss-dior-limited/thumbs/detail-thumb.jpg'
                ]),
                'sort_order' => 2,
                'is_primary' => false,
                'is_active' => true,
            ],
            [
                'product_id' => 9,
                'original_name' => 'miss-dior-limited-collector.jpg',
                'file_name' => 'dior-miss-dior-limited-collector-box.jpg',
                'file_path' => 'products/dior/miss-dior-limited/dior-miss-dior-limited-collector-box.jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => 567890,
                'width' => 1000,
                'height' => 800,
                'alt_text' => 'Miss Dior Limited - Boîte collector',
                'variations' => json_encode([
                    'thumbnail' => 'products/dior/miss-dior-limited/thumbs/collector-thumb.jpg'
                ]),
                'sort_order' => 3,
                'is_primary' => false,
                'is_active' => true,
            ],
        ];

        foreach ($product_images as $image) {
            DB::table('product_images')->insert(array_merge($image, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Product Images seedées avec succès!');
        $this->command->info('📸 Total: ' . count($product_images) . ' images créées pour 9 produits');
    }
}