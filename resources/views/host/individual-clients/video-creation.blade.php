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
            <div class="col-9 justify-content-center" style="visibility: hidden;" id="video-container">
                <button class="btn btn-primary" id="prev">Previous</button>
                <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                <canvas id="pdf-canvas"></canvas>
                <button class="btn btn-primary" id="next">Next</button>
            </div>
            <div class="col-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="card-title">
                            動画情報
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="pdfSource" id="pdfSource" class="form-control" accept=".pdf">
                        </form>
                        <div class="form-group mt-2">
                            <label for="video_name">名前</label>
                            <input type="text" id="video_title" name="video_title" class="form-control">
                        </div>
                        <button class="btn-warning btn btn-block" id="start">レコーダーを起動</button>
                        <div class="form-group mt-2">
                            <label for="tools">描画ツール</label>
                            <button class="btn btn-block btn-light text-bold" onclick="setPointer()"><i class="fas fa-circle text-danger"></i> ポインタ</button>
                            <button class="btn btn-block btn-light text-bold" onclick="setPencil()" type="button"><i class="fas fa-pencil-alt"></i> 鉛筆</button>
                            <button class="btn btn-block btn-light text-bold" onclick="setMarker()" type="button"><i class="fas fa-marker text-warning"></i> マーカー</button>
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
                                    元に戻す
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-block btn-warning mt-4" id="record"><i class="fa fas-circle-record-vinyl"></i> スタート</button>
                        <button class="btn btn-block btn-warning" id="stop"><i class="fa fas-circle-stop"></i> 収録終了</button>
                        <button class="btn btn-block btn-warning mt-5" id="download">プレビュー</button>
                        <div class="form-group">
                            <label for="video_name">URLをコピー</label>
                            <input type="text" id="file_url" name="file_url" class="form-control" readonly>
                        </div>
                        <button class="btn btn-block btn-warning mt-5" id="preview">完了</button>
                    </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('extra-scripts')

<script>
    var pdf_file = '';
    var imageData_store = [];
    let restore_array = [];
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
        scale = 1.5,
        canvas = document.getElementById('pdf-canvas');
    ctx = canvas.getContext('2d')
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    function renderPage(num, result = []) {
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
            if (result.length != 0) {}
            imageData_store.forEach(function(i, key) {
                ctx.putImageData(imageData_store[key], 0, 0)
            })
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
        var result = imageData_store.push(context.getImageData(0, 0, canvas.width, canvas.height));
        queueRenderPage(pageNum, result)
    }
    prev.addEventListener('click', onPrevPage)
    next.addEventListener('click', onNextPage)
</script>

<script>
    var context = ctx
    let start_index = -1
    let stroke_color = 'black'
    let stroke_width = "2"
    let is_drawing = false

    function change_color(element) {
        stroke_color = element.style.background;
    }

    function change_width(element) {
        stroke_width = element.innerHTML
    }

    function setPencil() {
        stroke_color = 'black'
        strocke_width = "2"
    }

    function setMarker() {
        stroke_color = 'yellow'
        stroke_width = "10"
        context.fillStyle = 'hsla(0, 0%, 40%, 0)'
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

    function clearCanvas() {
        queueRenderPage(pageNum)
        restore_array = []
        start_index = -1
    }

    function undo_last() {
        if (start_index <= 0) {
            clearCanvas()
        } else {
            start_index -= 1
            restore_array.pop()
            context.putImageData(restore_array[start_index], 0, 0)
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
    //CHANGE TO UPLOAD TO GOOGLE DRIVE
    //RETURN GDRIVE LINKS
    downloadButton.addEventListener('click', () => {
        const blob = new Blob(recordedBlobs, {
            type: 'video/mp4'
        });
        const blobUrl = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';

        fetch(blobUrl).then(response => response.blob())
            .then(blobs => {
                const name = $("#video_title").val();
                const fd = new FormData();
                fd.append("file", blobs); // where `.ext` matches file `MIME` type
                fd.append('fileName',name);
                var save_url = "{{route('save-video')}}"
                return axios.post(url,fd, {
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
            })
            .then((response) => {
                console.log(response);
                $("#file_url").val(response.data);
            })
            .catch(err => console.log(err));
        document.body.appendChild(a);
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
    var formData = new FormData();
    const fileInput = document.querySelector('#pdfSource')
    fileInput.onchange = () => {
        formData.append('file', fileInput.files[0])
        var url = "{{route('get-pdf-source')}}"
        axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data)
                var path = response.data
                var base_url = "<?php echo env('APP_URL'); ?>"
                var file_path = base_url + path
                pdf_file = path
                pdfjsLib.getDocument(file_path).promise.then((doc) => {
                    var video_container = document.getElementById('video-container');
                    video_container.style.visibility = 'visible';
                    pdfDoc = doc
                    total_page.textContent = doc.numPages
                    renderPage(pageNum)
                })
            })
            .catch(function(error) {
                console.log(error.response.data);
            })
    }
</script>

@endsection
