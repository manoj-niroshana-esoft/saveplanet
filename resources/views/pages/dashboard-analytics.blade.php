@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether-theme-arrows.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/shepherd-theme-default.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">
@endsection
@extends('layouts/messageView')

@section('content')
{{-- Dashboard Analytics Start --}}
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/elements/decore-left.png') }}" class="img-left" alt="card-img-left">
                        <img src="{{ asset('images/elements/decore-right.png') }}" class="img-right"
                            alt="card-img-right">
                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                            <div class="avatar-content">
                                <i class="feather icon-award white font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-2 text-white">Welcome {{session()->get('first_name').' '.session()->get('last_name')}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/tether.min.js')) }}"></script>
<!-- <script src="{{ asset(mix('vendors/js/extensions/shepherd.min.js')) }}"></script> -->
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
@endsection