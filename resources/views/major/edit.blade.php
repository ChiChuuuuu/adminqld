@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Sửa chuyên ngành
                </h1>
                <form action="{{ route('major.update', ['major' => $major->idMajor]) }}" method="post">
                    <br>
                    @method('PUT')
                    @csrf
                    Tên chuyên ngành <input type="text" value='{{ $major->nameMajor }}' name="name" required /> <br><br>
                    <button class="btn btn-default">update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
