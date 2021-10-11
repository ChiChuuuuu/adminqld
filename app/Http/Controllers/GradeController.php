<?php

namespace App\Http\Controllers;

use App\Exports\GradeExport;
use App\Imports\GradeImport;
use App\Models\ClassModels;
use App\Models\GradeModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
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
        return view('grade.index', [
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
        $grade = new GradeModel();
        if ($grade::where('idStudent', $idStudent)->where('idSub', $idSub)->exists()) {
            return redirect(route('grade.index'))->with('error', 'Thêm điểm không thành công sinh viên đã có điểm môn được chọn');
        }
        $grade->idStudent = $idStudent;
        $grade->idSub = $idSub;
        $grade->Skill1 = $skillGrade;
        $grade->Final1 = $finalGrade;
        $grade->save();
        return redirect(route('grade.index'))->with('success', 'Thêm điểm thành công');
    }

    public function insertByExcel()
    {
        return view('grade.insert-by-excel');
    }

    public function GradeSample()
    {
        return Excel::download(new GradeExport(true), now() . " diem sinh vien.xlsx");
    }

    public function GradePreview(Request $request)
    {
        //Lay du lieu trong file excel -> show thong tin 
        $grade = Excel::toArray(new GradeImport, $request->file('excel'));

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

        return view('grade.preview', [
            'grade' => $grade[0],
        ]);
    }

    public function confirmSave()
    {
        $grade = session('tmp_grade');
        if ($grade != null && count($grade) > 0) {
            //Nhập vào database
            foreach ($grade as $grade) {
                DB::table("grades")->join('subject', 'subject.idSub', '=', 'grades.idSub')
                    ->updateOrInsert(
                        ["idStudent" => $grade["id_sv"], 'grades.idSub' => SubjectModel::where('subject.nameSub', $grade["mon"])->value("subject.idSub")],
                        [
                            "Skill1" => $grade["thuc_hanh"],
                            "Final1" => $grade["ly_thuyet"]
                        ]
                    );
            }
        }
        return redirect(route('grade.insert-by-excel'))->with('success', 'Thêm điểm thành công');
    }
}
