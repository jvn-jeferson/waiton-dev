@extends('layouts.blank-nav')

@section('extra-css')
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>

<style>
    #pdf-canvas {
        border: 1px solid black;
    }

    .stroke-color {
        border-radius: 50%;
        width: 30px;
        height: 30px;
    }

    .loader {
        margin-left: 40%;
        margin-right: auto;
        position: relative;
        border: 16px solid #f3f3f3;
        /* Light grey */
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content">
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
                <canvas id="pdf-canvas"></canvas>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Explanation Video Creation
                        </h3>
                    </div>
                    <div class="card-body">
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
                                        <input type="color" oninput="stroke_color = this.value" placeholder="Colors">
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
        canvas = document.getElementById('pdf-canvas');
    ctx = canvas.getContext('2d')
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    function renderPage(num) {
        pageRendering = true;
        pdfDoc.getPage(num).then((page) => {
            var viewport = page.getViewport({
                scale: scale
            });
            canvas.height = viewport.height
            canvas.width = viewport.width

            var renderContext = {
                canvasContext: ctx,
                viewport: viewport,
            }

            var renderTask = page.render(renderContext)
            renderTask.promise.then(() => {
                pageRendering = false
                if (pageNumPending !== null) {
                    renderPage(pageNumPending)
                    pageNumPending = null
                }
            })
        })
        page.textContent = num
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num
        } else {
            renderPage(num)
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) {
            return
        }
        pageNum--
        queueRenderPage(pageNum)
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return
        }
        pageNum++
        queueRenderPage(pageNum)
    }

    prev.addEventListener('click', onPrevPage)
    next.addEventListener('click', onNextPage)

    var pdf_file = "{{asset('temp/sample.pdf')}}"
    pdfjsLib.getDocument(pdf_file).promise.then((doc) => {
        pdfDoc = doc
        total_page.textContent = doc.numPages
        renderPage(pageNum)
    })
</script>

<script>
    var context = ctx;

    let restore_array = [];
    let start_index = -1;
    let stroke_color = 'black';
    let stroke_width = "2";
    let is_drawing = false;

    function change_color(element) {
        stroke_color = element.style.background;
    }

    function change_width(element) {
        stroke_width = element.innerHTML
    }

    function start(event) {
        is_drawing = true;
        context.beginPath();
        context.moveTo(getX(event), getY(event));
        event.preventDefault();
    }

    function draw(event) {
        if (is_drawing) {
            context.lineTo(getX(event), getY(event));
            context.strokeStyle = stroke_color;
            context.lineWidth = stroke_width;
            context.lineCap = "round";
            context.lineJoin = "round";
            context.stroke();
        }
        event.preventDefault();
    }

    function stop(event) {
        if (is_drawing) {
            context.stroke();
            context.closePath();
            is_drawing = false;
        }
        event.preventDefault();
        restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
        start_index += 1;
    }

    function getX(event) {
        if (event.pageX == undefined) {
            return event.targetTouches[0].pageX - canvas.offsetLeft
        } else {
            return event.pageX - canvas.offsetLeft
        }
    }


    function getY(event) {
        if (event.pageY == undefined) {
            return event.targetTouches[0].pageY - canvas.offsetTop
        } else {
            return event.pageY - canvas.offsetTop
        }
    }

    canvas.addEventListener("touchstart", start, false);
    canvas.addEventListener("touchmove", draw, false);
    canvas.addEventListener("touchend", stop, false);
    canvas.addEventListener("mousedown", start, false);
    canvas.addEventListener("mousemove", draw, false);
    canvas.addEventListener("mouseup", stop, false);
    canvas.addEventListener("mouseout", stop, false);

    function Restore() {
        if (start_index <= 0) {
            Clear()
        } else {
            start_index += -1;
            restore_array.pop();
            if (event.type != 'mouseout') {
                context.putImageData(restore_array[start_index], 0, 0);
            }
        }
    }

    function Clear() {
        context.fillStyle = "white";
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.fillRect(0, 0, canvas.width, canvas.height);
        restore_array = [];
        start_index = -1;
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

    document.querySelector('button#start').addEventListener('click', async () => {
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
