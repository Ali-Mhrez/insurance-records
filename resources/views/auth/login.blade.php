<!DOCTYPE html>
<html class="no-js" lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>تسجيل دخول</title>
	<link rel="shortcut icon" type="image/png" href="{{asset('public/dist/img/cbs.png')}}">
		<base href="/i-r/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/responsive.css')}}">

    <!-- others css -->

    <link rel="stylesheet" href="{{asset('public/dist/css/arabicFonts.css')}}">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader">
		
            <img src="{{asset('public/dist/img/logo.png')}}" alt="CBS Logo" class="logo-image img-circle elevation-4" style="opacity: .8">
        </div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s3 login-bg">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login-form-head">
                        <div class="logo">
                            <a href="/">
                                <img src="{{asset('public/dist/img/CBS.png')}}" alt="CBS Logo">
                            </a>
                        </div>
                        <h4>مصرف سورية المركزي</h4>
                        <p>مرحباً بك، سجل دخولك وأبدأ</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="username">اسم المستخدم</label>
                            <input id="username" type="username" name="username" required autocomplete="username" autofocus>
                            <i class="ti-user"></i>

                        </div>
                        <div class="form-gp">
                            <label for="paswword">كلمة المرور</label>
                            <input id="password" type="password" name="password" required autocomplete="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger" style="direction: rtl;"> @error('username')
                                {{ $message }}
                                @enderror @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">دخول <i class="ti-arrow-right"></i></button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="{{asset('public/assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
     <!-- modernizr css -->
      <script src="{{asset('public/assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    <!-- bootstrap 4 js -->
	
	      <script src="{{asset('public/assets/js/popper.min.js')}}"></script>
	      <script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
	      <script src="{{asset('public/assets/js/metisMenu.min.js')}}"></script>
	      <script src="{{asset('public/assets/js/jquery.slimscroll.min.js')}}"></script>
	      <script src="{{asset('public/assets/js/jquery.slimscroll.min.js')}}"></script>
	      <script src="{{asset('public/assets/js/plugins.js')}}"></script>
	      <script src="{{asset('public/assets/js/scripts.js')}}"></script>

	
	
	

</body>

</html>
