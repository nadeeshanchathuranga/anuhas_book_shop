<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Books', 'parent_id' => null],
            ['name' => 'Stationery', 'parent_id' => null],
            ['name' => 'School Supplies', 'parent_id' => null],
            ['name' => 'Office Supplies', 'parent_id' => null],
            ['name' => 'Art & Craft', 'parent_id' => null],
        ];

        foreach ($categories as $category) {
            if (!Category::where('name', $category['name'])->exists()) {
                Category::create($category);
            }
        }

        // Create subcategories for Books
        $booksCategory = Category::where('name', 'Books')->first();
        if ($booksCategory) {
            $bookSubcategories = [
                ['name' => 'Fiction', 'parent_id' => $booksCategory->id],
                ['name' => 'Non-Fiction', 'parent_id' => $booksCategory->id],
                ['name' => 'Children Books', 'parent_id' => $booksCategory->id],
                ['name' => 'Educational', 'parent_id' => $booksCategory->id],
            ];

            foreach ($bookSubcategories as $subcategory) {
                if (!Category::where('name', $subcategory['name'])
                    ->where('parent_id', $subcategory['parent_id'])
                    ->exists()) {
                    Category::create($subcategory);
                }
            }
        }

        // Create subcategories for Stationery
        $stationeryCategory = Category::where('name', 'Stationery')->first();
        if ($stationeryCategory) {
            $stationerySubcategories = [
                ['name' => 'Pens & Pencils', 'parent_id' => $stationeryCategory->id],
                ['name' => 'Notebooks', 'parent_id' => $stationeryCategory->id],
                ['name' => 'Paper Products', 'parent_id' => $stationeryCategory->id],
            ];

            foreach ($stationerySubcategories as $subcategory) {
                if (!Category::where('name', $subcategory['name'])
                    ->where('parent_id', $subcategory['parent_id'])
                    ->exists()) {
                    Category::create($subcategory);
                }
            }
        }
    }
}
