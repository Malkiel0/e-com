<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductObserver
{


    public function creating(Product $product)
    {
        if (empty($product->sku)) {
            $product->sku = 'BF-' . strtoupper(Str::random(8));
        }
    }

    public function created(Product $product)
    {
        $product->category->updateProductsCount();
        $product->brand->updateProductsCount();
    }

    public function updated(Product $product)
    {
        if ($product->wasChanged('category_id')) {
            $product->category->updateProductsCount();
            if ($product->getOriginal('category_id')) {
                Category::find($product->getOriginal('category_id'))->updateProductsCount();
            }
        }
    }

    public function deleted(Product $product)
    {
        $product->category->updateProductsCount();
        $product->brand->updateProductsCount();
    }
    

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $product->category->updateProductsCount();
        $product->brand->updateProductsCount();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $product->category->updateProductsCount();
        $product->brand->updateProductsCount();
    }
}
