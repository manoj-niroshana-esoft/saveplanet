@extends('layouts/contentLayoutMaster')

@section('title', 'View Complaint Details')

@section('page-style')
<script>
    (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
            ({ key: "AIzaSyDNT70lDbSZ992ZZm9FmBdGUyV-d9GkOqQ", v: "weekly" });
</script>
@endsection

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
        <div class="col-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Complaint Details</h4>
                </div>
                <input type="hidden" name="longitude" id="longitude" value="{{$complaints['longitude']}}">
                <input type="hidden" name="latitude" id="latitude" value="{{$complaints['latitude']}}">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <div id="map" style="height: 26rem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Evidence</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                @foreach ($complaints['complaint_details'] as $complaint_detail)
                                @if ($loop->first)
                                <div class="carousel-item active">
                                    <img class="img-fluid" src="/storage/{{$complaint_detail['picture_of_evidence']}}"
                                        alt="First slide">
                                </div>
                                @else
                                <div class="carousel-item">
                                    <img class="img-fluid" src="/storage/{{$complaint_detail['picture_of_evidence']}}"
                                        alt="First slide">
                                </div>
                                @endif
                                @endforeach

                                {{-- <div class="carousel-item">
                                    <img class="img-fluid" src="{{ asset('images/slider/03.jpg') }}" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="{{ asset('images/slider/01.jpg') }}" alt="Third slide">
                                </div> --}}
                            </div>
                            <a class="carousel-control-prev" href="#carousel-example-generic" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-generic" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a style="float: right" class="btn btn-primary mb-1" href="{!! route('view_complaint') !!}">Back</a>
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


<script>
    // Initialize and add the map
    let map;
    let markers = [];
    async function initMap() {
      $latitude=  parseFloat($('#latitude').val());
      $longitude=  parseFloat($('#longitude').val());
      // The location of Uluru
      const position = { lat: $latitude, lng:  $longitude };
      const { Map } = await google.maps.importLibrary("maps");
      const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
  
      // The map, centered at Sri Lanka
      map = new Map(document.getElementById("map"), {
        zoom: 9,
        center: position,
        mapId: "DEMO_MAP_ID",
      });
      const marker = new google.maps.Marker({
          position,
          map,
        });
    //   var clickedLocation = null;
    //   google.maps.event.addDomListener(map, "click", (event) => {
    //     clickedLocation = event.latLng;
    //     const positions = { lat: clickedLocation.lat(), lng: clickedLocation.lng() };
    //     deleteMarkers();
    //     addMarker(event.latLng);
    //     $('#lat').val(clickedLocation.lat());
    //     $('#lan').val(clickedLocation.lng());
    //   });
    //   // Adds a marker to the map and push to the array.
    //   function addMarker(position) {
    //     const marker = new google.maps.Marker({
    //       position,
    //       map,
    //     });
  
    //     markers.push(marker);
    //   }
    //   // Sets the map on all markers in the array.
    //   function setMapOnAll(map) {
    //     for (let i = 0; i < markers.length; i++) {
    //       markers[i].setMap(map);
    //     }
    //   } function hideMarkers() {
    //     setMapOnAll(null);
    //   }
    //   function deleteMarkers() {
    //     hideMarkers();
    //     markers = [];
    //   }
    }
  
    initMap();
</script>
@endsection