@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Lớp
                </h1>

                <a href="{{ route('class.create') }}"><button class="btn btn-default">Thêm lớp</button></a> &nbsp &nbsp
                &nbsp &nbsp &nbsp
                <a href="{{ url('/export') }}"><button class="btn btn-default">Tải xuống danh sách sinh
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
                            <th>Tên Lớp</th>
                            <th>Chuyên ngành</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listClass as $class)
                            <tr>
                                <td><?= $class->idClass ?></td>
                                <td><?= $class->nameClass ?></td>
                                <td><?= $class->nameMajor ?></td>
                                <td> <a href="{{ route('class.show', $class->idClass) }}" title="Danh sach sv"
                                        class="btn btn-info btn-simple btn-xs"><i class="fa fa-user"></i></a></td>
                                <td><a href="{{ url('/subject-by-class', $class->idClass) }}" title="Danh sach mon"><i
                                            class="fa fa-list-ul"></i> </a></td>
                                <td><a href="{{ route('class.edit', $class->idClass) }}" title="Sửa lớp"
                                        class="btn btn-success btn-simple btn-xs">
                                        <i class="fa fa-edit"></i></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $listClass->appends(['search' => $search])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
