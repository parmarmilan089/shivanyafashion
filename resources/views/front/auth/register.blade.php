@extends('front.layout.page')

@section('front-content')
  <section>
    <div class="page-header min-vh-100">
      <div class="container">
        <div class="row">
          <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
            <div class="position-relative bg-gradient-dark h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
              style="background-image: url('{{ asset('assets/img/illustrations/illustration-signup.jpg') }}'); background-size: cover;">
            </div>
          </div>
          <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="font-weight-bolder">Sign Up</h4>
                <p class="mb-0">Enter your details to register</p>
              </div>
              <div class="card-body">
                <form role="form" method="POST" action="{{ route('customer.register') }}">
                  @csrf 
                  <div class="row">

                    {{-- Name --}}
                    <div class="col-md-12">
                      <div class="input-group input-group-outline my-2 {{ old('name') ? 'is-filled' : '' }} @error('name') is-invalid @enderror">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                      </div>
                      @error('name')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-12">
                      <div class="input-group input-group-outline my-2 {{ old('email') ? 'is-filled' : '' }} @error('email') is-invalid @enderror">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                      </div>
                      @error('email')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-12">
                      <div class="input-group input-group-outline my-2 {{ old('phone') ? 'is-filled' : '' }} @error('phone') is-invalid @enderror">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                      </div>
                      @error('phone')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-12">
                      <div class="input-group input-group-outline my-2 @error('password') is-invalid @enderror">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                      </div>
                      @error('password')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-12">
                      <div class="input-group input-group-outline my-2 @error('password_confirmation') is-invalid @enderror">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                      </div>
                      @error('password_confirmation')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-md-12 mt-3">
                      <button type="submit" class="btn bg-gradient-dark text-white w-100">Register</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-2 text-sm mx-auto">
                  Already have an account?
                  <a href="{{ route('customer.login') }}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection