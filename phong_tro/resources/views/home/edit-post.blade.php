@extends('layouts.master')
@section('content')
<div class="gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h1 class="entry-title entry-prop">Đăng tin Phòng trọ</h1>
			<hr>
			<div class="panel panel-default">
				<div class="panel-heading">Thông tin bắt buộc*</div>
				<div class="panel-body">
					<div class="gap"></div>
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(session('warn'))
            <div class="alert bg-danger">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Error!</span>  {{session('warn')}}
            </div>
            @endif
            @if(session('success'))
            <div class="alert bg-success">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Done!</span>  {{session('success')}}
            </div>
            @endif
            @if(Auth::user()->tinhtrang != 0)
			<form action="{{ route ('user.edit-post',['slug'=>$motelroom->slug]) }}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="usr">Tiêu đề bài đăng:</label>
                    <input type="text" class="form-control" name="txttitle" value="{{ $motelroom->title}}">
                </div>
                <div class="form-group">
                    <label>Địa chỉ phòng trọ:</label>
                    <input type="text" id="location-text-box" name="txtaddress" class="form-control" value="{{ $motelroom->address}}" />
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="usr">Giá phòng( vnđ ):</label>
                        <input type="number" name="txtprice" class="form-control" placeholder="750000" value="{{ $motelroom->price}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="usr">Diện tích( m<sup>2</sup> ):</label>
                        <input type="number" name="txtarea" class="form-control" placeholder="16" value="{{ $motelroom->area}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="usr">Quận/ Huyện:</label>
                        <select class="selectpicker pull-right" data-live-search="true" name="iddistrict">
                            @foreach($district as $quan)
                            @if($quan->id === $motelroom->district_id)
                            <option selected data-tokens="{{$quan->slug}}" value="{{ $quan->id }}">{{ $quan->name }}</option>
                            @else
                            <option data-tokens="{{$quan->slug}}" value="{{ $quan->id }}">{{ $quan->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="usr">Danh mục:</label>
                        <select class="selectpicker pull-right" data-live-search="true" class="form-control" name="idcategory"> 
                            @foreach($categories as $category)
                            @if($category->id === $motelroom->category_id)
                            <option selected data-tokens="{{$category->slug}}" value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                            <option data-tokens="{{$category->slug}}" value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="usr">SĐT Liên hệ:</label>
                    <input type="text" name="txtphone" class="form-control" placeholder="0915111234" value="{{ $motelroom->phone}}">
                </div>
            </div>
        </div>
        <?php json_decode($motelroom->utilities, true) ?>
            <div class="form-group">
              <!-- ************* Max Items Demo ************* -->
              <label>Các tiện ích có trong phòng trọ:</label>
              <select id="select-state" name="tienich[]" multiple class="demo-default" placeholder="Chọn các tiện ích phòng trọ" >
                @if(in_array("Wifi miễn phí",json_decode($motelroom->utilities, true)))
                    <option value="Wifi miễn phí" selected>Wifi miễn phí</option>
                @else
                    <option value="Wifi miễn phí">Wifi miễn phí</option>
                @endif

                @if(in_array("Có gác lửng",json_decode($motelroom->utilities, true)))
                    <option value="Có gác lửng" selected>Có gác lửng</option>
                @else
                    <option value="Có gác lửng">Có gác lửng</option>
                @endif

                @if(in_array("Tủ + giường",json_decode($motelroom->utilities, true)))
                    <option value="Tủ + giường" selected>Tủ + giường</option>
                @else
                    <option value="Tủ + giường">Tủ + giường</option>
                @endif

                @if(in_array("Không chung chủ",json_decode($motelroom->utilities, true)))
                    <option value="Không chung chủ" selected>Không chung chủ</option>
                @else
                    <option value="Không chung chủ">Không chung chủ</option>
                @endif

                @if(in_array("Chung chủ",json_decode($motelroom->utilities, true)))
                    <option value="Chung chủ" selected>Chung chủ</option>
                @else
                    <option value="Chung chủ">Chung chủ</option>
                @endif

                @if(in_array("Giờ giấc tự do",json_decode($motelroom->utilities, true)))
                    <option value="Giờ giấc tự do" selected>Giờ giấc tự do</option>
                @else
                    <option value="Giờ giấc tự do">Giờ giấc tự do</option>
                @endif

                @if(in_array("Vệ sinh riêng",json_decode($motelroom->utilities, true)))
                    <option value="Vệ sinh riêng" selected>Vệ sinh riêng</option>
                @else
                    <option value="Vệ sinh riêng">Vệ sinh riêng</option>
                @endif

                @if(in_array("Vệ sinh chung",json_decode($motelroom->utilities, true)))
                    <option value="Vệ sinh chung" selected>Vệ sinh chung</option>
                @else
                    <option value="Vệ sinh chung">Vệ sinh chung</option>
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="comment">Mô tả ngắn:</label>
              <textarea class="form-control" rows="5" name="txtdescription" style=" resize: none;">{{ $motelroom->description}}</textarea>
            </div>
            
            <div class="form-group">
              <label for="comment">Thêm hình ảnh:</label>
              <div class="file-loading">
                <input id="file-5" type="file" class="file" name="hinhanh[]">
              </div>
            </div>
            
            <button class="btn btn-primary">Đăng Tin</button>
          </form>
          @else
          <div class="alert bg-danger">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            <span class="text-semibold">Error!</span>  Tài khoản của bạn đang bị khóa đăng tin.
          </div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-4">
     <div class="contactpanel">
      <div class="row" style="margin-top: 50px;">
        <div class="col-md-4 text-center">
						@if($motelroom->user->avatar == 'no-avatar.jpg')
							<img src="images/no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
						@else
							<img src="uploads/avatars/<?php echo $motelroom->user->avatar; ?>" class="img-circle" alt="Cinque Terre" width="100" height="100"> 
						@endif
        </div>
        <div class="col-md-8">
          <h4>Thông tin người đăng</h4>
          <strong> {{ Auth::user()->name }}</strong><br>
          <i class="far fa-clock"></i> Ngày tham gia: {{ Auth::user()->created_at }}	

        </div>
    </div>
  </div>
  
  <div class="gap"></div>
  <img src="images/banner-1.png" width="100%">
</div>
</div>
</div>
<script type="text/javascript">
  $('#file-5').fileinput({
    theme: 'fa',
    language: 'vi',
    showUpload: false,
    allowedFileExtensions: ['jpg', 'png', 'gif']
  });
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzlVX517mZWArHv4Dt3_JVG0aPmbSE5mE&callback=initialize&libraries=geometry,places" async defer></script>
<script>
  var map;
  var marker;
  function initialize() {
    var mapOptions = {
      center: {lat: 16.070372, lng: 108.214388},
      zoom: 12
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Get GEOLOCATION
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
        position.coords.longitude);
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({
        'latLng': pos
      }, function (results, status) {
        if (status ==
          google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            console.log(results[0].formatted_address);
          } else {
            console.log('No results found');
          }
        } else {
          console.log('Geocoder failed due to: ' + status);
        }
      });
      map.setCenter(pos);
      marker = new google.maps.Marker({
        position: pos,
        map: map,
        draggable: true
      });
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }

  function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
      var content = 'Error: The Geolocation service failed.';
    } else {
      var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
      map: map,
      zoom: 19,
      position: new google.maps.LatLng(16.070372,108.214388),
      content: content
    };

    map.setCenter(options.position);
    marker = new google.maps.Marker({
      position: options.position,
      map: map,
      zoom: 19,
      icon: "images/gps.png",
      draggable: true
    });
    / Dragend Marker / 
    google.maps.event.addListener(marker, 'dragend', function() {
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            $('#location-text-box').val(results[0].formatted_address);
            $('#txtaddress').val(results[0].formatted_address);
            $('#txtlat').val(marker.getPosition().lat());
            $('#txtlng').val(marker.getPosition().lng());
            infowindow.setContent(results[0].formatted_address);
            infowindow.open(map, marker);
          }
        }
      });
    });
    / End Dragend /

  }
 }