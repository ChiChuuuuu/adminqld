<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InvoicesExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($idClass)
    {
        $this->idClass = $idClass;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        for ($idSub = 1; $idSub <= 12; $idSub++) {
            $sheets[] = new ClassGradeExport($this->idClass, $idSub);
        }

        return $sheets;
    }

}
