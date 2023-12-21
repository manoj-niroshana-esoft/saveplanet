@extends('layouts/contentLayoutMaster')

@section('title', 'User Management Details')

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
                    <h4 class="card-title"></h4>
                    <div>
                        <a href="{{ route('view-user-management') }}">
                            <button type="button" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                                <i class="feather icon-arrow-left"></i>  Back
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <section id="multiple-column-form">
                            <div class="row match-height">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Edit User</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form" method="POST" action="{{ route('update_user_management') }}">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <input type="text" id="first-name-column" class="form-control" placeholder="First Name" name="fname_column" value="{{$users[0]['first_Name']}}">
                                                                    <label for="first-name-column">First Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <input type="text" id="last-name-column" class="form-control" placeholder="Last Name" name="lname_column" value="{{$users[0]['last_Name']}}">
                                                                    <label for="last-name-column">Last Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <input type="email" id="email-column" class="form-control" placeholder="Email" name="email_column" value="{{$users[0]['email']}}">
                                                                    <label for="email-column">Email</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <input type="text" id="nic-column" class="form-control" name="nic_column" placeholder="N.I.C" value="{{$users[0]['nic']}}">
                                                                    <label for="nic-column">N.I.C</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <textarea type="text" id="address-column" class="form-control" name="address_column" placeholder="Address">{{$users[0]['address']}} </textarea>
                                                                    <label for="Address-column">Address</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-label-group">
                                                                    <fieldset class="form-group" id="user-type-column" name="user_type_column">
                                                                        <select class="form-control" id="user-type">
                                                                            @if ($users[0]['user_type'] == 'Complainer')
                                                                                <option selected value="1">Complainer</option>
                                                                                <option value="2">Field Officer</option>
                                                                                <option value="3">Administrator</option>
                                                                            @elseif ($users[0]['user_type'] == 'Field Officer')
                                                                                <option value="1">Complainer</option>
                                                                                <option selected value="2">Field Officer</option>
                                                                                <option value="3">Administrator</option>
                                                                            @else
                                                                                <option value="1">Complainer</option>
                                                                                <option value="2">Field Officer</option>
                                                                                <option selected value="3">Administrator</option>
                                                                            @endif
                                                                        </select>
                                                                    </fieldset>
                                                                    <label for="user-type-column">User Type</label>
                                                                    <input type="hidden" id="user-id" class="form-control" name="user_id" value="{{$users[0]['user_id'] }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </section>
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
<script>
    $('#confirm-color').on('click', function () {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function (result) {
      if (result.value) {
        Swal.fire({
          type: "success",
          title: 'Deleted!',
          text: 'Your file has been deleted.',
          confirmButtonClass: 'btn btn-success',
        })
      }
      else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'Your imaginary file is safe :)',
          type: 'error',
          confirmButtonClass: 'btn btn-success',
        })
      }
    })
  });
</script>
@endif
@endsection