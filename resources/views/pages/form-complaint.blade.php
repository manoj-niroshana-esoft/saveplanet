@extends('layouts/contentLayoutMaster')

@section('title', 'New Complaint')

@section('page-style')
<style>
  #map {
    height: 25rem;
  }

  .image-uploader {
    min-height: 10rem;
    border: 1px solid #d9d9d9;
    position: relative;
  }

  .image-uploader input[type="file"] {
    width: 0;
    height: 0;
    position: absolute;
    z-index: -1;
    opacity: 0;

  }

  .image-uploader input[type="file"] {
    background-color: transparent;
    border: none;
    border-radius: 0;
    outline: none;
    width: 100%;
    line-height: normal;
    font-size: 1em;
    padding: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
    margin: 0;
    color: rgba(0, 0, 0, 0.72);
    background-position: center bottom, center calc(100% - 1px);
    background-repeat: no-repeat;
    background-size: 0 2px, 100% 1px;
    -webkit-transition: background 0s ease-out 0s;
    -o-transition: background 0s ease-out 0s;
    transition: background 0s ease-out 0s;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#2196f3), to(#2196f3)), -webkit-gradient(linear, left top, left bottom, from(#d9d9d9), to(#d9d9d9));
    background-image: -webkit-linear-gradient(#2196f3, #2196f3), -webkit-linear-gradient(#d9d9d9, #d9d9d9);
    background-image: -o-linear-gradient(#2196f3, #2196f3), -o-linear-gradient(#d9d9d9, #d9d9d9);
    background-image: linear-gradient(#2196f3, #2196f3), linear-gradient(#d9d9d9, #d9d9d9);
    height: 2.4em;
  }

  .image-uploader .uploaded {
    padding: 0.5rem;
    line-height: 0;
  }

  .image-uploader .upload-text {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  .image-uploader .upload-text i {
    display: block;
    font-size: 3rem;
    margin-bottom: 0.5rem;
  }

  .image-uploader .upload-text span {
    display: block;
  }
</style>
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<script>
  (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
          ({ key: "AIzaSyDNT70lDbSZ992ZZm9FmBdGUyV-d9GkOqQ", v: "weekly" });
</script>
@endsection
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')

<!-- Form wizard with step validation section start -->
<section id="validation">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">New Complaint</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form method="POST" action="{{ route('new_complaint') }}" name="complaint_submit" id="complaint_submit"
              class="steps-validation wizard-circle" enctype="multipart/form-data">
              <!-- Step 1 -->
              @csrf
              <h6><i class="step-icon feather icon-home"></i> Step 1</h6>
              <fieldset>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="firstName3">
                        Complain Type
                      </label>
                      <select class="custom-select form-control" required id="complain_type" name="complain_type">
                        <option value="">Select Complaint Type</option>
                        <option value="wildlife">Wildlife</option>
                        <option value="forestry">Forestry</option>
                        <option value="env_crime">Environmental Crime</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastName3">
                        Complaint Description
                      </label>
                      <textarea name="shortDescription" required id="shortDescription3" rows="4"
                        class="form-control"></textarea>
                    </div>
                  </div>
                </div>

              </fieldset>

              <!-- Step 2 -->
              <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
              <fieldset>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="proposalTitle3">
                        Location
                      </label>
                      <div id="map"></div>
                      <input type="hidden" name="lat" id="lat">
                      <input type="hidden" required name="lon" id="lan">
                    </div>
                    <div class="form-group">
                      <label for="jobTitle5">
                        Picture of Evidence
                      </label>
                      {{-- <input type="file" id="images-1702563098199" name="images[]" multiple="multiple"> --}}
                      <div class="input-images" style="padding-top: .5rem;">
                        <div class="image-uploader">
                          <input type="file" id="images-multy" required name="images[]" multiple="multiple">
                          <div class="uploaded"></div>
                          <div class="upload-text"><i class="feather icon-upload-cloud"></i><span>Click to
                              browse</span><br><span id="img_count"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="jobTitle5">
                        Timeframe
                      </label>
                      <br>
                      <label for="jobTitle5">
                        From
                      </label>
                      {{-- <input type="file" id="images-1702563098199" name="images[]" multiple="multiple"> --}}
                      <div class="row">
                        <div class="col-6"><input type='text' required name="from_date"
                            class="form-control format-picker" />
                        </div>
                        <div class="col-6"> <input type='text' name="from_time" class="form-control pickatime" /></div>
                      </div>
                      <br>
                      <label for="jobTitle5">
                        To
                      </label>
                      {{-- <input type="file" id="images-1702563098199" name="images[]" multiple="multiple"> --}}
                      <div class="row">
                        <div class="col-6"><input type='text' name="to_date" class="form-control format-picker" /></div>
                        <div class="col-6"> <input type='text' name="to_time" class="form-control pickatime" /></div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Form wizard with step validation section end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/extensions/jquery.steps.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>

@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/wizard-steps.js')) }}"></script>

<script>
  // Initialize and add the map
  let map;
  let markers = [];
  async function initMap() {
    // The location of Uluru
    const position = { lat: 7.8731, lng: 80.7718 };
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    // The map, centered at Sri Lanka
    map = new Map(document.getElementById("map"), {
      zoom: 7,
      center: position,
      mapId: "DEMO_MAP_ID",
    });
    var clickedLocation = null;
    google.maps.event.addDomListener(map, "click", (event) => {
      clickedLocation = event.latLng;
      const positions = { lat: clickedLocation.lat(), lng: clickedLocation.lng() };
      deleteMarkers();
      addMarker(event.latLng);
      $('#lat').val(clickedLocation.lat());
      $('#lan').val(clickedLocation.lng());
      console.log('You clicked on: ' + clickedLocation.lat() + ',' + clickedLocation.lng());
    });
    // Adds a marker to the map and push to the array.
    function addMarker(position) {
      const marker = new google.maps.Marker({
        position,
        map,
      });

      markers.push(marker);
    }
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
      for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
    } function hideMarkers() {
      setMapOnAll(null);
    }
    function deleteMarkers() {
      hideMarkers();
      markers = [];
    }
  }

  initMap();
  $( ".input-images" ).on( "click", function() {
    document.getElementById("images-multy").click();
} );
$('#images-multy').change(function () {
    fileCount = this.files.length;
    if(fileCount>0){
$('#img_count').text(fileCount+' File Selected');
    }else{
      $('#img_count').text('No File Selected');
    }
})
 
</script>
<script>
  $('.format-picker').pickadate({
        format: 'yyyy-mm-dd'
    });
    $('.pickatime').pickatime({
        // Escape any “rule” characters with an exclamation mark (!).
        format: 'h:i',
        formatLabel: 'HH:i a',
        formatSubmit: 'HH:i',
        hiddenPrefix: 'prefix__',
        hiddenSuffix: '__suffix'
    });
</script>
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