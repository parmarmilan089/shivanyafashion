@extends('front.layout.page')

@section('front-content')
<main class="main-content mt-0 ps">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-dark h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                            style="background-image: url('../../../assets/img/illustrations/illustration-signup.jpg'); background-size: cover;">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                        <div class="card card-plain mt-4">
                            <div class="card-header">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your email and password to log in</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('customer.login') }}">
                                    @csrf

                                    <div
                                        class="input-group input-group-outline my-3 {{ old('email') ? 'is-filled' : '' }} @error('email') is-invalid @enderror">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror

                                    <div
                                        class="input-group input-group-outline my-3 @error('password') is-invalid @enderror">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                    @enderror

                                    <div class="form-check form-check-info text-start ps-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">
                                            Sign In
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-2 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="{{ url('customer/register') }}" class="text-primary text-gradient font-weight-bold">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
