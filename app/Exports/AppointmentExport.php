<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $appointments = Appointment::with('doctor', 'branch')->get();

        return $appointments->map(function($data, $key){
            return [
                'item_serial' =>  $key + 1,
                'item_name' => $data->name,
                'item_age'=> $data->age,
                'item_gender' => $data->gender,
                'item_place' => $data->place,
                'item_mobile' => $data->mobile,
                'item_doctor' => $data->doctor->name,
                'item_branch' => $data->branch->name,
                'item_time' => $data->time->format('d, M Y'),
            ];
        });
    }

    public function headings(): array {
        return ['SL No', 'Patient Name', 'Age', 'Gender', 'Place', 'Mobile', 'Doctor', 'Branch', 'Time'];
    }

    public function map($data): array {
        return $data;
    }

    public function styles(Worksheet $sheet){
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
    }
}
