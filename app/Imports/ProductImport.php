<?php

namespace App\Imports;

use App\Models\MeasuringUnit;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            // Retrieve related models for category and unit
            $category = ProductCategory::where('title', $row['category'])->firstOrFail();
            $unit = MeasuringUnit::where('title', $row['unit'])->firstOrFail();

            // Parse expiry date to the database format
            $expiryDate = Carbon::createFromFormat('d/m/Y', $row['expiry_date'])->format('Y-m-d');

            // Calculate selling price
            $costPrice = $row['cost_price'];
            $markupPercent = $row['markup_percentage'] ?? 0;
            $discount = $row['discount'] ?? 0;

            $markupAmount = ($markupPercent / 100) * $costPrice;
            $sellingPrice = $markupAmount + $costPrice;

            $discountAmount = ($discount / 100) * $sellingPrice;
            $sellingPrice -= $discountAmount;

            // Prepare data for creation
            $productData = [
                'name' => $row['product_name'],
                'generic_name' => $row['generic_name'] ?? null,
                'manufacturer' => $row['manufacturer'] ?? null,
                'product_category_id' => $category->id,
                'measuring_unit_id' => $unit->id,
                'cost_price' => $costPrice,
                'markup_percentage' => $markupPercent,
                'discount' => $discount,
                'selling_price' => $sellingPrice,
                'stock_level_at_dispensary' => $row['quantity_at_dispensary'],
                'stock_level_at_store' => $row['quantity_at_store'],
                'expires_at' => $expiryDate,
            ];

            // Create the product
            Product::create($productData);
        }
    }

    public function rules(): array
    {
        return [
            '*.product_name' => ['required', 'string', 'max:100', Rule::unique(Product::class, 'name')],
            '*.generic_name' => ['nullable', 'string', 'max:100'],
            '*.manufacturer' => ['nullable', 'string', 'max:100'],
            '*.category' => [
                'required',
                Rule::exists('product_categories', 'title'),
            ],
            '*.unit' => [
                'required',
                Rule::exists('measuring_units', 'title')
            ],
            '*.cost_price' => ['required', 'numeric', 'min:0'],
            '*.discount' => ['nullable', 'numeric', 'min:0', 'max: 100'],
            '*.markup_percentage' => ['nullable', 'numeric', 'min:0', 'max: 100'],
            '*.quantity_at_dispensary' => ['required', 'numeric', 'min:0'],
            '*.quantity_at_store' => ['required', 'numeric', 'min:0'],
            '*.expiry_date' => ['required', 'date_format:d/m/Y']
        ];
    }
}
