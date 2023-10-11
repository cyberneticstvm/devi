<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductPharmacyExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $products = Product::with('tsc', 'manufacturer')->where('category', 'pharmacy')->orderBy('name')->get();

        return $products->map(function ($data, $key) {
            return [
                'item_serial' =>  $key + 1,
                'item_name' => $data->name,
                'item_age' => $data->code,
                'item_gender' => $data->tsc->name,
                'item_place' => $data->manufacturer->name,
                'item_mobile' => $data->mrp,
                'item_doctor' => $data->selling_price,
                'item_branch' => $data->tax_percentage,
                'item_date' => $data->reorder_level,
                'item_time' => $data->description,
            ];
        });
    }

    public function headings(): array
    {
        return ['SL No', 'Product Name', 'Product Code', 'Product Type', 'Manufacturer', 'MRP', 'Selling Price', 'Tax %', 'Reorder Level', 'Description'];
    }

    public function map($data): array
    {
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
    }
}
