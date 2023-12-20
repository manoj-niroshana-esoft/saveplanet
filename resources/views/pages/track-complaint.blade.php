@extends('layouts/contentLayoutMaster')

@section('title', 'Track Complaints')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<style>
    .hh-grayBox {
        /* background-color: #F8F8F8; */
        margin-bottom: 20px;
        padding: 35px;
        margin-top: 20px;
    }

    .row {
        margin: 0px !important;
        flex-wrap: nowrap !important;
    }

    .pt45 {
        padding-top: 45px;
    }

    .order-tracking {
        text-align: center;
        width: 33.33%;
        position: relative;
        display: block;
    }

    .order-tracking .is-complete {
        display: block;
        position: relative;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        border: 0px solid #AFAFAF;
        background-color: #f7be16;
        margin: 0 auto;
        transition: background 0.25s linear;
        -webkit-transition: background 0.25s linear;
        z-index: 2;
    }

    .order-tracking .is-complete:after {
        display: block;
        position: absolute;
        content: '';
        height: 14px;
        width: 7px;
        top: -2px;
        bottom: 0;
        left: 5px;
        margin: auto 0;
        border: 0px solid #AFAFAF;
        border-width: 0px 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
    }

    .order-tracking.completed .is-complete {
        border-color: #27aa80;
        border-width: 0px;
        background-color: #27aa80;
    }

    .order-tracking.completed .is-complete:after {
        border-color: #fff;
        border-width: 0px 3px 3px 0;
        width: 7px;
        left: 11px;
        opacity: 1;
    }

    .order-tracking p {
        color: #A4A4A4;
        font-size: 16px;
        margin-top: 8px;
        margin-bottom: 0;
        line-height: 20px;
    }

    .order-tracking p span {
        font-size: 14px;
    }

    .order-tracking.completed p {
        color: #000;
    }

    .order-tracking::before {
        content: '';
        display: block;
        height: 3px;
        width: calc(100% - 40px);
        background-color: #f7be16;
        top: 13px;
        position: absolute;
        left: calc(-50% + 20px);
        z-index: 0;
    }

    .order-tracking:first-child:before {
        display: none;
    }

    .order-tracking.completed:before {
        background-color: #27aa80;
    }
</style>
@endsection

@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Track Complaints</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-5">
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">Complain Type : {{$complaint['complain_type']}}
                                            </li>
                                            <li class="list-group-item">Institution : {{$complaint['institution']}}
                                            </li>
                                            <li class="list-group-item">Compaint : {{$complaint['description']}}</li>
                                            <li class="list-group-item">Timeframe : {{$complaint['timeframe']}}</li>
                                            <li class="list-group-item">Reported By : {{$complaint['reported_by']}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5" @if ($complaint['complain_status']==4) hidden @endif @if ($request->session()->get('auth_type')!=2) hidden @endif>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('save_track_complaints') }}" method="post">
                                            @csrf
                                            <ul class="list-group">
                                                <li class="list-group-item"> Change Status :
                                                    <select class="custom-select form-control" required
                                                        id="complain_status" name="complain_status">
                                                        <option value="">Select Complaint Status</option>
                                                        <option value="3">Ongoing</option>
                                                        <option value="4">Completed</option>
                                                    </select>
                                                </li>
                                                <li class="list-group-item"> Comment :
                                                    <textarea name="comment" required id="comment" rows="2"
                                                        class="form-control"></textarea>
                                                    <input type="hidden" name="complain_id"
                                                        value="{{$complaint['complaint_id']}}">
                                                </li>
                                                <li class="list-group-item">
                                                    <button type="submit" style="float: right"
                                                        class="btn btn-primary">Save</button>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                                    <div class="row justify-content-between">
                                        @switch($complaint['complain_status'])
                                        @case(1)
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Complained<br><span>{{$tracking_details[0]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Officer Assigned<br><span></span></p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Ongoing<br><span></span></p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Completed<br><span></span></p>
                                        </div>
                                        @break
                                        @case(2)
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Complained<br><span>{{$tracking_details[0]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Officer Assigned<br><span>{{$tracking_details[1]['created_at']}}</span>
                                            </p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Ongoing<br><span></span></p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Completed<br><span></span></p>
                                        </div>
                                        @break
                                        @case(3)
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Complained<br><span>{{$tracking_details[0]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Officer Assigned<br><span>{{$tracking_details[1]['created_at']}}</span>
                                            </p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Ongoing<br><span>{{$tracking_details[2]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking">
                                            <span class="is-complete"></span>
                                            <p>Completed<br><span></span></p>
                                        </div>
                                        @break
                                        @case(4)
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Complained<br><span>{{$tracking_details[0]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Officer Assigned<br><span>{{$tracking_details[1]['created_at']}}</span>
                                            </p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Ongoing<br><span>{{$tracking_details[2]['created_at']}}</span></p>
                                        </div>
                                        <div class="order-tracking completed">
                                            <span class="is-complete"></span>
                                            <p>Completed<br><span>{{$tracking_details[3]['created_at']}}</span></p>
                                        </div>
                                        @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a style="float: right" class="btn btn-primary mb-1" href="{!! route('view_complaint') !!}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/datatables/datatable.js')) }}"></script>
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
