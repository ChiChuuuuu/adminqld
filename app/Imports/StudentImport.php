<?php

namespace App\Imports;

use App\Models\ClassModels;
use App\Models\StudentModel;
use Exception;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class StudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        
        $date = str_replace("/", "-", $row["ngay_sinh"]);
        $data = [
            "name" => $row["ho_ten"],
            "email" => $row["email"],
            "password" => $row["password"],
            "gender" => $row["gioi_tinh"] == "Nam" ? 0 : 1,
            "dob" => date("Y-m-d", strtotime($date)),
            "idClass" => ClassModels::where("nameClass", $row["lop"])->value("idClass"),
        ];
        return new StudentModel($data);
    }

    public function rules(): array
    {
        return [
            '*.email' => ['email', 'unique:student,email']
        ];
    }

    // public function onFailure(Failure ...$failure){
    // }
}
