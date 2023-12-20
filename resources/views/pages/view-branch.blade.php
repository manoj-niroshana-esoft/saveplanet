@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Branch')

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
                    <h4 class="card-title">Edit Branch</h4>
                    <a style="float: right" class="btn btn-primary mb-1"
                        href="{!! route('manage-branch.index') !!}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST"
                                    action="{{ route('manage-branch.new-update',['id'=>$branch['branch_id']]) }}">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <span>Branch Name</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control"
                                                            value="{{$branch->name}}" required name="branch_name"
                                                            placeholder="Branch Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <span>Division Name</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="custom-select form-control" required
                                                            id="division_id" name="division_id">
                                                            <option value="">Select Division</option>
                                                            @foreach ($divisions as $division)
                                                            @if($branch->division_id==$division->division_id)
                                                            <option selected value="{{$division->division_id}}">
                                                                {{$division->name}}
                                                            </option>
                                                            @else
                                                            <option value="{{$division->division_id}}">
                                                                {{$division->name}}
                                                            </option>
                                                            @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            <button type="reset"
                                                class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                            </div>
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