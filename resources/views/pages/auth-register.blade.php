@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

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
        <div class="col-xl-8 col-10 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                        <img src="{{ asset('images/pages/register.jpg') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Create Account</h4>
                                </div>
                            </div>
                            <p class="px-2">Fill the below form to create a new account.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('register_user') }}">
                                        @csrf
                                        <div class="form-label-group">
                                            <input type="text" id="inputName" name="first_name" class="form-control"
                                                placeholder="First Name" required>
                                            <label for="inputName">First Name</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="text" id="inputName" name="last_name" class="form-control"
                                                placeholder="Last Name" required>
                                            <label for="inputName">Last Name</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="text" id="inputName" name="address" class="form-control"
                                                placeholder="Address" required>
                                            <label for="inputName">Address</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="text" id="inputName" name="nic" class="form-control"
                                                placeholder="NIC" required>
                                            <label for="inputName">NIC</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="email" id="inputEmail" name="email" class="form-control"
                                                placeholder="Email" required>
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="password" id="inputPassword" name="password" class="form-control"
                                                placeholder="Password" required>
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="password" id="inputConfPassword" name="confirm_password"
                                                class="form-control" placeholder="Confirm Password" required>
                                            <label for="inputConfPassword">Confirm Password</label>
                                        </div>
                                        <a href="auth-login"
                                            class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                        <button type="submit"
                                            class="btn btn-primary float-right btn-inline mb-50">Register</a>
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
