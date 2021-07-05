{{-- @extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Card Print</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <a class="btn_web btn btn-default btn-xs" onclick="callPopupMd(this,'{{ route('admin.camera.test') }}')" href="javascript:;"><i class="fa fa-camera" style="margin: 10px"></i></a>
            </div>
        </div> 
    </div> 
</section>
@endsection
@push('scripts')
<script>

</script>
@endpush

 --}}
 <!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
  <div class="card card-info"> 
            <div class="card-body">

    <video id="video" width="440" height="480" autoplay></video>
    <button id="snap">Take Photo</button>
    <canvas id="canvas" width="440" height="480"></canvas>
    <script>
        let canvas = document.querySelector("#canvas");
        let context = canvas.getContext("2d");
        let video = document.querySelector("#video");
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
            navigator.mediaDevices.getUserMedia({video:true}).then((stream)=>{
                video.srcObject=stream;
                video.play();
            })
        
        }
        document.getElementById("snap").addEventListener("click",()=>{
            context.drawImage(video,0,0,440,480);
            
        })
    </script>
  </div>
</div>
</body>
</html>