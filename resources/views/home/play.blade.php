<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$post->title}}</title>
</head>

<body>

    <link href="https://vjs.zencdn.net/7.7.6/video-js.css" rel="stylesheet" />

    <script src="https://vjs.zencdn.net/7.7.6/video.js"></script>

    {{-- <link href="{{asset('frontend/assets/css/videojs.watermark.css')}}" rel="stylesheet">
    <script src="{{asset('frontend/assets/js/videojs.watermark.js')}}"></script> --}}
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
        }

        span.vjs-resolution-button-staticlabel {
            position: absolute;
            right: 8px;
        }


        #play {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(at bottom, #1993ff, #121212 70%);
            height: 100%;

        }

        #player {
            width: 100%;
            height: 100vh;
        }

        .btn-white-color {
            position: fixed;
            color: white;
            top: 13px;
            left: 21px;
            z-index: 10;
        }

        .bg-tt {
            background: #1f57aa8a;
            padding: 4px 8px;
            border-radius: 4px;
            color: #ffffff94;
        }

        .object-fill {
            object-fit: fill;
        }

        .player-dimensions {
            width: 1250px;
            height: 521px;
        }
    </style>

    <body>

        <section id="play" class=" position-relative">
            <video class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" id="player" controls>
                @if (isset($post))
                <source src="{{$post->files->first()->file}}" type='video/mp4' label='' />
                @endif
            </video>
        </section>
    </body>
    <script>
        var video = videojs('player');
     video.responsive(true);
     
   
     
    </script>

</body>

</html>