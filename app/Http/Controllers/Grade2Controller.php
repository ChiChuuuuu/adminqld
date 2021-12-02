<?php

namespace App\Http\Controllers;

use App\Exports\ClassGradeExport;
use App\Exports\Grade2Export;
use App\Imports\Grade2Import;
use App\Models\ClassModels;
use App\Models\Grade2Model;
use App\Models\GradeModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Grade2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listClass = ClassModels::all();
        $listSub = SubjectModel::all();
        $listGrade = GradeModel::all();
        return view('grade2.index', [
            'listClass' => $listClass,
            'listSub' => $listSub,
            'listGrade' => $listGrade,
        ]);
    }

    //SELECT student.*, grades.Skill1 FROM `student` inner join grades on student.idStudent = grades.idStudent

    public function getStudentsByIDClass($id)
    {
        $listStudent = StudentModel::where('idClass', $id)->get();
        return $listStudent;
    }

    public function getSubjectByIdClass($id)
    {
        $listSub = DB::table('subject')
            ->join('major', 'major.idMajor', '=', 'subject.idMajor')
            ->join('classroom', 'classroom.idMajor', '=', 'major.idMajor')
            ->where('idClass', '=', $id)
            ->get();
        return $listSub;
    }

    public function store(Request $request)
    {
        $idStudent = $request->get('idStudent');
        $idSub = $request->get('idSubject');
        $skillGrade = $request->get('skillGrade');
        $finalGrade = $request->get('finalGrade');
        Grade2Model::where('idStudent', $idStudent)->where('idSub', $idSub)->update([
            'Skill2' => $skillGrade,
            'Final2' => $finalGrade,
        ]);
        return redirect(route('grade2.index'))->with('success', 'Thêm điểm thành công');
    }

    public function insertByExcel()
    {
        return view('grade2.insert-by-excel');
    }

    public function GradePreview(Request $request)
    {
        //Lay du lieu trong file excel -> show thong tin
        $grade = Excel::toArray(new Grade2Import, $request->file('excel'));

        //Kiem tra file co dung dinh dang hay khong
        try {
            $check = $grade[0][0];
            $idStu = $check["id_sv"];
            $name = $check["ho_ten"];
            $idSub = $check["mon"];
            $TH = $check["thuc_hanh"];
            $LT = $check["ly_thuyet"];
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'File không đúng định dạng hoặc không có dữ liệu!');
        }

        //put vao session
        session(['tmp_grade' => $grade[0]]);

        return view('grade2.preview', [
            'grade' => $grade[0],
        ]);
        return view('grade2.import-by-excel');
    }

    public function confirmSave()
    {
        $grade = session('tmp_grade');
        $check = new Grade2Model();


        if ($grade != null && count($grade) > 0) {
            //Nhập vào database
            foreach ($grade as $grade) {
                DB::table("grades")->join('subject', 'subject.idSub', '=', 'grades.idSub')
                    ->updateOrInsert(
                        ["idStudent" => $grade["id_sv"], "nameSub" => $grade["mon"]],
                        [
                            "Skill2" => $grade["thuc_hanh"],
                            "Final2" => $grade["ly_thuyet"]
                        ]
                    );
            }
        }
        return redirect(route('grade2.insert-by-excel'))->with('success', 'Thêm điểm thành công');
    }

    public function exportByIdStudent($id)
    {
        return Excel::download(new Grade2Export($id), 'Diem sv.xlsx');
    }

    public function getSubjectByClass($id)
    {
        $class = ClassModels::find($id);

        $subject = ClassModels::join('major','major.idMajor','=','classroom.idMajor')
        ->join('subject','subject.idMajor','=','major.idMajor')
        ->where('classroom.idClass','=',$id)
        ->get();

        // $listSub = GradeModel::join('student', 'grades.idStudent', '=', 'student.idStudent')
        //     ->join('subject', 'subject.idSub', '=', 'grades.idSub')
        //     ->join('classroom', 'classroom.idClass', '=', 'student.idClass')
        //     ->where('classroom.idClass', $id)
        //     ->get();

        return view('subject.subject-by-class',[
            'class' => $class,
            'subject' => $subject,
        ]);
    }

    public function exportByClass($idClass,$idSub)
    {
        return Excel::download(new ClassGradeExport($idClass,$idSub), 'Diem svlop.xlsx');
    }
}
