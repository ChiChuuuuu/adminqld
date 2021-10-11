<?php

namespace App\Exports;

use App\Models\GradeModel;
use App\Models\SubjectModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassGradeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($idClass,$idSub)
    {
        //Neu flag = true tai xuong sample.xlsx
        $this->idClass = $idClass;
        $this->idSub = $idSub;      
    }

    public function collection()
    {
        return GradeModel::join('student', 'grades.idStudent', '=', 'student.idStudent')
            ->join('subject', 'subject.idSub', '=', 'grades.idSub')
            ->join('classroom', 'classroom.idClass', '=', 'student.idClass')
            ->where([
                ['classroom.idClass','=', $this->idClass],
                ['subject.idSub','=', $this->idSub]
            ])
            ->select(
                'grades.idStudent',
                'student.name',
                'classroom.nameClass',
                'subject.nameSub',
                'grades.Skill1',
                'grades.Final1',
                'grades.Skill2',
                'grades.Final2',
                
            )
            ->get();
        //select * from grades inner JOIN student ON grades.idStudent = student.idStudent inner JOIN subject 
        //ON subject.idSub = grades.idSub inner JOIN classroom ON classroom.idClass = student.idClass WHERE classroom.idClass = 1
    }

    public function headings(): array
    {
        return [
            'IDSV', 'Họ tên','Lớp', 'Môn', 'Thực Hành', 'Lý thuyết', 'Thực hành thi lại', 'Lý thuyết thi lại'
        ];
    }


}
