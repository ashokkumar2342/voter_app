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
            alert(context);
        })
    </script>
  </div>
</div>
</body>
</html>