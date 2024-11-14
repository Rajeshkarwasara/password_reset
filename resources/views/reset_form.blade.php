<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 11 Multi Auth</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <section class=" p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="card border border-light-subtle rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">


                        
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h4 class="text-center">Reset Password</h4>
                                    </div>
                                </div>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{route('ProcessResetPassword')}}" method="post">
                                @csrf
                                <input type="hidden" name="token" id="" value="{{$token}}">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" value="{{old('password')}}"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" placeholder="enter a password">
                                            <label for="password" class="form-label">New Password</label>
                                            @error('password')
                                                <p class="invalid-feedback">
                                                    {{$message}}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" value="{{old('confirm_password')}}"
                                                class="form-control @error('password') is-invalid @enderror" name="confirm_password"
                                                id="confirm_password" placeholder="enter a confirm password">
                                            <label for="password" class="form-label">confirm password</label>
                                            @error('confirm_password')
                                                <p class="invalid-feedback">
                                                    {{$message}}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-primary py-3"
                                                type="submit">Update Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">

                                    <div
                                        class=" mt-3 d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                        <a href="{{route('Account.login')}}"
                                            class="link-secondary text-decoration-none">Click here to login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>