<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Promotion;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Carbon\Carbon;

class Promotions extends Component
{
    use WithPagination, WithFileUploads;

    // Propriétés de filtrage et recherche
    public $search = '';
    public $typeFilter = 'all'; // all, percentage, fixed_amount, free_shipping, buy_x_get_y
    public $statusFilter = 'all'; // all, active, inactive, scheduled, expired
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $dateFilter = 'all'; // all, current, upcoming, expired
    public $usageFilter = 'all'; // all, unused, partially_used, fully_used

    // Propriétés de modal et édition
    public $showModal = false;
    public $showDeleteModal = false;
    public $showPreviewModal = false;
    public $isEditing = false;
    public $selectedPromotionId = null;

    // Propriétés du formulaire promotion
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('required|in:percentage,fixed_amount,free_shipping,buy_x_get_y,bundle')]
    public $type = 'percentage';
    
    #[Validate('required|numeric|min:0')]
    public $value = '';
    
    #[Validate('nullable|numeric|min:0')]
    public $minimum_amount = '';
    
    #[Validate('nullable|numeric|min:0')]
    public $maximum_discount = '';
    
    #[Validate('required|date')]
    public $starts_at = '';
    
    #[Validate('nullable|date|after:starts_at')]
    public $ends_at = '';
    
    #[Validate('nullable|integer|min:0')]
    public $usage_limit = '';
    
    #[Validate('nullable|integer|min:0')]
    public $usage_limit_per_user = '';
    
    #[Validate('nullable|integer|min:0')]
    public $priority = 0;
    
    public $is_active = true;
    public $is_combinable = false;
    public $apply_to_shipping = false;
    
    // Codes promo
    public $codes = [];
    public $newCode = '';
    public $auto_generate_codes = false;
    public $codes_count = 1;
    
    // Conditions et restrictions
    public $applicable_categories = [];
    public $applicable_brands = [];
    public $applicable_products = [];
    public $excluded_categories = [];
    public $excluded_brands = [];
    public $excluded_products = [];
    public $applicable_user_groups = [];
    
    // Buy X Get Y spécifique
    public $buy_quantity = 1;
    public $get_quantity = 1;
    public $get_discount_type = 'percentage'; // percentage, fixed_amount, free
    public $get_discount_value = 0;
    
    // Bundle spécifique
    public $bundle_products = [];
    public $bundle_price = '';
    
    // Propriétés d'interface
    public $bulkSelected = [];
    public $selectAll = false;
    public $showFilters = false;
    public $viewMode = 'card'; // card, table
    public $showAdvancedOptions = false;
    
    // Preview
    public $previewData = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => 'all'],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'viewMode' => ['except' => 'card']
    ];

    // Types de promotion disponibles
    public $promotionTypes = [
        'percentage' => [
            'name' => 'Pourcentage',
            'description' => 'Réduction en pourcentage (ex: 20%)',
            'icon' => '📊',
            'example' => '20% de réduction'
        ],
        'fixed_amount' => [
            'name' => 'Montant fixe',
            'description' => 'Réduction d\'un montant fixe (ex: 10 FCFA)',
            'icon' => '💰',
            'example' => '10 FCFA de réduction'
        ],
        'free_shipping' => [
            'name' => 'Livraison gratuite',
            'description' => 'Annule les frais de livraison',
            'icon' => '🚚',
            'example' => 'Livraison offerte'
        ],
        'buy_x_get_y' => [
            'name' => 'Achetez X, obtenez Y',
            'description' => 'Offre spéciale sur quantité (ex: 3 pour 2)',
            'icon' => '🎯',
            'example' => 'Achetez 2, obtenez 1 gratuit'
        ],
        'bundle' => [
            'name' => 'Pack/Bundle',
            'description' => 'Prix spécial pour un lot de produits',
            'icon' => '📦',
            'example' => 'Pack 3 produits à 50 FCFA'
        ]
    ];

    public function mount()
    {
        $this->resetPage();
        $this->starts_at = now()->format('Y-m-d\TH:i');
    }

    

    public function getPromotions()
    {
        $query = Promotion::withCount(['usages', 'codes']);

        // Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('codes', function($codeQ) {
                      $codeQ->where('code', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtres
        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        if ($this->statusFilter !== 'all') {
            switch ($this->statusFilter) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('starts_at', '<=', now())
                          ->where(function($q) {
                              $q->whereNull('ends_at')
                                ->orWhere('ends_at', '>', now());
                          });
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'scheduled':
                    $query->where('is_active', true)
                          ->where('starts_at', '>', now());
                    break;
                case 'expired':
                    $query->where('ends_at', '<', now());
                    break;
            }
        }

        if ($this->dateFilter !== 'all') {
            switch ($this->dateFilter) {
                case 'current':
                    $query->where('starts_at', '<=', now())
                          ->where(function($q) {
                              $q->whereNull('ends_at')
                                ->orWhere('ends_at', '>', now());
                          });
                    break;
                case 'upcoming':
                    $query->where('starts_at', '>', now());
                    break;
                case 'expired':
                    $query->where('ends_at', '<', now());
                    break;
            }
        }

        if ($this->usageFilter !== 'all') {
            switch ($this->usageFilter) {
                case 'unused':
                    $query->whereDoesntHave('usages');
                    break;
                case 'partially_used':
                    $query->whereHas('usages')
                          ->where(function($q) {
                              $q->whereNull('usage_limit')
                                ->orWhereColumn('usage_count', '<', 'usage_limit');
                          });
                    break;
                case 'fully_used':
                    $query->whereNotNull('usage_limit')
                          ->whereColumn('usage_count', '>=', 'usage_limit');
                    break;
            }
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(12);
    }

    public function getPromotionStats()
    {
        $now = now();
        
        return [
            'total' => Promotion::count(),
            'active' => Promotion::where('is_active', true)
                ->where('starts_at', '<=', $now)
                ->where(function($q) use ($now) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', $now);
                })->count(),
            'scheduled' => Promotion::where('is_active', true)
                ->where('starts_at', '>', $now)->count(),
            'expired' => Promotion::where('ends_at', '<', $now)->count(),
            'used_this_month' => Promotion::whereHas('usages', function($q) {
                $q->whereMonth('created_at', now()->month);
            })->count(),
            'total_savings' => Promotion::whereHas('usages')->sum('total_savings') ?? 0,
            'most_used' => Promotion::withCount('usages')
                ->orderBy('usages_count', 'desc')->first()?->name ?? 'Aucune',
            'revenue_impact' => Promotion::sum('revenue_impact') ?? 0,
        ];
    }

    // Actions sur les filtres
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function clearFilters()
    {
        $this->reset([
            'search', 'typeFilter', 'statusFilter', 'dateFilter', 'usageFilter'
        ]);
        $this->resetPage();
    }

    // Gestion du mode d'affichage
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // Actions de tri
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Gestion de la modal
    public function openModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function editPromotion($promotionId)
    {
        $promotion = Promotion::with(['codes', 'categories', 'brands', 'products'])->findOrFail($promotionId);
        
        $this->selectedPromotionId = $promotion->id;
        $this->name = $promotion->name;
        $this->description = $promotion->description;
        $this->type = $promotion->type;
        $this->value = $promotion->value;
        $this->minimum_amount = $promotion->minimum_amount;
        $this->maximum_discount = $promotion->maximum_discount;
        $this->starts_at = $promotion->starts_at?->format('Y-m-d\TH:i');
        $this->ends_at = $promotion->ends_at?->format('Y-m-d\TH:i');
        $this->usage_limit = $promotion->usage_limit;
        $this->usage_limit_per_user = $promotion->usage_limit_per_user;
        $this->priority = $promotion->priority;
        $this->is_active = $promotion->is_active;
        $this->is_combinable = $promotion->is_combinable;
        $this->apply_to_shipping = $promotion->apply_to_shipping;
        
        // Codes
        $this->codes = $promotion->codes->pluck('code')->toArray();
        
        // Conditions
        $this->applicable_categories = $promotion->categories->pluck('id')->toArray();
        $this->applicable_brands = $promotion->brands->pluck('id')->toArray();
        $this->applicable_products = $promotion->products->pluck('id')->toArray();
        
        // Buy X Get Y
        $this->buy_quantity = $promotion->conditions['buy_quantity'] ?? 1;
        $this->get_quantity = $promotion->conditions['get_quantity'] ?? 1;
        $this->get_discount_type = $promotion->conditions['get_discount_type'] ?? 'percentage';
        $this->get_discount_value = $promotion->conditions['get_discount_value'] ?? 0;
        
        // Bundle
        $this->bundle_products = $promotion->conditions['bundle_products'] ?? [];
        $this->bundle_price = $promotion->conditions['bundle_price'] ?? '';
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'description', 'type', 'value', 'minimum_amount', 'maximum_discount',
            'starts_at', 'ends_at', 'usage_limit', 'usage_limit_per_user', 'priority',
            'is_active', 'is_combinable', 'apply_to_shipping', 'codes', 'newCode',
            'auto_generate_codes', 'codes_count', 'applicable_categories', 'applicable_brands',
            'applicable_products', 'excluded_categories', 'excluded_brands', 'excluded_products',
            'applicable_user_groups', 'buy_quantity', 'get_quantity', 'get_discount_type',
            'get_discount_value', 'bundle_products', 'bundle_price', 'selectedPromotionId'
        ]);
        $this->starts_at = now()->format('Y-m-d\TH:i');
        $this->type = 'percentage';
        $this->is_active = true;
        $this->buy_quantity = 1;
        $this->get_quantity = 1;
        $this->get_discount_type = 'percentage';
        $this->priority = 0;
    }

    // Gestion des codes promo
    public function addCode()
    {
        if ($this->newCode && !in_array($this->newCode, $this->codes)) {
            $this->codes[] = strtoupper($this->newCode);
            $this->newCode = '';
        }
    }

    public function removeCode($index)
    {
        unset($this->codes[$index]);
        $this->codes = array_values($this->codes);
    }

    public function generateCodes()
    {
        for ($i = 0; $i < $this->codes_count; $i++) {
            $code = $this->generateUniqueCode();
            if (!in_array($code, $this->codes)) {
                $this->codes[] = $code;
            }
        }
    }

    private function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Promotion::whereHas('codes', function($q) use ($code) {
            $q->where('code', $code);
        })->exists());
        
        return $code;
    }

    // Sauvegarde de la promotion
    public function savePromotion()
    {
        $this->validate();

        try {
            // Préparation des conditions selon le type
            $conditions = [];
            
            if ($this->type === 'buy_x_get_y') {
                $conditions = [
                    'buy_quantity' => $this->buy_quantity,
                    'get_quantity' => $this->get_quantity,
                    'get_discount_type' => $this->get_discount_type,
                    'get_discount_value' => $this->get_discount_value,
                ];
            } elseif ($this->type === 'bundle') {
                $conditions = [
                    'bundle_products' => $this->bundle_products,
                    'bundle_price' => $this->bundle_price,
                ];
            }

            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'type' => $this->type,
                'value' => $this->value,
                'minimum_amount' => $this->minimum_amount ?: null,
                'maximum_discount' => $this->maximum_discount ?: null,
                'starts_at' => $this->starts_at ? Carbon::parse($this->starts_at) : now(),
                'ends_at' => $this->ends_at ? Carbon::parse($this->ends_at) : null,
                'usage_limit' => $this->usage_limit ?: null,
                'usage_limit_per_user' => $this->usage_limit_per_user ?: null,
                'priority' => $this->priority,
                'is_active' => $this->is_active,
                'is_combinable' => $this->is_combinable,
                'apply_to_shipping' => $this->apply_to_shipping,
                'conditions' => $conditions,
            ];

            if ($this->isEditing) {
                $promotion = Promotion::findOrFail($this->selectedPromotionId);
                $promotion->update($data);
                $message = 'Promotion mise à jour avec succès !';
            } else {
                $promotion = Promotion::create($data);
                $message = 'Promotion créée avec succès !';
            }

            // Gestion des codes
            if (!empty($this->codes)) {
                $promotion->codes()->delete(); // Supprimer les anciens codes
                foreach ($this->codes as $code) {
                    $promotion->codes()->create(['code' => $code]);
                }
            }

            // Gestion des relations
            $promotion->categories()->sync($this->applicable_categories);
            $promotion->brands()->sync($this->applicable_brands);
            $promotion->products()->sync($this->applicable_products);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $message
            ]);

            $this->closeModal();
            $this->resetPage();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage()
            ]);
        }
    }

    // Suppression de promotion
    public function confirmDelete($promotionId)
    {
        $this->selectedPromotionId = $promotionId;
        $this->showDeleteModal = true;
    }

    public function deletePromotion()
    {
        try {
            $promotion = Promotion::findOrFail($this->selectedPromotionId);
            
            // Vérifier s'il y a des utilisations
            if ($promotion->usages()->count() > 0) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Impossible de supprimer une promotion qui a été utilisée.'
                ]);
                return;
            }
            
            $promotion->delete();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Promotion supprimée avec succès !'
            ]);

            $this->showDeleteModal = false;
            $this->resetPage();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ]);
        }
    }

    // Actions en lot
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->bulkSelected = $this->getPromotions()->pluck('id')->toArray();
        } else {
            $this->bulkSelected = [];
        }
    }

    public function bulkActivate()
    {
        Promotion::whereIn('id', $this->bulkSelected)->update(['is_active' => true]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' promotions activées !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDeactivate()
    {
        Promotion::whereIn('id', $this->bulkSelected)->update(['is_active' => false]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' promotions désactivées !'
        ]);
        $this->bulkSelected = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        $promotions = Promotion::whereIn('id', $this->bulkSelected)->withCount('usages')->get();
        
        foreach ($promotions as $promotion) {
            if ($promotion->usages_count > 0) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Certaines promotions ont été utilisées et ne peuvent être supprimées.'
                ]);
                return;
            }
        }

        Promotion::whereIn('id', $this->bulkSelected)->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => count($this->bulkSelected) . ' promotions supprimées !'
        ]);
        
        $this->bulkSelected = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    // Dupliquer une promotion
    public function duplicatePromotion($promotionId)
    {
        try {
            $originalPromotion = Promotion::with(['codes', 'categories', 'brands', 'products'])->findOrFail($promotionId);
            
            $newPromotion = $originalPromotion->replicate();
            $newPromotion->name = $originalPromotion->name . ' (Copie)';
            $newPromotion->slug = Str::slug($newPromotion->name);
            $newPromotion->is_active = false;
            $newPromotion->starts_at = now();
            $newPromotion->ends_at = null;
            $newPromotion->usage_count = 0;
            $newPromotion->save();

            // Dupliquer les relations
            $newPromotion->categories()->sync($originalPromotion->categories->pluck('id'));
            $newPromotion->brands()->sync($originalPromotion->brands->pluck('id'));
            $newPromotion->products()->sync($originalPromotion->products->pluck('id'));

            // Dupliquer les codes avec nouveau suffixe
            foreach ($originalPromotion->codes as $code) {
                $newCode = $code->code . '-COPY';
                $newPromotion->codes()->create(['code' => $newCode]);
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Promotion dupliquée avec succès !'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erreur lors de la duplication : ' . $e->getMessage()
            ]);
        }
    }

    // Toggle statut actif
    public function toggleStatus($promotionId)
    {
        $promotion = Promotion::findOrFail($promotionId);
        $promotion->update(['is_active' => !$promotion->is_active]);
        
        $status = $promotion->is_active ? 'activée' : 'désactivée';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Promotion {$status} !"
        ]);
    }

    // Prévisualisation
    public function previewPromotion($promotionId = null)
    {
        if ($promotionId) {
            $promotion = Promotion::findOrFail($promotionId);
            $this->previewData = $promotion->toArray();
        } else {
            // Prévisualisation du formulaire actuel
            $this->previewData = [
                'name' => $this->name,
                'type' => $this->type,
                'value' => $this->value,
                'minimum_amount' => $this->minimum_amount,
                'codes' => $this->codes,
            ];
        }
        
        $this->showPreviewModal = true;
    }

    // Calculer l'impact d'une promotion
    public function calculatePromotionImpact($promotionId)
    {
        $promotion = Promotion::withCount('usages')->findOrFail($promotionId);
        
        // Logique de calcul d'impact basée sur le type de promotion
        $impact = [
            'usage_count' => $promotion->usages_count,
            'total_savings' => $promotion->total_savings ?? 0,
            'revenue_impact' => $promotion->revenue_impact ?? 0,
            'conversion_rate' => $this->calculateConversionRate($promotion),
        ];
        
        return $impact;
    }

    private function calculateConversionRate($promotion)
    {
        // Logique simplifiée - à adapter selon vos besoins
        $views = $promotion->views_count ?? 1;
        $uses = $promotion->usages_count ?? 0;
        
        return $views > 0 ? round(($uses / $views) * 100, 2) : 0;
    }

    // Mise à jour en temps réel des filtres
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function updatedUsageFilter()
    {
        $this->resetPage();
    }

    // Validation en temps réel
    public function updatedValue()
    {
        if ($this->type === 'percentage' && $this->value > 100) {
            $this->value = 100;
        }
    }

    public function updatedType()
    {
        // Reset des valeurs spécifiques au type
        if ($this->type !== 'buy_x_get_y') {
            $this->buy_quantity = 1;
            $this->get_quantity = 1;
            $this->get_discount_type = 'percentage';
            $this->get_discount_value = 0;
        }
        
        if ($this->type !== 'bundle') {
            $this->bundle_products = [];
            $this->bundle_price = '';
        }
    }

    public function render()
    {
        $promotions = $this->getPromotions();
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->limit(100)->get();
        $stats = $this->getPromotionStats();

        return view('livewire.admin.promotions', [
            'promotions' => $promotions,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'stats' => $stats,
            'promotionTypes' => $this->promotionTypes
        ])->layout('layout.admin');
    }
}