<?php

namespace App\Exports;

use App\Models\casesFiType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use  Maatwebsite\Excel\Concerns\WithHeadings;
use  Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportCase implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
{

    public function __construct() {}

    public function collection()
    {
        $case = casesFiType::with(['getUser', 'getCase', 'getCaseFiType', 'getFiType', 'getCaseStatus'])->get();
        $output=[];
        if($case){
            $i=0;
            foreach($case as $key => $value){
                $output[$i][] =  $value->id;
                $output[$i][] =  $value->getCase->refrence_number ?? '';
                $output[$i][] =  $value->getCase->applicant_name ?? '';
                $output[$i][] =  $value->mobile ?? '';
                $output[$i][] =  $value->address ?? '';
                $output[$i][] =  $value->getCase->getBank->name ?? '-'.' ' . $value->getCase->getProduct->name ?? '-'.' '.$value->getFiType->name ?? '';
                $output[$i][] =  $value->scheduled_visit_date ? humanReadableDate($value->scheduled_visit_date) : '';
                $output[$i][] =  $value->getUser->name ?? '';
                $output[$i][] =  $value->status ? get_status($value->status) :  '';
                $output[$i][] =  $value->getCaseStatus->name ?? '';
                $output[$i][] =  '';
                $i++;
            }
        }
        return collect($output);
    }



    public function headings(): array
    {
        return [
            'App Id',
            'Internal Code',
            'Name',
            'Mobile Number',
            'Address',
            'FIType',
            'Scheduled Date',
            'Agent',
            'Status',
            'SubStatus',
            'Action'

        ];
    }

    public function title(): string
    {
        return 'Cases FI Type';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')
            ->getFont()
            ->setBold(true)
            ->setSize(12)
            ->getColor()
            ->setRGB('ffffff');

        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF0000');
    }
}
