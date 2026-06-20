<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Category([
            'parent_id' => $row['parent_id'] ?? null, // Match spreadsheet headers (e.g., "parent_id")
            'name' => $row['name'],
            'slug' => $row['slug'],
            'is_featured' => $row['is_featured'] ?? 0,
            'status' => $row['status'] ?? 1,
            'description' => $row['description'] ?? null,
        ]);
    }
}

