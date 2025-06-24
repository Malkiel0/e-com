<!-- Footer Commun - Ancrage et Confiance -->
<footer class="bg-gradient-to-br from-gray-900 via-purple-900 to-pink-900 text-white relative overflow-hidden">
    
    <!-- Particules animées en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-2 h-2 bg-purple-400 rounded-full animate-ping opacity-20"></div>
        <div class="absolute top-32 right-20 w-3 h-3 bg-pink-400 rounded-full animate-pulse opacity-30"></div>
        <div class="absolute bottom-20 left-1/4 w-1 h-1 bg-white rounded-full animate-pulse opacity-40"></div>
        <div class="absolute bottom-40 right-1/3 w-2 h-2 bg-purple-300 rounded-full animate-ping opacity-25"></div>
    </div>
    
    <div class="relative">
        <!-- Section newsletter -->
        <div class="border-b border-white/10">
            <div class="container mx-auto px-4 lg:px-8 py-12">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="mb-6">
                        <h2 class="text-3xl lg:text-4xl font-display font-bold mb-4 bg-gradient-to-r from-purple-300 to-pink-300 bg-clip-text text-transparent">
                            Restez à la pointe de la beauté
                        </h2>
                        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                            Découvrez en avant-première nos nouveautés, bénéficiez d'offres exclusives et recevez nos conseils beauté personnalisés directement dans votre boîte mail.
                        </p>
                    </div>
                    
                    <!-- Formulaire newsletter -->
                    <div class="max-w-md mx-auto" x-data="{ email: '', subscribed: false }">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative">
                                <input type="email" 
                                       x-model="email"
                                       placeholder="Votre adresse email"
                                       class="w-full px-4 py-3 pl-12 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent outline-none backdrop-blur-sm transition-all">
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <button @click="subscribed = true" 
                                    :disabled="subscribed"
                                    class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg">
                                <span x-show="!subscribed">S'abonner</span>
                                <span x-show="subscribed" class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Abonné !
                                </span>
                            </button>
                        </div>
                        
                        <!-- Message de confirmation -->
                        <div x-show="subscribed" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-4 p-3 bg-green-500/20 border border-green-400/30 rounded-lg text-green-300 text-sm">
                            🎉 Merci ! Vous recevrez bientôt notre première newsletter avec une offre spéciale de bienvenue.
                        </div>
                        
                        <p class="text-xs text-gray-400 mt-3">
                            En vous abonnant, vous acceptez de recevoir nos communications. Désabonnement possible à tout moment.
                        </p>
                    </div>
                    
                    <!-- Avantages de l'abonnement -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="flex items-center justify-center md:justify-start space-x-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center">
                                <span class="text-lg">🎁</span>
                            </div>
                            <div class="text-left">
                                <h4 class="font-semibold text-sm">Offres exclusives</h4>
                                <p class="text-xs text-gray-400">Réductions privilèges</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center md:justify-start space-x-3">
                            <div class="w-10 h-10 bg-pink-500/20 rounded-full flex items-center justify-center">
                                <span class="text-lg">✨</span>
                            </div>
                            <div class="text-left">
                                <h4 class="font-semibold text-sm">Nouveautés en avant-première</h4>
                                <p class="text-xs text-gray-400">Soyez les premiers informés</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center md:justify-start space-x-3">
                            <div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center">
                                <span class="text-lg">💡</span>
                            </div>
                            <div class="text-left">
                                <h4 class="font-semibold text-sm">Conseils personnalisés</h4>
                                <p class="text-xs text-gray-400">Par nos experts beauté</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liens principaux -->
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- À propos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">À propos de nous</h3>
                    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                        Beauty & Fragrance, votre destination privilégiée pour découvrir les plus belles créations de parfumerie et cosmétique. Une sélection exigeante pour révéler votre beauté unique.
                    </p>
                    <div class="flex space-x-3">
                        <!-- Réseaux sociaux -->
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-purple-500/30 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-pink-500/30 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.748-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-blue-500/30 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Navigation rapide -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="" class="text-gray-300 hover:text-purple-300 transition-colors text-sm">Accueil</a></li>
                        <li><a href="" class="text-gray-300 hover:text-purple-300 transition-colors text-sm">Parfums</a></li>
                        <li><a href="" class="text-gray-300 hover:text-pink-300 transition-colors text-sm">Produits de Beauté</a></li>
                        <li><a href="" class="text-gray-300 hover:text-indigo-300 transition-colors text-sm">Nouveautés</a></li>
                        <li><a href="" class="text-gray-300 hover:text-red-300 transition-colors text-sm">Promotions</a></li>
                        <li><a href="" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Nos Marques</a></li>
                    </ul>
                </div>
                
                <!-- Service client -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Service Client</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <span class="text-green-400">📱</span>
                            <div>
                                <a href="https://wa.me/YOUR_WHATSAPP_NUMBER" 
                                   target="_blank"
                                   class="text-gray-300 hover:text-green-300 transition-colors text-sm">
                                    WhatsApp Business
                                </a>
                                <p class="text-xs text-gray-400">Réponse rapide garantie</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="text-blue-400">📧</span>
                            <div>
                                <a href="mailto:contact@beautyframance.com" 
                                   class="text-gray-300 hover:text-blue-300 transition-colors text-sm">
                                    contact@beautyfragrance.com
                                </a>
                                <p class="text-xs text-gray-400">Réponse sous 24h</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="text-purple-400">🕒</span>
                            <div>
                                <span class="text-gray-300 text-sm">Lun-Sam: 9h-19h</span>
                                <p class="text-xs text-gray-400">Service client dédié</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Informations légales -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Informations</h3>
                    <ul class="space-y-2">
                        <li><a href="" class="text-gray-300 hover:text-purple-300 transition-colors text-sm">À propos</a></li>
                        <li><a href="" class="text-gray-300 hover:text-green-300 transition-colors text-sm">Livraison & Retours</a></li>
                        <li><a href="" class="text-gray-300 hover:text-blue-300 transition-colors text-sm">FAQ</a></li>
                        <li><a href="" class="text-gray-300 hover:text-pink-300 transition-colors text-sm">Politique de confidentialité</a></li>
                        <li><a href="" class="text-gray-300 hover:text-indigo-300 transition-colors text-sm">Conditions générales</a></li>
                        <li><a href="" class="text-gray-300 hover:text-yellow-300 transition-colors text-sm">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Garanties et certifications -->
        <div class="border-t border-white/10">
            <div class="container mx-auto px-4 lg:px-8 py-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">🚚</span>
                        </div>
                        <h4 class="font-semibold text-sm text-white mb-1">Livraison Gratuite</h4>
                        <p class="text-xs text-gray-400">Dès 50€ d'achat</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">🛡️</span>
                        </div>
                        <h4 class="font-semibold text-sm text-white mb-1">Paiement Sécurisé</h4>
                        <p class="text-xs text-gray-400">Via WhatsApp Business</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">✨</span>
                        </div>
                        <h4 class="font-semibold text-sm text-white mb-1">Produits Authentiques</h4>
                        <p class="text-xs text-gray-400">Garantie d'authenticité</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-pink-500/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">💝</span>
                        </div>
                        <h4 class="font-semibold text-sm text-white mb-1">Échantillons Offerts</h4>
                        <p class="text-xs text-gray-400">Avec chaque commande</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-white/10">
            <div class="container mx-auto px-4 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            B&F
                        </div>
                        <p class="text-gray-400 text-sm">
                            © 2025 Beauty & Fragrance. Tous droits réservés.
                        </p>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                        <span>Made with ❤️ in France</span>
                        <div class="flex items-center space-x-2">
                            <span>Powered by</span>
                            <span class="text-purple-300 font-semibold">Laravel ⚡</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>