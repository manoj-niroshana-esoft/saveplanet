@extends('layouts/contentLayoutMaster')

@section('title', 'View Complaints')

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
                                            <a><i class="feather icon-map-pin"></i></a>
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
                            {{-- location model --}}
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Vertically Centered
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Croissant jelly-o halvah chocolate sesame snaps. Brownie caramels candy
                                                canes chocolate cake
                                                marshmallow icing lollipop I love. Gummies macaroon donut caramels
                                                biscuit topping danish.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-dismiss="modal">Accept</button>
                                        </div>
                                    </div>
                                </div>
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