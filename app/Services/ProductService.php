<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductService
{
    public function create(array $data, int $vendorId): Product
    {
        try {
            return DB::transaction(function () use ($data, $vendorId) {

                if (isset($data['image'])) {
                    $data['image_path'] = $data['image']->store('products', 'public');
                }

                return Product::create([
                    ...$data,
                    'vendor_id' => $vendorId,
                ]);
            });

        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to create product.');
        }
    }

    public function update(Product $product, array $data): Product
    {
        try {
            return DB::transaction(function () use ($product, $data) {

                if (isset($data['image'])) {
                    if ($product->image_path) {
                        Storage::disk('public')->delete($product->image_path);
                    }

                    $data['image_path'] = $data['image']->store('products', 'public');
                }

                $product->update($data);

                return $product;
            });

        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to update product.');
        }
    }

    public function delete(Product $product): void
    {
        try {
            DB::transaction(function () use ($product) {
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }

                $product->delete();
            });

        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to delete product.');
        }
    }
}
