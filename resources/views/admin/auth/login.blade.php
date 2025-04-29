<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('public/assets/images/app/logo.jpeg') }}" type="image/x-icon">
    @include('admin.layouts.header')
    <title> Login | {{env('APP_NAME')}}</title>
</head>
<body>
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="mb-2 text-center">
                                        <img width="150px" src="{{ asset('assets/images/app/glowmart.webp') }}" alt="logo" />
                                    </div>
                                    <div class="text-center mb-4">
                                        <p class="mb-0">Please log in to your account</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" id="loginForm">
                                            @csrf
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                                                <div class="invalid-feedback email-error"></div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password" class="form-control border-end-0" id="password"  placeholder="Enter Password">
                                                    <a onclick="show_hide_password('show_hide_password')" href="javascript:;" class="input-group-text bg-transparent"> <i class='bxbx-hide'></i></a>
                                                    <div class="invalid-feedback password-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                {{-- <a href="{{ route('forgot_password') }}">Forgot Password ?</a> --}}
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.script')
    <script>
        loginForm.onsubmit = (e) =>{
            e.preventDefault();
            makePostRequest("{{route('admin.do.login')}}",loginForm,'loginForm')
        }
    </script>
</body>
</html>
