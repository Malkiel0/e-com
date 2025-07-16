{{-- Layout Client Complet - client.blade.php --}}
@extends('layout.base')

{{-- Configuration spécifique client/e-commerce --}}
@section('styles')
<!-- Swiper.js pour les carrousels produits -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.css">

<!-- Styles spécifiques e-commerce -->
<style>
    /* Variables CSS pour l'e-commerce */
    :root {
        --ecommerce-primary: #8B5CF6;
        --ecommerce-secondary: #EC4899;
        --ecommerce-accent: #06B6D4;
        --ecommerce-success: #10B981;
        --ecommerce-warning: #F59E0B;
        --ecommerce-gradient-perfume: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
        --ecommerce-gradient-beauty: linear-gradient(135deg, #EC4899 0%, #F97316 100%);
        --product-card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --product-card-hover-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    /* Styles pour les cartes produit */
    .product-card {
        @apply bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer;
        box-shadow: var(--product-card-shadow);
    }
    
    .product-card:hover {
        box-shadow: var(--product-card-hover-shadow);
    }
    
    .product-card .product-image {
        @apply relative overflow-hidden;
        padding-bottom: 100%; /* Ratio 1:1 */
    }
    
    .product-card .product-image img {
        @apply absolute inset-0 w-full h-full object-cover transition-transform duration-500;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-card .product-badge {
        @apply absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold text-white z-10;
    }
    
    .product-badge.new {
        background: var(--ecommerce-gradient-perfume);
    }
    
    .product-badge.sale {
        background: linear-gradient(135deg, #EF4444 0%, #F97316 100%);
    }
    
    .product-badge.bestseller {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }
    
    /* Actions sur les cartes produit */
    .product-actions {
        @apply absolute top-3 right-3 flex flex-col space-y-2 opacity-0 transition-opacity duration-300;
    }
    
    .product-card:hover .product-actions {
        @apply opacity-100;
    }
    
    .product-action-btn {
        @apply w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-purple-600 hover:bg-white transition-all transform hover:scale-110 shadow-lg;
    }
    
    /* Informations produit */
    .product-info {
        @apply p-4;
    }
    
    .product-title {
        @apply font-semibold text-gray-900 mb-2 line-clamp-2;
    }
    
    .product-brand {
        @apply text-sm text-gray-500 mb-1;
    }
    
    .product-price {
        @apply flex items-center space-x-2 mb-3;
    }
    
    .product-price .current-price {
        @apply text-lg font-bold text-gray-900;
    }
    
    .product-price .original-price {
        @apply text-sm text-gray-500 line-through;
    }
    
    .product-price .discount {
        @apply text-sm font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full;
    }
    
    /* Évaluations */
    .product-rating {
        @apply flex items-center space-x-1 mb-3;
    }
    
    .rating-stars {
        @apply flex items-center space-x-0.5;
    }
    
    .rating-star {
        @apply w-4 h-4 text-yellow-400;
    }
    
    .rating-count {
        @apply text-sm text-gray-500 ml-2;
    }
    
    /* Boutons d'ajout au panier */
    .add-to-cart-btn {
        @apply w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white py-3 px-4 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2;
    }
    
    .quick-add-btn {
        @apply bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 py-2 px-4 rounded-lg font-medium transition-all text-sm;
    }
    
    /* Filtres et tri */
    .filter-section {
        @apply bg-white rounded-xl p-6 shadow-sm border border-gray-100;
    }
    
    .filter-title {
        @apply font-semibold text-gray-900 mb-4 flex items-center justify-between;
    }
    
    .filter-options {
        @apply space-y-3;
    }
    
    .filter-option {
        @apply flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors;
    }
    
    .filter-checkbox {
        @apply w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500;
    }
    
    /* Pagination */
    .pagination {
        @apply flex items-center justify-center space-x-2 mt-8;
    }
    
    .pagination-btn {
        @apply w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center text-gray-700 hover:bg-purple-50 hover:border-purple-300 hover:text-purple-600 transition-all;
    }
    
    .pagination-btn.active {
        @apply bg-purple-600 border-purple-600 text-white;
    }
    
    /* Carrousel de produits */
    .product-carousel .swiper-slide {
        @apply h-auto;
    }
    
    .product-carousel .swiper-button-next,
    .product-carousel .swiper-button-prev {
        @apply w-12 h-12 rounded-full bg-white shadow-lg;
        color: var(--ecommerce-primary);
    }
    
    .product-carousel .swiper-pagination-bullet-active {
        background: var(--ecommerce-primary);
    }
    
    /* Quick view modal */
    .quick-view-modal {
        @apply fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4;
    }
    
    .quick-view-content {
        @apply bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto;
    }
    
    /* Zoom d'image produit */
    .product-image-zoom {
        @apply relative overflow-hidden cursor-zoom-in;
    }
    
    .product-image-zoom img {
        @apply transition-transform duration-300;
    }
    
    .product-image-zoom:hover img {
        transform: scale(1.5);
    }
    
    /* Catégories */
    .category-card {
        @apply relative rounded-2xl overflow-hidden cursor-pointer transform transition-all duration-300 hover:scale-105;
        min-height: 200px;
    }
    
    .category-card .category-bg {
        @apply absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-400;
    }
    
    .category-card.perfume .category-bg {
        background: var(--ecommerce-gradient-perfume);
    }
    
    .category-card.beauty .category-bg {
        background: var(--ecommerce-gradient-beauty);
    }
    
    .category-card .category-content {
        @apply relative z-10 p-6 h-full flex flex-col justify-end text-white;
    }
    
    .category-title {
        @apply text-2xl font-bold mb-2;
    }
    
    .category-subtitle {
        @apply text-white/90 mb-4;
    }
    
    .category-cta {
        @apply inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium hover:bg-white/30 transition-all;
    }
    
    /* Bannières promotionnelles */
    .promo-banner {
        @apply relative rounded-2xl overflow-hidden;
    }
    
    .promo-banner .promo-bg {
        @apply absolute inset-0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .promo-banner .promo-content {
        @apply relative z-10 p-8 text-white;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .product-card .product-image {
            padding-bottom: 75%; /* Ratio plus large sur mobile */
        }
        
        .product-actions {
            @apply opacity-100; /* Toujours visible sur mobile */
        }
        
        .filter-section {
            @apply p-4;
        }
    }
    
    /* Animations personnalisées */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .floating-element {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Utilitaires */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

{{-- Header e-commerce complet --}}
@section('header')
    @include('layout.partials.header.common')
    @include('layout.partials.header.client')
@endsection

{{-- Sidebar navigation produits --}}
{{-- @section('sidebar')
    @include('layout.partials.sidebar.client')
@endsection --}}

{{-- Contenu principal e-commerce --}}
@section('content')
<div class="ecommerce-content">
    {{-- Fil d'Ariane e-commerce --}}
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="" class="hover:text-purple-600 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Accueil
                </a>
            </li>
            @foreach($breadcrumbs as $breadcrumb)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    @if(isset($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}" class="hover:text-purple-600 transition-colors">
                            {{ $breadcrumb['title'] }}
                        </a>
                    @else
                        <span class="text-gray-900 font-medium">{{ $breadcrumb['title'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
    @endif
    
    {{-- Titre de page avec filtres --}}
    @if(isset($pageTitle))
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8">
        <div class="mb-4 lg:mb-0">
            <h1 class="text-2xl lg:text-3xl font-display font-bold text-gray-900">{{ $pageTitle }}</h1>
            @if(isset($pageDescription))
                <p class="text-gray-600 mt-2">{{ $pageDescription }}</p>
            @endif
            @if(isset($productCount))
                <p class="text-sm text-gray-500 mt-1">{{ $productCount }} produit{{ $productCount > 1 ? 's' : '' }} trouvé{{ $productCount > 1 ? 's' : '' }}</p>
            @endif
        </div>
        
        {{-- Contrôles de tri et affichage --}}
        <div class="flex items-center space-x-4">
            {{-- Vue grille/liste --}}
            <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                <button class="p-2 rounded-md bg-white shadow-sm text-gray-600" title="Vue grille">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button class="p-2 rounded-md text-gray-400" title="Vue liste">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Tri --}}
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-sm">
                <option>Trier par pertinence</option>
                <option>Prix croissant</option>
                <option>Prix décroissant</option>
                <option>Nouveautés</option>
                <option>Meilleures ventes</option>
                <option>Mieux notés</option>
            </select>
        </div>
    </div>
    @endif
    
    {{-- Messages flash --}}
    @if(session('cart_success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center space-x-3">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-green-900">Produit ajouté au panier !</h3>
                <p class="text-green-700">{{ session('cart_success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
    
    {{-- Contenu principal de la page --}}
    {{ $slot }}
    
    {{-- Section "Vu récemment" si applicable --}}
    @if(isset($recentlyViewed) && count($recentlyViewed) > 0)
    <section class="mt-12 pt-8 border-t border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Vu récemment</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($recentlyViewed as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title text-sm">{{ $product->name }}</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $product->price }}FCFA</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    
    {{-- Modals et overlays --}}
    @stack('modals')
</div>
@endsection

{{-- Footer e-commerce --}}
@section('footer')
    @include('layout.partials.footer.common')
@endsection

{{-- Scripts e-commerce --}}
@section('scripts')
    @include('layout.partials.scripts.client')
    
    <!-- Swiper.js pour les carrousels -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js"></script>
    
    <!-- Scripts spécifiques à la page -->
    @stack('scripts')
    
    <!-- Initialisation globale e-commerce -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation du store e-commerce
            if (window.BeautyStore) {
                BeautyStore.init();
            }
            
            // Initialisation des carrousels Swiper
            const productCarousels = document.querySelectorAll('.product-carousel .swiper');
            productCarousels.forEach(carousel => {
                new Swiper(carousel, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: carousel.parentElement.querySelector('.swiper-button-next'),
                        prevEl: carousel.parentElement.querySelector('.swiper-button-prev'),
                    },
                    pagination: {
                        el: carousel.parentElement.querySelector('.swiper-pagination'),
                        clickable: true,
                    },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        768: { slidesPerView: 3 },
                        1024: { slidesPerView: 4 },
                    }
                });
            });
            
            // Gestion des boutons d'ajout au panier
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const productCard = this.closest('.product-card');
                    const productData = JSON.parse(productCard.dataset.product || '{}');
                    
                    if (window.BeautyStore && productData.id) {
                        BeautyStore.cart.add(productData);
                        
                        // Animation du bouton
                        this.innerHTML = '<span class="loading-spinner"></span> Ajouté !';
                        this.disabled = true;
                        
                        setTimeout(() => {
                            this.innerHTML = 'Ajouter au panier';
                            this.disabled = false;
                        }, 2000);
                    }
                });
            });
            
            // Gestion des favoris
            document.querySelectorAll('.wishlist-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const productCard = this.closest('.product-card');
                    const productData = JSON.parse(productCard.dataset.product || '{}');
                    
                    if (window.BeautyStore && productData.id) {
                        BeautyStore.wishlist.toggle(productData);
                        
                        // Basculer l'apparence du bouton
                        const icon = this.querySelector('svg');
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                            icon.style.fill = 'none';
                        } else {
                            this.classList.add('active');
                            icon.style.fill = 'currentColor';
                        }
                    }
                });
            });
            
            // Lazy loading des images produit
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
            
            // Filtrage et recherche en temps réel
            const searchInput = document.querySelector('#product-search');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (window.SearchManager) {
                            SearchManager.performSearch(this.value);
                        }
                    }, 300);
                });
            }
            
            // Animation d'entrée pour les cartes produit
            const productCards = document.querySelectorAll('.product-card');
            const cardObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                        cardObserver.unobserve(entry.target);
                    }
                });
            });
            
            productCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                cardObserver.observe(card);
            });
        });
    </script>
@endsection