<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * ORDRE D'EXÉCUTION IMPORTANT :
     * 1. Users (pour les relations avec orders, reviews, etc.)
     * 2. Categories (pour les relations avec products)
     * 3. Brands (pour les relations avec products)
     * 4. Products (dépend de categories et brands)
     * 5. ProductImages (dépend de products)
     * 6. ProductReviews (dépend de products et users)
     * 7. Promotions + relations (dépend de categories, brands, products)
     */
    public function run(): void
    {
        $this->command->info('🚀 Début du seeding de la base de données...');
        $this->command->newLine();

        // 1. UTILISATEURS (en premier pour les relations)
        $this->command->info('👥 Seeding des utilisateurs...');
        $this->call(UserSeeder::class);
        $this->command->newLine();

        // 2. CATÉGORIES
        $this->command->info('📂 Seeding des catégories...');
        $this->call(CategorySeeder::class);
        $this->command->newLine();

        // 3. MARQUES
        $this->command->info('🏷️ Seeding des marques...');
        $this->call(BrandSeeder::class);
        $this->command->newLine();

        // 4. PRODUITS (dépend des catégories et marques)
        $this->command->info('🛍️ Seeding des produits...');
        $this->call(ProductSeeder::class);
        $this->command->newLine();

        // 5. IMAGES PRODUITS (dépend des produits)
        $this->command->info('📸 Seeding des images produits...');
        $this->call(ProductImageSeeder::class);
        $this->command->newLine();

        // 6. AVIS PRODUITS (dépend des produits et utilisateurs)
        $this->command->info('⭐ Seeding des avis clients...');
        $this->call(ProductReviewSeeder::class);
        $this->command->newLine();

        // 7. PROMOTIONS ET RELATIONS (dépend des catégories, marques, produits)
        $this->command->info('🎉 Seeding des promotions...');
        $this->call(PromotionSeeder::class);
        $this->command->newLine();

        // RÉSUMÉ FINAL
        $this->command->info('✅ Seeding terminé avec succès !');
        $this->command->newLine();
        
        $this->displaySummary();
    }

    /**
     * Affiche un résumé des données créées
     */
    private function displaySummary(): void
    {
        $this->command->info('📊 RÉSUMÉ DES DONNÉES CRÉÉES :');
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $this->command->info('👥 UTILISATEURS :');
        $this->command->line('   • 1 Super Admin');
        $this->command->line('   • 1 Admin');
        $this->command->line('   • 8 Clients (2 VIP, 4 réguliers, 3 nouveaux, 1 inactif)');
        $this->command->newLine();
        
        $this->command->info('📂 CATÉGORIES :');
        $this->command->line('   • 13 catégories (5 principales + 8 sous-catégories)');
        $this->command->line('   • Hiérarchie complète : Parfums, Cosmétiques, Soins, etc.');
        $this->command->newLine();
        
        $this->command->info('🏷️ MARQUES :');
        $this->command->line('   • 16 marques (Chanel, Dior, Tom Ford, YSL, MAC, etc.)');
        $this->command->line('   • Mix luxe/premium et moyen de gamme');
        $this->command->newLine();
        
        $this->command->info('🛍️ PRODUITS :');
        $this->command->line('   • 9 produits complets avec toutes les métadonnées');
        $this->command->line('   • Parfums (homme/femme/unisexe), cosmétiques, soins');
        $this->command->line('   • Données SEO, stock, pricing, notes olfactives');
        $this->command->newLine();
        
        $this->command->info('📸 IMAGES :');
        $this->command->line('   • 25+ images produits avec variations (thumb, medium, large)');
        $this->command->line('   • Images principales, angles, lifestyle, packaging');
        $this->command->newLine();
        
        $this->command->info('⭐ AVIS CLIENTS :');
        $this->command->line('   • 22 avis clients authentiques');
        $this->command->line('   • Notes de 2 à 5 étoiles, avis vérifiés/non vérifiés');
        $this->command->line('   • Système de modération avec avis en attente');
        $this->command->newLine();
        
        $this->command->info('🎉 PROMOTIONS :');
        $this->command->line('   • 8 promotions variées (%, montant fixe, livraison gratuite, etc.)');
        $this->command->line('   • 15 codes promo actifs');
        $this->command->line('   • Relations complètes avec catégories, marques, produits');
        $this->command->newLine();
        
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🎯 DONNÉES PRÊTES POUR :');
        $this->command->line('   ✓ Tests fonctionnels complets');
        $this->command->line('   ✓ Démonstrations client');
        $this->command->line('   ✓ Interface admin opérationnelle');
        $this->command->line('   ✓ Système de commandes');
        $this->command->line('   ✓ Analytics et rapports');
        $this->command->newLine();
        
        $this->command->info('💡 COMPTES DE TEST DISPONIBLES :');
        $this->command->line('   • Super Admin : admin@beautystore.com / password123');
        $this->command->line('   • Admin : marie.dubois@beautystore.com / admin2024');
        $this->command->line('   • Client VIP : sophie.laurent@gmail.com / sophie2024');
        $this->command->line('   • Client Standard : camille.moreau@outlook.fr / camille123');
        $this->command->newLine();
    }
}