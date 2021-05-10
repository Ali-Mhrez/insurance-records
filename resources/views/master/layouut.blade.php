<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>مصرف سوريا المركزي</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
        integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('/css/toastr.css') }}">
    <script src="{{ URL::asset('/js/jquery-3.3.1.js') }}"></script>
</head>

<body style="direction:rtl;">


    <nav class="navbar navbar-expand-sm" style="background-color: #292961;padding: 0 16px;">
        <a class="navbar-brand" style="color: #d1d1f0;" href="/">مصرف سورية المركزي</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" style="color: #d1d1f0;" href="{{ route('welcome') }}">الرئيسية <span
                            class="sr-only">(current)</span></a>
                </li>
                @if(Auth::user()->hasRole('administrator'))
                <li class="nav-item">
                    <a class="nav-link" style="color: #d1d1f0;" href="{{ route('bank.list') }}">البنوك</a>
                </li>
                @endif
                @if(Auth::user()->hasPermission('initial_records-read'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color: #d1d1f0;" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        السجلات البدائية
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('guarantee.list') }}">الكفالات</a>
                        <a class="dropdown-item" href="{{ route('list_checks') }}">الشيكات</a>
                        <a class="dropdown-item" href="{{ route('payment.list') }}">الدفعات النقدية والحوالات</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                @endif
                @if(Auth::user()->hasPermission('final_records-read'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color: #d1d1f0;" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        السجلات النهائية
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('fguarantee.list') }}">الكفالات</a>
                        <a class="dropdown-item" href="{{ route('fcheck.list') }}">الشيكات</a>
                        <a class="dropdown-item" href="{{ route('fpayment.list') }}">الدفعات النقدية والحوالات</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color: #d1d1f0;" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            style="fill: currentColor;vertical-align: -3px;width: 16px;height: 16px;overflow: hidden;"
                            viewBox="0 0 16 16" id="plus-square">
                            <path fill-rule="evenodd"
                                d="M4 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4zm5 3a1 1 0 1 0-2 0v2H5a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0V9h2a1 1 0 1 0 0-2H9V5z">
                            </path>
                        </svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('guarantee.create') }}">كفالة بدائية جديدة</a>
                        <a class="dropdown-item" href="{{ route('fguarantee.create') }}">كفالة نهائية جديدة</a>
                        <a class="dropdown-item" href="{{ route('create_check') }}">شيك بدائي جديدة</a>
                        <a class="dropdown-item" href="{{ route('fcheck.create') }}">شيك نهائي جديد</a>
                        <a class="dropdown-item" href="{{ route('payment.create') }}">دفعة أو حوالة بدائية جديدة</a>
                        <a class="dropdown-item" href="{{ route('fpayment.create') }}">دفعة أو حوالة نهائية جديدة</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0 mr-auto" style="margin-left:0!important;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" style="color: #d1d1f0;" class="nav-link dropdown-toggle" href="#"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->hasRole('administrator'))
                        <a class="dropdown-item" href="{{ route('new-user-form') }}">
                            إضافة مستخدم جديد
                        </a>
                        <a class="dropdown-item" href="{{ route('users.list') }}">
                            إدارة المستخدمين
                        </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('update-password-form') }}">
                            تغيير كلمة المرور
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            تسجيل خروج
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        </div>
    </nav>

    <!-- end of navbar -->

    <main class="py-4">
        @yield('content')
    </main>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->


    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"
        integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="{{ URL::asset('/js/toastr.min.js') }}">
    </script>




    @include('master.session')

</body>

</html>
