<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some categories
        $booksCategory = Category::where('name', 'Books')->first();
        $stationeryCategory = Category::where('name', 'Stationery')->first();
        $pensCategory = Category::where('name', 'Pens & Pencils')->first();
        $notebooksCategory = Category::where('name', 'Notebooks')->first();

        $products = [
            [
                'name' => 'Blue Ballpoint Pen',
                'code' => 'BP001',
                'category_id' => $pensCategory ? $pensCategory->id : ($stationeryCategory ? $stationeryCategory->id : null),
                'cost_price' => 15.00,
                'selling_price' => 25.00,
                'stock_quantity' => 100,
                'barcode' => '1234567890001',
                'preorder_level_qty' => 20,
            ],
            [
                'name' => 'Red Ballpoint Pen',
                'code' => 'BP002',
                'category_id' => $pensCategory ? $pensCategory->id : ($stationeryCategory ? $stationeryCategory->id : null),
                'cost_price' => 15.00,
                'selling_price' => 25.00,
                'stock_quantity' => 80,
                'barcode' => '1234567890002',
                'preorder_level_qty' => 20,
            ],
            [
                'name' => 'A4 Ruled Notebook',
                'code' => 'NB001',
                'category_id' => $notebooksCategory ? $notebooksCategory->id : ($stationeryCategory ? $stationeryCategory->id : null),
                'cost_price' => 150.00,
                'selling_price' => 250.00,
                'stock_quantity' => 50,
                'barcode' => '1234567890003',
                'preorder_level_qty' => 10,
            ],
            [
                'name' => 'A5 Plain Notebook',
                'code' => 'NB002',
                'category_id' => $notebooksCategory ? $notebooksCategory->id : ($stationeryCategory ? $stationeryCategory->id : null),
                'cost_price' => 100.00,
                'selling_price' => 180.00,
                'stock_quantity' => 60,
                'barcode' => '1234567890004',
                'preorder_level_qty' => 15,
            ],
            [
                'name' => 'HB Pencil Set (12pcs)',
                'code' => 'PC001',
                'category_id' => $pensCategory ? $pensCategory->id : ($stationeryCategory ? $stationeryCategory->id : null),
                'cost_price' => 120.00,
                'selling_price' => 200.00,
                'stock_quantity' => 40,
                'barcode' => '1234567890005',
                'preorder_level_qty' => 10,
            ],
            [
                'name' => 'English Grammar Book',
                'code' => 'BK001',
                'category_id' => $booksCategory ? $booksCategory->id : null,
                'cost_price' => 450.00,
                'selling_price' => 650.00,
                'stock_quantity' => 25,
                'barcode' => '1234567890006',
                'preorder_level_qty' => 5,
            ],
            [
                'name' => 'Mathematics Workbook',
                'code' => 'BK002',
                'category_id' => $booksCategory ? $booksCategory->id : null,
                'cost_price' => 380.00,
                'selling_price' => 550.00,
                'stock_quantity' => 30,
                'barcode' => '1234567890007',
                'preorder_level_qty' => 5,
            ],
            [
                'name' => 'Eraser (White)',
                'code' => 'ER001',
                'category_id' => $stationeryCategory ? $stationeryCategory->id : null,
                'cost_price' => 8.00,
                'selling_price' => 15.00,
                'stock_quantity' => 150,
                'barcode' => '1234567890008',
                'preorder_level_qty' => 30,
            ],
            [
                'name' => 'Sharpener (Metal)',
                'code' => 'SH001',
                'category_id' => $stationeryCategory ? $stationeryCategory->id : null,
                'cost_price' => 20.00,
                'selling_price' => 35.00,
                'stock_quantity' => 70,
                'barcode' => '1234567890009',
                'preorder_level_qty' => 20,
            ],
            [
                'name' => 'Ruler 30cm',
                'code' => 'RL001',
                'category_id' => $stationeryCategory ? $stationeryCategory->id : null,
                'cost_price' => 25.00,
                'selling_price' => 45.00,
                'stock_quantity' => 55,
                'barcode' => '1234567890010',
                'preorder_level_qty' => 15,
            ],
        ];

        foreach ($products as $product) {
            if (!Product::where('code', $product['code'])->exists()) {
                Product::create($product);
            }
        }
    }
}
