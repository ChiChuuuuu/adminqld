@extends('layout.layout');

@section('main')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
    <h1>
        Thêm chuyên ngành
    </h1>
    <form action="{{ route('major.store') }}" method="post">
        <br>
        @csrf
        Tên chuyên ngành <input type="text" name="name" required /> <br><br>
        <button class="btn btn-default" >Thêm</button>
    </form>
    </div></div>
</div>
@endsection
