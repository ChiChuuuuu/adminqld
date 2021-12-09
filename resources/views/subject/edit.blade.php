@extends('layout.layout');

@section('main')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Sửa môn học
                </h1>
                <form action="{{ route('subject.update', ['subject'=>$subject->idSub]) }}" method="post">
                    @method('PUT')
                    @csrf
                    Tên môn <input type="text" value="{{ $subject->nameSub }}" name="nameSubject" required/> <br><br>
                    Chuyên ngành
                    <select name="idMajor">
                        @foreach ($listMajor as $major)
                            <option value="{{ $major->idMajor }}" @if ($major->idMajor == $subject->idMajor) <?php echo "selected" ?> @endif>
                                {{ $major->nameMajor }}
                            </option>
                        @endforeach
                    </select>
                    <br><br>
                    <button class="btn btn-default">update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

