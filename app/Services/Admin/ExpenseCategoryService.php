<?php

namespace App\Services\Admin;

use App\Models\ExpenseCategory;

class ExpenseCategoryService
{
    public function getAll()
    {
        return ExpenseCategory::withCount('expenses')->latest()->get();
    }

    public function getActive()
    {
        return ExpenseCategory::active()->orderBy('name')->get();
    }

    public function find(string $id): ExpenseCategory
    {
        return ExpenseCategory::findOrFail($id);
    }

    public function store(array $data): ExpenseCategory
    {
        $data['slug'] = $this->uniqueSlug($data['name']);
        return ExpenseCategory::create($data);
    }

    public function update(array $data, string $id): ExpenseCategory
    {
        $category = ExpenseCategory::findOrFail($id);

        if ($category->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        $category->update($data);
        return $category;
    }

    public function delete(string $id): void
    {
        $category = ExpenseCategory::findOrFail($id);

        if ($category->expenses()->exists()) {
            throw new \RuntimeException('Cannot delete a category that has expenses recorded against it.');
        }

        $category->delete();
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = ExpenseCategory::generateSlug($name);
        $slug = $base;
        $i = 1;

        while (ExpenseCategory::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}