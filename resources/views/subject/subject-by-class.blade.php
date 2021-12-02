@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Lớp <?= $class->nameClass ?>
                </h1>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Môn học</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subject as $sub)
                            <tr>
                                <td><?= $sub->idSub ?></td>
                                <td><?= $sub->nameSub ?></td>
                                <td><a href="{{ url('/export-by-class', [$sub->idClass, $sub->idSub]) }}">Tải xuống
                                        điểm</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
