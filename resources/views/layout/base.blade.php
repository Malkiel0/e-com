<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Découvrez notre collection exclusive de parfums et produits de beauté' }}">
    <meta name="theme-color" content="#8B5CF6">
    
    <title>{{ $title ?? 'Beauty & Fragrance - Votre boutique de rêve' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    
    <!-- Custom CSS pour les animations -->
    <style>
        :root {
            --primary-perfume: #8B5CF6;
            --primary-beauty: #EC4899;
            --gradient-perfume: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
            --gradient-beauty: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
            --shadow-glow: 0 0 30px rgba(139, 92, 246, 0.3);
        }
        
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
        
        /* Animations de chargement */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }
        
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader-content {
            text-align: center;
            color: white;
        }
        
        .pulse-ring {
            width: 80px;
            height: 80px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: relative;
            margin: 0 auto 20px;
            animation: pulse-ring 1.5s ease-in-out infinite;
        }
        
        .pulse-ring::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            background: var(--gradient-perfume);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes pulse-dot {
            0% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(0.8); }
            100% { transform: translate(-50%, -50%) scale(1); }
        }
        
        /* Animations d'entrée */
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out forwards;
            transform: translateX(-50px);
            opacity: 0;
        }
        
        .slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
            transform: translateX(50px);
            opacity: 0;
        }
        
        .scale-in {
            animation: scaleIn 0.6s ease-out forwards;
            transform: scale(0.9);
            opacity: 0;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInRight {
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes scaleIn {
            to { transform: scale(1); opacity: 1; }
        }
        
        /* Effets de survol magiques */
        .magic-hover {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .magic-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Gradient de fond personnalisé */
        .bg-gradient-custom {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
        }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gradient-perfume);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-beauty);
        }
    </style>
    
    @yield('styles')
</head>
<body class="font-body bg-gradient-custom min-h-screen overflow-x-hidden" x-data="{ 
    pageLoaded: false, 
    currentTime: new Date().getHours(),
    greeting: function() {
        if (this.currentTime < 12) return 'Bonjour';
        if (this.currentTime < 18) return 'Bon après-midi';
        return 'Bonsoir';
    }
}" x-init="
    // Simulation de chargement
    setTimeout(() => {
        pageLoaded = true;
        document.querySelector('.page-loader').classList.add('hidden');
    }, 2000);
">
    
    <!-- Loader de page -->
    <div class="page-loader" x-show="!pageLoaded">
        <div class="loader-content">
            <div class="pulse-ring"></div>
            <h3 class="text-2xl font-display font-semibold mb-2">Beauty & Fragrance</h3>
            <p class="text-sm opacity-80">Chargement de votre expérience magique...</p>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div x-show="pageLoaded" x-transition:enter="fade-in">
        
        <!-- Header -->
        @yield('header')
        
        <!-- Conteneur principal avec sidebar conditionnelle -->
        <div class="flex min-h-screen relative">
            
            <!-- Sidebar (si présente) -->
            @hasSection('sidebar')
                <aside class="w-64 lg:w-72 fixed lg:relative top-0 left-0 h-full bg-white shadow-xl z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out slide-in-left" 
                       x-data="{ open: false }" 
                       :class="{ 'translate-x-0': open }"
                       id="sidebar">
                    @yield('sidebar')
                </aside>
                
                <!-- Overlay pour mobile -->
                <div class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" 
                     x-show="open" 
                     @click="open = false"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"></div>
            @endif
            
            <!-- Zone de contenu principal -->
            <main class="flex-1 min-h-screen bg-gradient-custom transition-all duration-300 ease-in-out scale-in">
                
                <!-- Conteneur avec padding adaptatif -->
                <div class="@hasSection('sidebar') ml-0 lg:ml-0 @endif p-4 lg:p-8">
                    
                    <!-- Message de bienvenue dynamique -->
                    <div class="mb-6 bg-white/70 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-white/20 fade-in">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-gray-700 font-medium" x-text="greeting() + ' ! Bienvenue dans votre univers beauté ✨'"></span>
                        </div>
                    </div>
                    
                    <!-- Contenu de la page -->
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        <!-- Footer -->
        @yield('footer')
        
        <!-- Bouton de retour en haut -->
        <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="fixed bottom-8 right-8 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 z-30 magic-hover"
                x-show="window.pageYOffset > 300"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-75"
                x-transition:enter-end="opacity-100 scale-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>
    </div>
    
    <!-- Scripts -->
    @livewireScripts
    
    <!-- Alpine.js (CDN) -->
    {{--
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    --}}
    <!--
        Si tu utilises Vite pour importer Alpine dans app.js, laisse ce script commenté.
        Si tu préfères le CDN, décommente la ligne ci-dessus.
        (Actuellement, Alpine n'est PAS importé dans app.js, donc tu peux activer le CDN si besoin)
    -->
    
    <!-- Script pour les animations au scroll -->
    <script>
        // Observer pour les animations au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        // Observer tous les éléments avec la classe 'observe'
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.observe').forEach(el => {
                observer.observe(el);
            });
        });
        
        // Gestion du sidebar mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
            }
        }
    </script>
    
    @yield('scripts')
    @stack('scripts')
    
</body>
</html>