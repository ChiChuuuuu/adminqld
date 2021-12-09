<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\ClassModels;
use App\Models\GradeModel;
use App\Models\MajorModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $idClass = $request->get('id-class');
        $listStudent =  StudentModel::join('classroom', 'classroom.idClass', '=', 'student.idClass')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('nameClass', 'LIKE', "%$search%")
            ->paginate(7);
        $listClass = ClassModels::all();
        return view('student.index', [
            'listStudent' => $listStudent,
            'listClass' => $listClass,
            'search' => $search,
            'idClass' => $idClass,
        ]);
        //where('name', 'LIKE', '%' . "$search" . '%')
        // DB::table('student')
        // ->join('classroom', 'classroom.idClass', '=', 'student.idClass')
        // ->select('student.*', 'classroom.nameClass')
        // ->where('name','LIKE', "%$search%")
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listClass = ClassModels::all();
        return view('student.create', [
            'listClass' => $listClass
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listStudent = StudentModel::all();
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $gender = $request->get('gender');
        $dob = $request->get('date');
        $class = $request->get('idClass');
        foreach ($listStudent as $student) {
            if ($student->email == $email) {
                return redirect(route('student.create'))->with('message', 'Email da duoc su dung');
            } else {
                $student = new StudentModel();
                $student->name = $name;
                $student->email = $email;
                $student->password = $password;
                $student->gender = $gender;
                $student->dob = $dob;
                $student->idClass = $class;
                $student->save();
                return redirect(route('student.index'));
            }
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = StudentModel::find($id);
        $class = DB::table('classroom')
            ->join('student', 'student.idClass', '=', 'classroom.idClass')
            ->where('idStudent', '=', $id)
            ->get();
        $grade = DB::table('grades')
            ->join('subject', 'subject.idSub', '=', 'grades.idSub')
            ->where('idStudent', '=', $id)
            ->get();
        $grade2 = DB::table('grades')
            ->join('subject', 'subject.idSub', '=', 'grades.idSub')
            ->where('idStudent', '=', $id)
            ->get();
        // SELECT * FROM `subject` INNER JOIN major on major.idMajor = subject.idMajor inner JOIN classroom on classroom.idMajor = major.idMajor where idClass = 5
        $idSub = $request->get('idSub');
        $listSub = SubjectModel::all();
        return view('student.grade', [
            'student' => $student,
            'listSub' => $listSub,
            'grade' => $grade,
            'grade2' => $grade2,
            'idSub' => $idSub,
            'class' => $class,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = StudentModel::find($id);
        $listClass = ClassModels::all();
        return view('student.edit', [
            'student' => $student,
            'listClass' => $listClass,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $gender = $request->get('gender');
        $date = $request->get('date');
        $idClass = $request->get('idClass');
        StudentModel::where('idStudent', $id)->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'gender' => $gender,
            'dob' => $date,
            'idClass' => $idClass,
        ]);
        return redirect(route('student.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertByExcel()
    {
        return view('student.insert-by-excel');
    }

    public function StudentSample()
    {
        return Excel::download(new StudentExport(true), now() . " sample.xlsx");
    }

    public function StudentPreview(Request $request)
    {
        //Lay du lieu trong file excel -> show thong tin
        $student = Excel::toArray(new StudentImport, $request->file('excel'));

        //  return redirect()->back()->with('message', 'File không đúng định dạng!');
        //Kiem tra file co dung dinh dang hay khong
        try {
            $students = $student[0][0];
            $name = $students['ho_ten'];
            $email = $students["email"];
            $password = $students["password"];
            $gender = $students["gioi_tinh"] == "Nam" ? 0 : 1;
            $dob = $students["ngay_sinh"];
            $lop = $students["lop"];
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'File không đúng định dạng hoặc không có dữ liệu!');
        }
        //put vao session
        session(['tmp_student' => $student[0]]);

        //Validate
        try {
            $validator = Validator::make($request->all(), [ // <---
                'email' => 'required|unique:student|max:255',
            ]);
        } catch (Exception $e) {
            if ($validator->fails()) {
                return redirect()->back()->with('message', 'Có email bị trùng vui lòng kiểm tra lại!');
            }
        }

        return view('student.preview', [
            'student' => $student[0],
        ]);
    }

    public function confirmSave(Request $request)
    {
        // $student = session('tmp_student');
        // if ($student != null && count($student) > 0) {
        //     //Nhập vào database
        //     foreach ($student as $student) {
        //         $date = str_replace("/", "-", $student["ngay_sinh"]);
        //         StudentModel::create([
        //             "name" => $student["ho_ten"],
        //             "email" => $student["email"],
        //             "password" => $student["password"],
        //             "gender" => $student["gioi_tinh"] == "Nam" ? 0 : 1,
        //             "dob" => date("Y-m-d", strtotime($date)),
        //             "idClass" => ClassModels::where("nameClass", $student["lop"])->value("idClass"),
        //         ]);
        //     }
        // }
        // return view('student.insert-by-excel');
        $student = Excel::toArray(new StudentImport, $request->file('excel'));
        try {
            $students = $student[0][0];
            $name = $students['ho_ten'];
            $email = $students["email"];
            $password = $students["password"];
            $gender = $students["gioi_tinh"] == "Nam" ? 0 : 1;
            $dob = $students["ngay_sinh"];
            $lop = $students["lop"];
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'File không đúng định dạng hoặc không có dữ liệu!');
        }

        $file = $request->file('excel')->store('import');
        $import = new StudentImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect()->back()->with('success', 'Thêm sinh viên thành công!');
    }
}
