{{-- Layout Admin Complet - admin.blade.php --}}
@extends('layout.base')

{{-- Configuration spécifique admin --}}
@section('styles')
<!-- Chart.js pour les graphiques admin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<!-- Styles spécifiques admin -->
<style>
    /* Variables CSS pour l'admin */
    :root {
        --admin-primary: #6366F1;
        --admin-secondary: #8B5CF6;
        --admin-success: #10B981;
        --admin-warning: #F59E0B;
        --admin-danger: #EF4444;
        --admin-dark: #1F2937;
        --admin-sidebar-width: 16rem;
    }
    
    /* Styles pour les graphiques */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    /* Animations pour les statistiques */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    /* Styles pour les tableaux admin */
    .admin-table {
        @apply w-full bg-white rounded-xl shadow-sm overflow-hidden;
    }
    
    .admin-table th {
        @apply bg-gray-50 px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider border-b border-gray-200;
    }
    
    .admin-table td {
        @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-100;
    }
    
    .admin-table tr:hover {
        @apply bg-gray-50;
    }
    
    /* Badges de statut */
    .status-badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }
    
    .status-pending { @apply bg-yellow-100 text-yellow-800; }
    .status-processing { @apply bg-blue-100 text-blue-800; }
    .status-completed { @apply bg-green-100 text-green-800; }
    .status-cancelled { @apply bg-red-100 text-red-800; }
    
    /* Formulaires admin */
    .admin-form-group {
        @apply mb-6;
    }
    
    .admin-label {
        @apply block text-sm font-semibold text-gray-700 mb-2;
    }
    
    .admin-input {
        @apply w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all;
    }
    
    .admin-select {
        @apply w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all;
    }
    
    .admin-textarea {
        @apply w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all resize-none;
    }
    
    /* Boutons admin */
    .btn-admin-primary {
        @apply bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg hover:shadow-xl;
    }
    
    .btn-admin-secondary {
        @apply bg-gray-200 hover:bg-gray-300 text-gray-900 px-6 py-3 rounded-xl font-semibold transition-all;
    }
    
    .btn-admin-danger {
        @apply bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all;
    }
    
    /* Zone de drop pour l'upload */
    .drop-zone {
        @apply border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-indigo-400 transition-colors cursor-pointer;
    }
    
    .drop-zone.drag-over {
        @apply border-indigo-500 bg-indigo-50;
    }
    
    /* Indicateurs de chargement */
    .loading-spinner {
        @apply inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .admin-sidebar {
            transform: translateX(-100%);
        }
        
        .admin-sidebar.open {
            transform: translateX(0);
        }
        
        .admin-main {
            margin-left: 0;
        }
    }
</style>
@endsection

{{-- Header admin complet --}}
@section('header')
    @include('layout.partials.header.common')
    @include('layout.partials.header.admin')
@endsection

{{-- Sidebar admin --}}
@section('sidebar')
    @include('layout.partials.sidebar.admin')
@endsection

{{-- Contenu principal admin --}}
@section('content')
<div class="admin-content">
    {{-- Fil d'Ariane --}}
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="" class="hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                    </svg>
                </a>
            </li>
            @foreach($breadcrumbs as $breadcrumb)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    @if(isset($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}" class="hover:text-indigo-600 transition-colors">
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
    
    {{-- Titre de page avec actions --}}
    @if(isset($pageTitle))
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $pageTitle }}</h1>
            @if(isset($pageDescription))
                <p class="text-gray-600 mt-2">{{ $pageDescription }}</p>
            @endif
        </div>
        
        @if(isset($pageActions))
            <div class="flex items-center space-x-3">
                @foreach($pageActions as $action)
                    <a href="{{ $action['url'] }}" 
                       class="btn-admin-primary flex items-center space-x-2">
                        @if(isset($action['icon']))
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $action['icon'] !!}
                            </svg>
                        @endif
                        <span>{{ $action['title'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    @endif
    
    {{-- Messages de notification --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center space-x-3">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-green-900">Succès</h3>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-center space-x-3">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-red-900">Erreur</h3>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    
    @if(session('warning'))
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6 flex items-center space-x-3">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.598 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-yellow-900">Attention</h3>
                <p class="text-yellow-700">{{ session('warning') }}</p>
            </div>
        </div>
    @endif
    
    {{-- Contenu principal de la page --}}
    {{ $slot }}
    
    {{-- Modals communes --}}
    @stack('modals')
</div>
@endsection

{{-- Footer admin --}}
@section('footer')
    @include('layout.partials.footer.common')
@endsection

{{-- Scripts admin --}}
@section('scripts')
    @include('layout.partials.scripts.admin')
    
    <!-- Scripts spécifiques à la page -->
    @stack('scripts')
    
    <!-- Initialisation globale admin -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation spécifique admin
            if (window.AdminStore) {
                AdminStore.init();
            }
            
            // Gestion des formulaires avec auto-sauvegarde
            document.querySelectorAll('form.auto-save').forEach(form => {
                form.classList.add('admin-form');
            });
            
            // Configuration des tooltips
            document.querySelectorAll('[data-tooltip]').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    // Logique de tooltip
                });
            });
            
            // Confirmation de suppression
            document.querySelectorAll('[data-confirm-delete]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
                        if (this.closest('form')) {
                            this.closest('form').submit();
                        } else if (this.href) {
                            window.location.href = this.href;
                        }
                    }
                });
            });
            
            // Gestion des tableaux avec tri
            document.querySelectorAll('.sortable-table th[data-sort]').forEach(header => {
                header.addEventListener('click', function() {
                    const table = this.closest('table');
                    const column = this.dataset.sort;
                    // Logique de tri
                });
            });
        });
    </script>
@endsection