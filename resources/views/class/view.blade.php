@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Danh sách sinh viên lớp
                    {{-- @foreach ($listClass as $class)
                        {{ $class->nameClass }}
                    @endforeach --}}
                    {{$listClass->nameClass}}
                </h1>
                <h2>
                    Chuyên Ngành:
                    {{-- @foreach ($listClass as $class)
                        {{ $class->nameMajor }}
                    @endforeach --}}
                    {{$listClass->nameMajor}}
                </h2>

                <a href="{{ url('/export-by-id-class',$listClass->idClass) }}"><button class="btn btn-default">Tải xuống danh sách sinh
                        viên</button></a><br><br>

                <form class="navbar-form navbar-left navbar-search-form" role="search">
                    <div class="input-group">
                        <input type="text" value="" class="form-control" placeholder="Search..." name="search">

                    </div>
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                </form>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Giới tính</th>
                            <th>Ngày sinh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listStudent as $student)
                            <tr>
                                <td>{{ $student->idStudent }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    {{ $student->email }}
                                </td>
                                <td>
                                    {{ $student->password }}
                                </td>
                                <td>
                                    @if ($student->gender == 0)
                                        Nam
                                    @else
                                        Nu
                                    @endif
                                </td>
                                <td>
                                    {{ $student->dob }}
                                </td>
                                <td><a href="{{ route('viewgrade.show', $student->idStudent) }}">Xem diem<a></td>
                                    <td><a href="{{ route('student.edit', $student->idStudent) }}" title="Sửa thông tin"
                                        class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-edit"></i></a></td>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $listStudent->appends(['search' => $search])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
