@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        <img src="{{ asset('images/pages/login.png') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Login</h4>
                                </div>
                            </div>
                            <p class="px-2">Welcome back, please login to your account.</p>
                            <div class="card-content" style="padding-bottom: 4rem;">
                                <div class="card-body pt-1">
                                    <form method="POST" action="{{ route('authenticate') }}">
                                        @csrf
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                            <input type="email" class="form-control" id="user-name" name="email"
                                                placeholder="Email" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-user"></i>
                                            </div>
                                            <label for="user-name">Username</label>
                                        </fieldset>

                                        <fieldset class="form-label-group position-relative has-icon-left">
                                            <input type="password" class="form-control" id="user-password" name="password"
                                                placeholder="Password" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-lock"></i>
                                            </div>
                                            <label for="user-password">Password</label>
                                        </fieldset>
                                        <div class="form-group d-flex justify-content-between align-items-center">
                                            <div class="text-left">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">Remember me</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="text-right"><a href="auth-forgot-password" class="card-link">Forgot
                                                    Password?</a></div>
                                        </div>
                                        <a href="auth-register"
                                            class="btn btn-outline-primary float-left btn-inline">Register</a>
                                        <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/extensions/sweet-alerts.js')) }}"></script>
    @extends('layouts/messageView')
    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    type: "error",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });
            });
        </script>
    @elseif (session('warning'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Warning!",
                    text: "{{ session('warning') }}",
                    type: "warning",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });
            });
        </script>
    @elseif (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Good job!",
                    text: "{{ session('success') }}",
                    type: "success",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });
            });
        </script>
    @elseif (session('info'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Info!",
                    text: "{{ session('info') }}",
                    type: "info",
                    confirmButtonClass: 'btn btn-primary',
                    buttonsStyling: false,
                });
            });
        </script>
    @endif

@endsection
