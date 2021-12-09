@extends('layout.layout');

@section('main')
    <style>
        table,
        th,
        td {
            padding: 5px;
        }

    </style>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h1>
                    Thêm sinh viên
                </h1>
                <form action="{{ route('student.store') }}" method="post">
                    @csrf
                    <table>
                        <tr>
                            <td>
                                Họ và tên
                            </td>
                            <td>
                                <input type="text" name="name" required />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email
                            </td>
                            <td>
                                <input type="email" name="email" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Mật khẩu
                            </td>
                            <td>
                                <input type="password" name="password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Giới tính
                            </td>
                            <td>
                                <label><input type="radio" name="gender" value="0">Nam</label>
                                <label><input type="radio" name="gender" value="1">Nữ</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ngày sinh
                            </td>
                            <td>
                                <input type="date" name="date">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Lớp
                            </td>
                            <td>
                                <select name="idClass">
                                    @foreach ($listClass as $class)
                                        <option value="{{ $class->idClass }}">
                                            {{ $class->nameClass }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                    @if (session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <br>
                    <button class="btn btn-default">Thêm</button>
                </form>
            </div>
        </div>
    </div>
@endsection
