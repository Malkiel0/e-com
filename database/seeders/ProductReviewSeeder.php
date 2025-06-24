<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            // CHANEL N°5 (product_id: 1)
            [
                'product_id' => 1,
                'user_id' => 3, // Sophie Laurent
                'rating' => 5,
                'title' => 'Iconique et intemporel',
                'comment' => 'Chanel N°5 reste pour moi LE parfum de référence. Sa composition est d\'une sophistication rare et sa tenue exceptionnelle. Un investissement qui en vaut la peine pour les grandes occasions.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 23,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(15),
                'approved_by' => 2, // Marie Dubois (admin)
            ],
            [
                'product_id' => 1,
                'user_id' => 4, // Camille Moreau
                'rating' => 4,
                'title' => 'Classique mais pas pour tous les jours',
                'comment' => 'Un parfum magnifique mais très puissant. Je le réserve aux événements spéciaux. L\'odeur est vraiment unique et reconnaissable entre mille.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 12,
                'not_helpful_count' => 3,
                'approved_at' => now()->subDays(8),
                'approved_by' => 2,
            ],
            [
                'product_id' => 1,
                'user_id' => 6, // Emma Petit
                'rating' => 5,
                'title' => 'Mon premier parfum de luxe',
                'comment' => 'J\'ai longtemps hésité avant de craquer pour ce parfum mythique. Je ne regrette pas ! C\'est effectivement un parfum d\'exception, élégant et raffiné.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 8,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(3),
                'approved_by' => 2,
            ],

            // COCO MADEMOISELLE (product_id: 2)
            [
                'product_id' => 2,
                'user_id' => 3, // Sophie Laurent
                'rating' => 5,
                'title' => 'Perfect pour la femme moderne',
                'comment' => 'Coco Mademoiselle est devenu mon parfum signature. Il est à la fois pétillant et sophistiqué, parfait pour le bureau comme pour les sorties. La tenue est excellente.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 31,
                'not_helpful_count' => 2,
                'approved_at' => now()->subDays(20),
                'approved_by' => 2,
            ],
            [
                'product_id' => 2,
                'user_id' => 8, // Léa Rousseau
                'rating' => 4,
                'title' => 'Mon coup de cœur',
                'comment' => 'J\'adore ce parfum ! Il sent bon, pas trop fort et il tient bien toute la journée. Le flacon est magnifique aussi. Je recommande !',
                'is_verified_purchase' => false,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 7,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(5),
                'approved_by' => 2,
            ],

            // DIOR SAUVAGE (product_id: 3)
            [
                'product_id' => 3,
                'user_id' => 5, // Julien Martin
                'rating' => 5,
                'title' => 'Excellent parfum masculin',
                'comment' => 'Sauvage de Dior est vraiment un excellent choix. L\'odeur est fraîche et virile à la fois. Je reçois souvent des compliments quand je le porte. La projection est parfaite.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 45,
                'not_helpful_count' => 3,
                'approved_at' => now()->subDays(12),
                'approved_by' => 2,
            ],
            [
                'product_id' => 3,
                'user_id' => 7, // Lucas Bonnet
                'rating' => 4,
                'title' => 'Mon premier achat chez vous',
                'comment' => 'Très satisfait de mon achat. Le parfum correspond exactement à mes attentes et la livraison a été rapide. Je reviendrai !',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 6,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(2),
                'approved_by' => 2,
            ],
            [
                'product_id' => 3,
                'user_id' => 9, // Thomas Girard
                'rating' => 5,
                'title' => 'Parfait pour l\'été',
                'comment' => 'Ce parfum est idéal pour les beaux jours. Il est frais sans être trop léger. La bergamote en tête est vraiment agréable.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 9,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(7),
                'approved_by' => 2,
            ],

            // TOM FORD OUD WOOD (product_id: 4)
            [
                'product_id' => 4,
                'user_id' => 3, // Sophie Laurent (cliente VIP)
                'rating' => 5,
                'title' => 'Oud accessible et raffiné',
                'comment' => 'Tom Ford a réussi le pari de rendre l\'oud accessible. Ce parfum est d\'une sophistication rare, parfait pour les connaisseurs. Un vrai coup de cœur malgré le prix.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 18,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(25),
                'approved_by' => 2,
            ],
            [
                'product_id' => 4,
                'user_id' => 5, // Julien Martin
                'rating' => 4,
                'title' => 'Luxueux mais cher',
                'comment' => 'La qualité est indéniable, le parfum est magnifique et très original. Cependant le prix reste élevé, même si on comprend pourquoi.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 11,
                'not_helpful_count' => 2,
                'approved_at' => now()->subDays(18),
                'approved_by' => 2,
            ],

            // YSL ROUGE PUR COUTURE (product_id: 5)
            [
                'product_id' => 5,
                'user_id' => 4, // Camille Moreau
                'rating' => 5,
                'title' => 'Le rouge parfait',
                'comment' => 'Ce rouge à lèvres YSL est absolument parfait ! La couleur Cardinal est magnifique, la texture crémeuse et la tenue excellente. Le packaging est luxueux.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 27,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(10),
                'approved_by' => 2,
            ],
            [
                'product_id' => 5,
                'user_id' => 6, // Emma Petit
                'rating' => 4,
                'title' => 'Très belle couleur',
                'comment' => 'J\'adore cette teinte de rouge, elle va bien avec mon teint. Le rouge tient bien même après avoir bu et mangé.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 8,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(6),
                'approved_by' => 2,
            ],
            [
                'product_id' => 5,
                'user_id' => 8, // Léa Rousseau
                'rating' => 5,
                'title' => 'Mon premier YSL',
                'comment' => 'Je voulais me faire plaisir avec un rouge à lèvres de luxe et je ne suis pas déçue ! La qualité est vraiment au rendez-vous.',
                'is_verified_purchase' => false,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 5,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(4),
                'approved_by' => 2,
            ],

            // MAC RUBY WOO (product_id: 6)
            [
                'product_id' => 6,
                'user_id' => 4, // Camille Moreau
                'rating' => 5,
                'title' => 'L\'iconique Ruby Woo',
                'comment' => 'Ruby Woo est LE rouge que toute fille doit avoir ! Cette teinte rouge pure est universelle et le fini mat est parfait. Un classique indémodable.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 52,
                'not_helpful_count' => 4,
                'approved_at' => now()->subDays(22),
                'approved_by' => 2,
            ],
            [
                'product_id' => 6,
                'user_id' => 8, // Léa Rousseau
                'rating' => 4,
                'title' => 'Très pigmenté',
                'comment' => 'Ce rouge est vraiment intense ! Il faut bien préparer ses lèvres car il peut marquer les imperfections, mais la couleur est magnifique.',
                'is_verified_purchase' => false,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 13,
                'not_helpful_count' => 2,
                'approved_at' => now()->subDays(9),
                'approved_by' => 2,
            ],
            [
                'product_id' => 6,
                'user_id' => 6, // Emma Petit
                'rating' => 4,
                'title' => 'Rapport qualité-prix excellent',
                'comment' => 'Pour le prix, ce rouge MAC est vraiment bien. La tenue est bonne et la couleur intense. Je recommande.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 9,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(14),
                'approved_by' => 2,
            ],

            // LA MER CRÈME (product_id: 7)
            [
                'product_id' => 7,
                'user_id' => 3, // Sophie Laurent (VIP - peut se permettre)
                'rating' => 5,
                'title' => 'Investissement beauté justifié',
                'comment' => 'Cette crème La Mer est effectivement hors de prix, mais elle fonctionne vraiment ! Ma peau n\'a jamais été aussi douce et hydratée. Les résultats anti-âge sont visibles.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 34,
                'not_helpful_count' => 5,
                'approved_at' => now()->subDays(30),
                'approved_by' => 2,
            ],
            [
                'product_id' => 7,
                'user_id' => 4, // Camille Moreau
                'rating' => 4,
                'title' => 'Efficace mais très chère',
                'comment' => 'J\'ai testé cette crème suite aux recommandations et effectivement elle est très bien. Mais le prix reste vraiment prohibitif pour une utilisation quotidienne.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 16,
                'not_helpful_count' => 3,
                'approved_at' => now()->subDays(16),
                'approved_by' => 2,
            ],

            // BYREDO GYPSY WATER (product_id: 8)
            [
                'product_id' => 8,
                'user_id' => 4, // Camille Moreau (aime les marques niche)
                'rating' => 5,
                'title' => 'Parfum niche exceptionnel',
                'comment' => 'Gypsy Water de Byredo est un parfum vraiment unique ! L\'odeur est mystérieuse et addictive. J\'adore l\'approche minimaliste de la marque.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 21,
                'not_helpful_count' => 2,
                'approved_at' => now()->subDays(11),
                'approved_by' => 2,
            ],
            [
                'product_id' => 8,
                'user_id' => 9, // Thomas Girard
                'rating' => 4,
                'title' => 'Original et unisexe',
                'comment' => 'Ce parfum sort vraiment de l\'ordinaire. L\'aspect unisexe me plaît beaucoup et l\'odeur est vraiment particulière. À découvrir !',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 7,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(13),
                'approved_by' => 2,
            ],

            // MISS DIOR LIMITED (product_id: 9)
            [
                'product_id' => 9,
                'user_id' => 3, // Sophie Laurent (VIP qui aime les éditions limitées)
                'rating' => 5,
                'title' => 'Édition collector magnifique',
                'comment' => 'Cette édition limitée Miss Dior est absolument sublime ! Le flacon avec le motif cannage est une œuvre d\'art. Le parfum lui-même est délicieux, très féminin.',
                'is_verified_purchase' => true,
                'is_approved' => true,
                'is_featured' => true,
                'helpful_count' => 15,
                'not_helpful_count' => 0,
                'approved_at' => now()->subDays(5),
                'approved_by' => 2,
            ],
            [
                'product_id' => 9,
                'user_id' => 6, // Emma Petit
                'rating' => 4,
                'title' => 'Parfum et packaging de rêve',
                'comment' => 'J\'ai craqué pour cette édition limitée et je ne regrette pas ! Le flacon est magnifique et le parfum sent divinement bon.',
                'is_verified_purchase' => false,
                'is_approved' => true,
                'is_featured' => false,
                'helpful_count' => 8,
                'not_helpful_count' => 1,
                'approved_at' => now()->subDays(3),
                'approved_by' => 2,
            ],

            // AVIS EN ATTENTE DE MODÉRATION
            [
                'product_id' => 1,
                'user_id' => 7, // Lucas Bonnet
                'rating' => 3,
                'title' => 'Pas convaincu',
                'comment' => 'Je ne comprends pas l\'engouement pour ce parfum. Il est certes de qualité mais l\'odeur ne me correspond pas du tout.',
                'is_verified_purchase' => false,
                'is_approved' => false,
                'is_featured' => false,
                'helpful_count' => 0,
                'not_helpful_count' => 0,
                'approved_at' => null,
                'approved_by' => null,
            ],
            [
                'product_id' => 3,
                'user_id' => 10, // Pierre Durand (inactif)
                'rating' => 2,
                'title' => 'Déçu de mon achat',
                'comment' => 'Le parfum ne tient pas assez longtemps sur ma peau. Pour ce prix j\'attendais mieux.',
                'is_verified_purchase' => true,
                'is_approved' => false,
                'is_featured' => false,
                'helpful_count' => 0,
                'not_helpful_count' => 0,
                'approved_at' => null,
                'approved_by' => null,
                'admin_notes' => 'Avis négatif à vérifier - client potentiellement mécontent',
            ],
        ];

        foreach ($reviews as $review) {
            DB::table('product_reviews')->insert(array_merge($review, [
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Product Reviews seedés avec succès!');
        $this->command->info('⭐ Créés: ' . count($reviews) . ' avis (dont 2 en attente de modération)');
        $this->command->info('📊 Répartition: 11 avis 5⭐, 7 avis 4⭐, 1 avis 3⭐, 1 avis 2⭐');
    }
}