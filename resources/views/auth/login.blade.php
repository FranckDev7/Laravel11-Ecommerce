@extends('layouts.app')

@section('content')
  <main class="pt-90">
    <div class="pb-4 mb-4"></div>
    <section class="container login-register">
      <ul class="mb-5 nav nav-tabs" id="login_register" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
            role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
        </li>
      </ul>
      <div class="pt-2 tab-content" id="login_register_tab_content">
        <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
          <div class="login-form">
            <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate="">
              @csrf
                {{-- email --}}
                <div class="mb-3 form-floating">
                    <input class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required="" autocomplete="email" autofocus="">
                    <label for="email">Email address *</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>

               <div class="pb-3"></div>

                {{-- password --}}
                <div class="mb-3 form-floating">
                    <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required=""
                    autocomplete="current-password">
                    <label for="customerPasswodInput">Password *</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

              <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

              <div class="mt-4 text-center customer-option">
                <span class="text-secondary">No account yet?</span>
                <a href="{{ route('register') }}" class="btn-text js-show-register">Create Account</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
