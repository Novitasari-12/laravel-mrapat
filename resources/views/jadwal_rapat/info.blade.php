<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Info</title>
    @include('user-partials.style')
</head>
<body>
    <div class="container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="{{0}}" class="active"></li>
                @foreach ($igambar as $key => $item)
                    <li data-target="#myCarousel" data-slide-to="{{$key+1}}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                
                    <div class="card" style="display: inline;">
                        <div class="card-header">
                            <center>
                                <a href=" {{route('jadwal_rapat.layar_penuh')}} " class="btn btn-xs btn-primary"> <span class="fa fa-eye"></span> Lebih Jelas </a>
                                <button id='info-fullscreen' class="btn btn-xs btn-primary"> <i class="fa fa-tv" aria-hidden="true"></i> Layar Penuh </button>
                            </center>
                        </div>
                        <div class="card-body">
                            <div class="carousel-item active">
                                <iframe id="frame" style="border: none ; height: 786px;" class="col-md-12" src=" {{route('jadwal_rapat.layar_penuh')}} " title="W3Schools Free Online Web Tutorials"></iframe>
                            </div>  
                             @foreach ($igambar as $key => $item)
                                <div class="carousel-item">
                                    <img src=" {{$item->gambar}} " alt="Los Angeles" class="d-block w-100 h-100" >
                                </div>
                            @endforeach
                        </div>
                    </div>
                
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>

    </div>
    @include('user-partials.script')
    <script>
        let fullscreen = document.getElementById('info-fullscreen')
        fullscreen.onclick = function (event) {
            if (document.fullscreenElement) {
                fullscreen.value = 'Fullscreen'
                document.exitFullscreen()
                .then(() => console.log("Document Exited form Full screen mode"))
                .catch((err) => console.error(err))
            } else {
                fullscreen.value = 'Default'
                document.documentElement.requestFullscreen();
            } 
        }
        // $('.carousel').carousel({
        //     interval: 10000
        // })
    </script>
</body>
</html>