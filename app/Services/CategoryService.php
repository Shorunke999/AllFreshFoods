<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryService
{
    public function create(array $data): Category
    {
        try {
            return DB::transaction(fn () =>
                Category::create($data)
            );
        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to create category.');
        }
    }

    public function update(Category $category, array $data): Category
    {
        try {
            return DB::transaction(function () use ($category, $data) {
                $category->update($data);
                return $category;
            });
        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to update category.');
        }
    }

    public function delete(Category $category): void
    {
        try {
            if ($category->products()->exists()) {
                throw new \RuntimeException(
                    'Cannot delete category with existing products.'
                );
            }

            $category->delete();

        } catch (Throwable $e) {
            report($e);
            throw $e instanceof \RuntimeException
                ? $e
                : new \RuntimeException('Unable to delete category.');
        }
    }
}
