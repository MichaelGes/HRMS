<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/css.css') }}">
  <link rel="stylesheet" href=" {{ asset('assets/admin/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/bundles/bootstrap-social/bootstrap-social.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
  <link rel="stylesheet" href="assets/admin/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/admin/img/favicon.ico') }}' />
  <link rel="stylesheet" href="{{ asset('assets/admin/css/css.css') }}">
</head>
<style>
  
</style>
<body style="background-size:cover;background-repeat: no-repeat ;background-image: url('{{ asset('assets/admin/img/Login-Page.jpg') }}') ">
  <!--<div class="loader"></div>-->
  <div id="app">
    <section class="section" style="text-align: right !important; font-family: STV;">
      <div class="container mt-5">
        <div class="row" >
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary" style="background: transparent;
                border: 2px solid rgba(255, 255, 255, .2);
                backdrop-filter:blur(10px) ;
                color: white;
                border-radius: 12px;
            ">
              <div class="log" style="font-size:12px;text-align :center;padding-top:15px; ">
                <h6>تسجيل الدخول الي النظام</h6>
              </div>
              <div class="card-body" style="direction: rtl;">
              
                <form action="{{ route('admin.login') }}" method="POST">
                  @csrf
                  <div class="form-group" >
                    <label for="email">ايميلك</label>
                    <input id="email"  name="username" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      يجب ادخال الايميل بطريقة صحيحة
                    </div>
                  </div>
                  @error('username')
                  <span class="text-danger">{{ $message }}</span>        
                  @enderror
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" name="password" class="control-label" style="background: transparent;">كلمة السر</label>
                      <div class="float-right">
                      <!--  <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>-->
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      يجب ادخال كلمة السر بطريقة صحيحة
                    </div>
                  </div>
                  @error('username')
                  <span class="text-danger">{{ $message }}</span>        
                  @enderror
               <!--   <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>-->
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      تسجيل الدخول
                    </button>
                  </div>
                </form>
                 <!-- <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>
      
              </div>
            </div>
          <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register.html">Create One</a>
            </div>-->
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>