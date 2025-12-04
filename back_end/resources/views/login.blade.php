<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="stylesheet" href=" {{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/fonts/icofont/icofont.min.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }} ">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <style>
 body {
    font-family: 'Cairo', sans-serif;
    background: linear-gradient(135deg, #f8f9fc, #e0e7ff);
    min-height: 100vh;
}

.auth-card {
   background: #fff;
    border-radius: 16px !important;
    padding: 50px 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 600px; /* زاد العرض من 500 إلى 600 */
    margin: auto;
    animation: fadeIn 0.6s ease;
}
.input-group>.form-control:not(:first-child), .input-group>.custom-select:not(:first-child) {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}
.theme-input-style {
    padding: 12px 15px;
    border-radius: 10px;
    border: 1.5px solid #ccc;
    font-size: 15px;
    transition: border-color 0.3s ease;
}

.theme-input-style:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.btn.long {
    background: linear-gradient(to right, #6366f1, #7c3aed);
    color: white;
    padding: 12px 30px;
    font-weight: bold;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(99,102,241,0.3);
}

.btn.long:hover {
    background: #4f46e5;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.4);
}

    </style>
</head>

<body>
<div class="mn-vh-100 d-flex align-items-center">
    <div class="container">
<div class="col-xl-12 col-lg-12 col-md-8 col-sm-10">

        <div class="card justify-content-center auth-card">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9">
                    <h4 class="mb-5 font-20 text-center">أهلاً بك في لوحة التحكم</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-20">
                            <span class="input-group-text" style="    margin-left: 12px;"><i class="icofont-user"></i></span>
                            <input type="text" name="username" id="username" class="form-control theme-input-style" placeholder=" اسم المستخدم"  autofocus>
                        </div>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror


                        <div class="input-group mb-20">
                            <span class="input-group-text" style="    margin-left: 12px;"><i class="icofont-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control theme-input-style" placeholder="********" >
                        </div>

                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn long">تسجيل الدخول</button>
                        </div>
                        @if ($errors->has('login'))
    <div class="text-danger text-center mt-3">{{ $errors->first('login') }}</div>
@endif

                    </form>
                </div>
            </div>
        </div>
</div>

    </div>
</div>

<footer class="footer style--two text-center">
    لوحة التحكم &copy; 2025. جميع الحقوق محفوظة.
</footer>

<script src="{{ asset('assets/js/jquery.min.js') }} "></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
<script src="{{ asset('assets/js/script.js') }} "></script>
</body>
</html>
