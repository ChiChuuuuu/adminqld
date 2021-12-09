@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Thêm môn
                </h1>
                <form action="{{ route('subject.store') }}" method="post">
                    @csrf
                    Tên môn <input type="text" name="nameSubject" required/> <br><br>
                    Chuyên ngành
                    <select name="idMajor">
                        @foreach ($listMajor as $major)
                            <option value="{{ $major->idMajor }}">
                                {{ $major->nameMajor }}
                            </option>
                        @endforeach
                    </select>
                    <br><br>
                    <button class="btn btn-default">Thêm</button>
                </form>
            </div>
        </div>
    </div>
@endsection

