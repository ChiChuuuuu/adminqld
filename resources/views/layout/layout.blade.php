<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets') }}/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Paper Dashboard PRO by Creative Tim</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('assets') }}/css/paper-dashboard.css" rel="stylesheet" />


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('assets') }}/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets') }}/css/themify-icons.css" rel="stylesheet">
</head>

<body>
    <div class="sidebar" data-background-color="brown" data-active-color="danger">
        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | brown"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                CT
            </a>

            <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                Creative Tim
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="info">


                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                        <span>
                            Giáo vụ
                            <b class="caret"></b>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            {{-- <li>
                                <a href="#profile">
                                    <span class="sidebar-normal">Đổi mật khẩu</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ route('logout') }}">
                                    <span class="sidebar-normal">Đăng Xuất</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li>
                    <a href="{{ route('dashboard') }}" aria-expanded="true">
                        <i class="ti-panel"></i>
                        <p>Dashboard
                        </p>
                    </a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#formsExamples">
                        <i class="ti-face-sad"></i>
                        <p>Điểm
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="formsExamples">
                        <ul class="nav">
                            {{-- <li>
                                <a href="{{ route('viewgrade.index') }}">
                                    <span class="sidebar-normal">Xem điểm</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ route('grade.index') }}">
                                    <span class="sidebar-normal">Thêm điểm</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('grade2.index') }}">
                                    <span class="sidebar-normal">Thêm điểm thi lại</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('editgrade.index') }}">
                                    <span class="sidebar-normal">Sửa điểm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- <li>
                    <a href="{{ route('viewgrade.index') }}">
                        <p>
                            Xem điểm
                        </p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('grade.index') }}">
                        <i class="ti-face-sad"></i>
                        <p>
                            Thêm điểm
                        </p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('grade2.index') }}">
                        <i class="ti-face-sad"></i>
                        <p>
                            Thêm điểm thi lại
                        </p>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('class.index') }}">
                        <i class="ti-view-list-alt"></i>
                        <p>
                            Lớp
                        </p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.index')}}">
                        <i class="ti-id-badge"></i>
                        <p>
                            Sinh Viên
                        </p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subject.index') }}">
                        <i class="ti-list"></i>
                        <p>
                            Môn học
                        </p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('major.index') }}">
                        <i class="ti-clipboard"></i>
                        <p>
                            Chuyển Ngành
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </div>
    @yield('main')
    </div>

</body>

<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
<script src="{{ asset('assets') }}/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Forms Validations Plugin -->
<script src="{{ asset('assets') }}/js/jquery.validate.min.js"></script>

<!-- Promise Library for SweetAlert2 working on IE -->
<script src="{{ asset('assets') }}/js/es6-promise-auto.min.js"></script>

<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{ asset('assets') }}/js/moment.min.js"></script>

<!--  Date Time Picker Plugin is included in this js file -->
<script src="{{ asset('assets') }}/js/bootstrap-datetimepicker.js"></script>

<!--  Select Picker Plugin -->
<script src="{{ asset('assets') }}/js/bootstrap-selectpicker.js"></script>

<!--  Switch and Tags Input Plugins -->
<script src="{{ asset('assets') }}/js/bootstrap-switch-tags.js"></script>

<!-- Circle Percentage-chart -->
<script src="{{ asset('assets') }}/js/jquery.easypiechart.min.js"></script>

<!--  Charts Plugin -->
<script src="{{ asset('assets') }}/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('assets') }}/js/bootstrap-notify.js"></script>

<!-- Sweet Alert 2 plugin -->
<script src="{{ asset('assets') }}/js/sweetalert2.js"></script>

<!-- Vector Map plugin -->
<script src="{{ asset('assets') }}/js/jquery-jvectormap.js"></script>

<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!-- Wizard Plugin    -->
<script src="{{ asset('assets') }}/js/jquery.bootstrap.wizard.min.js"></script>

<!--  Bootstrap Table Plugin    -->
<script src="{{ asset('assets') }}/js/bootstrap-table.js"></script>

<!--  Plugin for DataTables.net  -->
<script src="{{ asset('assets') }}/js/jquery.datatables.js"></script>

<!--  Full Calendar Plugin    -->
<script src="{{ asset('assets') }}/js/fullcalendar.min.js"></script>

<!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
<script src="{{ asset('assets') }}/js/paper-dashboard.js"></script>

<!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets') }}/js/demo.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        demo.initOverviewDashboard();
        demo.initCirclePercentage();

    });
</script>

{{-- Customemize Code --}}
<script src="{{ asset('assets') }}/js/grade.js"></script>

</html>
