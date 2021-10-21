@extends('layouts.blank-nav')

@section('extra-css')
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>

    <style>
        
        .loader {
        margin-left: 40%;
        margin-right: auto;
        position: relative;
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid blue;
        border-bottom: 16px solid blue;
        border-right: 16px solid green;
        border-left: 16px solid green;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        animation: spin 2s linear infinite;
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Explanation Video Creation
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9 justify-content-center">
                            <button id="prev">Previous</button>
                            <button id="next">Next</button>
                            <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                            <div class="float-right" style="display:none">
                                <form action="#" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="pdf-file" id="pdf-file">
                                    <input class="btn btn-primary" type="submit">Render</button>
                                </form>
                            </div>
                            <canvas style="width: 100%; border:2px dashed #c6c6c6" class="mt-2" id="pdf-canvas"></canvas>
                        </div>
                        <div class="col-3">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Video Information
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="video_name">Video Title</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <button class="btn-primary btn btn-block" id="start">Launch Recorder</button>
                                    <div class="form-group mt-2">
                                        <label for="tools">Drawing Tools</label>
                                        <button class="btn btn-block btn-light text-bold"><i class="fas fa-circle text-danger"></i> Pointer</button>
                                        <button class="btn btn-block btn-light text-bold" onclick="setPencil()" type="button"><i class="fas fa-pencil-alt"></i> Pencil</button>
                                        <button class="btn btn-block btn-light text-bold" onclick="setMarker()" type="button"><i class="fas fa-marker text-warning"></i> Higlighter</button>
                                    </div>
                                    <div class="form-row mt-2 text-center align-items-center">
                                        <div class="col-6">
                                            <input onInput="draw_color = this.value" type="color" class="color-picker">
                                        </div>
                                        <div class="col-6">
                                            <input onInput="draw_width = this.value" type="range" min="1" max="100" class="pen-range">
                                        </div>
                                    </div>
                                    <div class="form-row text-center align-items-center">
                                        <div class="col-6">
                                            <button class="btn btn-block btn-light" onclick="undo_last()">
                                                <i class="fas fa-undo"></i>
                                                Undo
                                            </button>
                                        </div>
                                    </div>

                                    <button class="btn btn-block btn-success mt-4" id="record"><i class="fa fas-circle-record-vinyl"></i> Start Recording</button>
                                    <button class="btn btn-block btn-danger" id="stop"><i class="fa fas-circle-stop"></i> Stop Recording</button>

                                    <div class="alert mt-2 text-center" id="loader-div" style="display: none">
                                        <div class="loader"></div>
                                        Recording...
                                    </div>

                                    <div class="mt-2">
                                        <video src="" style="width: 100%; border:1px dashed gray" id="video" autoplay muted></video>
                                    </div>

                                    <button class="btn btn-block btn-success mt-3" id="download">Download Video</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
@endsection

@section('extra-scripts')
<script src="{{ asset('js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const prev = document.querySelector('#prev'), 
        next = document.querySelector('#next'), 
        zoomIn = document.querySelector('#zoomIn'), 
        zoomOut = document.querySelector('#zoomOut'), 
        page = document.querySelector('#page-num'), 
        total_page = document.querySelector('#page-count')

    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1.0,
        canvas = document.querySelector('#pdf-canvas'),
        ctx = canvas.getContext('2d')
    
    function renderPage(num) {
        pageRendering = true;
        pdfDoc.getPage(num).then((page)=> {
            var viewport = page.getViewport({scale:scale});
            canvas.height = viewport.height
            canvas.width = viewport.width

            var renderContext = {
                canvasContext: ctx,
                viewport: viewport,
            }

            var renderTask = page.render(renderContext)
            renderTask.promise.then(()=> {
                pageRendering = false
                if(pageNumPending !== null) {
                    renderPage(pageNumPending)
                    pageNumPending = null
                }
            })
        })
        page.textContent = num
    }

    function queueRenderPage(num) {
        if(pageRendering) {
            pageNumPending = num
        }else{
            renderPage(num)
        }
    }

    function onPrevPage() {
        if(pageNum <= 1) {
            return
        }
        pageNum--
        queueRenderPage(pageNum)
    }

    function onNextPage() {
        if(pageNum>= pdfDoc.numPages){
            return
        }
        pageNum++
        queueRenderPage(pageNum)
    }

    prev.addEventListener('click', onPrevPage)
    next.addEventListener('click', onNextPage)

    pdfjsLib.getDocument('https://dagrs.berkeley.edu/sites/default/files/2020-01/sample.pdf').promise.then((doc)=>{
    pdfDoc = doc
    total_page.textContent = doc.numPages
    renderPage(pageNum)
    })
    
</script>

<script>
    

    var context = ctx;

    let draw_color = "black"
    let draw_width = "2"
    let is_drawing = false
    let is_pen = true
    let is_marker = false

    let restore_array = [];
    let index = -1;

    canvas.addEventListener('mousedown', start, false)
    canvas.addEventListener('mousemove', draw, false)

    canvas.addEventListener('mouseup', stop, false)
    canvas.addEventListener('mouseout', stop, false)

    function start(e) {
        is_drawing = true
        context.beginPath()
        context.moveTo(e.clientX-canvas.offsetLeft,  e.clientY-canvas.offsetTop)

        
        context.strokeStyle = draw_color
        context.lineWidth = draw_width
        if(is_marker) {
            context.lineCap = "square"
            context.globalAlpha = 0.1
        }
        else {
            context.lineCap = "round"
            context.lineJoin = "round"
        }
    }

 

    function draw(e) {
        if(is_drawing) {
            context.lineTo(e.clientX-canvas.offsetLeft, e.clientY-canvas.offsetTop)

            context.stroke()
        }
        e.preventDefault()
    }

    function stop(e) {
        if(is_drawing) {
            context.stroke()
            context.closePath()
            is_drawing = false
        }
        e.preventDefault()

        if(e.type !== 'mouseout') {
            restore_array.push(context.getImageData(0,0, canvas.width, canvas.height))
            index += 1

            console.log(restore_array)
        }
    }

    function clearCanvas() {

        queueRenderPage(pageNum)
        restore_array = []
        index = -1
    }

    function undo_last() {
        if(index <= 0) {
            clearCanvas()
        }else {
            index-=1
            restore_array.pop()
            context.putImageData(restore_array[index], 0, 0)
        }
    }

    function setPencil() {
        draw_color= "black"
        draw_width= "2"
        is_pen = true
        is_marker = false
    }

    function setMarker() {
        draw_color= "yellow"
        draw_width= "25"
        is_marker = true
        is_pen = false
    }
</script>

<script>
    'use strict';

    /* globals MediaRecorder */

    let mediaRecorder;
    let recordedBlobs;

    const recordButton = document.querySelector('button#record');
    const stopButton = document.querySelector('button#stop');
    const recordedVideo = document.querySelector('video#video');
    const downloadButton = document.querySelector('button#download');


    recordButton.addEventListener('click', () => {
        startRecording();
    });

    stopButton.addEventListener('click', () => {
    stopRecording();
    })



    downloadButton.addEventListener('click', () => {
        const blob = new Blob(recordedBlobs, {
            type: 'video/mp4'
        });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'test.mp4';
        document.body.appendChild(a);
        a.click();
        setTimeout(() => {
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }, 100);
    });

    function handleDataAvailable(event) {
        console.log('handleDataAvailable', event);
        if (event.data && event.data.size > 0) {
            recordedBlobs.push(event.data);
        }
    }

    function startRecording() {

        var loader = document.querySelector('#loader-div');
        loader.style.display = 'block';
        recordedBlobs = [];
        let options = {
            mimeType: 'video/webm;codecs=vp9,opus'
        };
        try {
            mediaRecorder = new MediaRecorder(window.stream, options);
        } catch (e) {
            console.error('Exception while creating MediaRecorder:', e);
            errorMsgElement.innerHTML = `Exception while creating MediaRecorder: ${JSON.stringify(e)}`;
            return;
        }

        console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
        recordButton.disabled = true;
        stopButton.disabled = false;
        mediaRecorder.onstop = (event) => {
            console.log('Recorder stopped: ', event);
            console.log('Recorded Blobs: ', recordedBlobs);
        };
        mediaRecorder.ondataavailable = handleDataAvailable;
        mediaRecorder.start();
        console.log('MediaRecorder started', mediaRecorder);
    }

    function stopRecording() {
        mediaRecorder.stop();
        var loader = document.querySelector('#loader-div');
        loader.style.display = 'none';
    }

    function handleSuccess(stream) {
        recordButton.disabled = false;
        console.log('getUserMedia() got stream:', stream);
        window.stream = stream;

        const gumVideo = document.querySelector('video#video');
        gumVideo.srcObject = stream;
    }

    async function init(constraints) {
        try {
            const stream = await navigator.mediaDevices.getDisplayMedia(constraints);
            handleSuccess(stream);
        } catch (e) {
            console.error('navigator.getUserMedia error:', e);
            errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
        }
    }

    document.querySelector('button#start').addEventListener('click', async() => {
        const constraints = {
            audio: false,
            video: {
                width: 1280,
                height: 720
            }
        };
        console.log('Using media constraints:', constraints);
        await init(constraints);
    });
</script>

<script>
    
</script>

@endsection