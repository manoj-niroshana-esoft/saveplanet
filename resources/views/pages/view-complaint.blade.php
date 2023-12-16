@extends('layouts/contentLayoutMaster')

@section('title', 'View Complaint Details')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Complaints</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Complain Type</th>
                                        <th>Institution</th>
                                        <th>Complain Description</th>
                                        <th>Timeframe</th>
                                        <th>Reported By</th>
                                        <th>Created Time</th>
                                        <th>Updated Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaints as $complaint)
                                    <tr>
                                        <td>{{$complaint['complain_type']}}</td>
                                        <td>{{$complaint['institution']}}</td>
                                        <td>{{$complaint['description']}}</td>
                                        <td>{{$complaint['timeframe']}}</td>
                                        <td>{{$complaint['reported_by']}}</td>
                                        <td>{{$complaint['created_at']}}</td>
                                        <td>{{$complaint['updated_at']}}</td>
                                        <td>
                                            <a href="{!! route('view_complaint_details', ['id'=>$complaint['complaint_id']]) !!}"
                                                target="_blank"><i class="feather icon-map-pin"></i></a>
                                            <a href="{!! route('track_complaints', ['id'=>$complaint['complaint_id']]) !!}"
                                                target="_blank"><i class="feather icon-search"></i></a>
                                            {{-- <a href=""><i class="feather icon-edit"></i></a>
                                            <a href=""><i class="feather icon-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Complain Type</th>
                                        <th>Institution</th>
                                        <th>Complain Description</th>
                                        <th>Timeframe</th>
                                        <th>Reported By</th>
                                        <th>Created Time</th>
                                        <th>Updated Time</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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