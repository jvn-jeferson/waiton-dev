<?php $__env->startSection('extra-css'); ?>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>

    <style>
        .active {
            background-color: green !important;
            border-color: green;
            display: inline-block !important;
            border: none !important;
        }

        #pdf-canvas {
            border: 1px solid black;
        }

        .stroke-color {
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes  sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }

        @keyframes  spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .change-cursor {
            cursor: url("<?php echo e(asset('img/pointer.cur')); ?>"), auto;
        }

        .upfiling-cursor {
            position: inherit !important;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-9 justify-content-center upfiling-cursor" style="visibility: hidden;" id="video-container">
                    <button class="btn btn-primary" id="prev">Previous</button>
                    <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                    <canvas id="pdf-canvas"></canvas>
                    <button class="btn btn-primary" id="next">Next</button>
                </div>
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title">
                                PDFへの説明動画作成
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="" id="form" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <label for="pdfSource" class="btn btn-primary d-block">PDFファイルを選択</label>
                                <span id="pdf-name" class="text-bold"></span>
                                <input type="file" name="pdfSource" id="pdfSource" accept=".pdf" style="visibility: hidden">
                            </form>
                            <div class="form-group mt-2">
                                <label for="video_name">「動画名」</label>
                                <input type="text" id="video_title" name="video_title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-info-circle fa-2x mr-4" data-toggle="tooltip" data-placement="top"
                                        title="upfiling.jpのみを録画する場合、録画開始クリック後に1. Chromeタブ 2.upfiling.jpを選択 3. 共有をクリックしてください。4. 音声なしで録画する場合、タブの音声を共有にチェックが入っていることを確認してください。音声ありで録画する場合チェックを外してください。"></i>
                                </div>
                                <div class="col-9">
                                    <p>(録画選択画面について)</p>
                                </div>
                            </div>
                            <button class="btn-warning btn btn-block" id="start">録画する画面をえらんでスタート</button>
                            <button class="btn btn-block btn-warning mt-2" id="mute">
                                ミュート
                            </button>
                            <div class="form-group mt-2">
                                <label for="tools">描画ツール</label>
                                <button class="btn btn-block btn-light text-bold" onclick="setPointer()" id="pointerBtn"><i
                                        class="fas fa-circle text-danger"></i> ポインタ</button>
                                <button class="btn btn-block btn-light text-bold" onclick="setPencil()" type="button"
                                    id="pencilBtn"><i class="fas fa-pencil-alt"></i> 鉛筆</button>
                                <button class="btn btn-block btn-light text-bold" onclick="setMarker()" type="button"
                                    id="markerBtn"><i class="fas fa-marker text-warning"></i> マーカー</button>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-3">
                                    <label>Color</label>
                                </div>
                                <div class="col-9">
                                    <input type="color" oninput="stroke_color = this.value" list="presetColors">
                                    <datalist id="presetColors">
                                        <option>#FFFFFF</option>
                                        <option>#FF0000</option>
                                        <option>#00FF00</option>
                                        <option>#0000FF</option>
                                        <option>#FFFF00</option>
                                        <option>#FF00FF</option>
                                        <option>#00FFFF</option>
                                        <option>#800000</option>
                                        <option>#FFFFCC</option>
                                        <option>#00FFFF</option>
                                        <option>#FF9900</option>
                                    </datalist>
                                </div>
                            </div>
                            <br>
                            <div class="form-row text-center align-items-center">
                                <div class="col-6">
                                    <button class="btn btn-block btn-light" onclick="undo_last()">
                                        <i class="fas fa-undo"></i>
                                        元に戻す
                                    </button>
                                </div>
                            </div>

                            <button class="btn btn-block btn-warning mt-4" id="pause">
                                一旦停止</button>
                            <button class="btn btn-block btn-warning" id="stop"><i class="fa fas-circle-stop"></i>
                                収録終了</button>
                            <button class="btn btn-block btn-warning mt-5" id="preview" data-toggle="modal"
                                data-target=".bd-example-modal-lg">プレビュー</button>
                            
                            <input type="hidden" id="file_url" name="file_url" class="form-control" placeholder="動画のURLを表示"
                                readonly>
                            <button class="btn btn-block btn-warning mt-5" id="completion">完了</button>
                            <?php
                                $client_id = $hashids->encode($client->id);
                            ?>
                            <button class="btn btn-danger btn-block" onclick='cancelButton("<?php echo e($client_id); ?>")'>キャンセル
                            </button>
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>動画プレビュー</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <video width="100%" height="400" id="video" controls>
                                                        <source src="" type="video/mp4">
                                                    </video>
                                                </div>
                                                <div class="col-4">
                                                    <div class="table-responsive container">
                                                        <table class="table table-striped">
                                                            <tr>
                                                                <th>種類</th>
                                                                <td><?php echo e($record->kind ?? ''); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>提出済み申告書一式</th>
                                                                <td>
                                                                    <?php if($record): ?>
                                                                        <?php echo e($record->file->name); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>動画投稿者</th>
                                                                <td><?php echo e($record->video_contributor ?? ''); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>閲覧期限</th>
                                                                <td>
                                                                    <?php if($record): ?>
                                                                        <?php echo e($record->created_at->modify('+7 years')->format('Y-m-d')); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>コメント</th>
                                                                <td><?php echo e($record->comment ?? ''); ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
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

        function setPointer() {
            stroke_color = 'transparent'
            if (canvas.classList.contains('change-cursor')) {
                canvas.classList.remove('change-cursor');
            } else {
                canvas.classList.add('change-cursor');
            }

        }

        function setPencil() {
            canvas.classList.remove('change-cursor');
            stroke_color = 'black'
            stroke_width = "2"
        }

        function setMarker() {
            canvas.classList.remove('change-cursor');
            stroke_color = 'yellow'
            stroke_width = "10"
            context.globalCompositeOperation = "multiply";
            context.fillStyle = '#ff0'
        }

        $('button').click(function() {
            $('button').removeClass('active')
            $(this).addClass('active')
        })

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
        'use strict';
        /* globals MediaRecorder */
        let mediaRecorder;
        let recordedBlobs;
        var isRecording = false;
        const stopButton = document.querySelector('button#stop');
        const recordedVideo = document.querySelector('video#video');
        const downloadButton = document.querySelector('button#download');
        const pause_play = document.querySelector('button#pause');
        const completion = document.querySelector('button#completion');
        const muteButton = document.querySelector('button#mute');

        completion.addEventListener('click', () => {
            var vid_url = $('#file_url').val();
            var client_id = "<?php echo e($client->id); ?>"
            var video_title = $("#video_title").val();
            if (vid_url != '') {
                var url = "<?php echo e(route('save-url-to-database')); ?>"
                axios.post(url, {
                    video_url: vid_url,
                    client: client_id,
                    name: video_title
                }).then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: "録画保存に完了しました",
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        var target = response.data
                        window.location = target;
                    })
                }).catch(function(error) {
                    console.log(error)
                })
            }
        })

        stopButton.addEventListener('click', () => {
            stopRecording();
            window.stream = null;
            setTimeout(() => {
                $("#overlay").fadeIn(300);
                const blob = new Blob(recordedBlobs, {
                    type: 'video/mp4'
                });
                const blobUrl = window.URL.createObjectURL(blob);
                fetch(blobUrl).then(response => response.blob())
                    .then(blobs => {
                        const name = $("#video_title").val();
                        var form = $('form')[0]; // You need to use standard javascript object here
                        const fd = new FormData(form);
                        fd.append("file", blobs); // where `.ext` matches file `MIME` type
                        fd.append('fileName', name);
                        var url = "<?php echo e(route('save-video')); ?>"
                        return axios.post(url, fd, {
                            headers: {
                                "Content-Type": "application/json"
                            }
                        })
                    })
                    .then((response) => {
                        setTimeout(function() {
                            $("#overlay").fadeOut(300);
                        }, 3000);
                        $("#file_url").val(response.data);
                    })
                    .catch((error) => {
                        console.log(error.response.data);
                    });
            }, 100);
        })

        muteButton.addEventListener('click', () => {
            if (window.stream) {
                window.stream.getAudioTracks().forEach(function(track) {
                    console.log(track)
                    console.log(track.enabled)
                    if (track.enabled) {
                        Swal.fire({
                            icon: 'info',
                            title: 'ミュートオン!',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        muteButton.innerHTML = 'ミュートオン';
                        track.muted = false;
                        track.enabled = false;
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'ミュートオフ!',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        muteButton.innerHTML = 'ミュートオフ';
                        track.muted = true;
                        track.enabled = true;
                    }
                });
            }
        });
        //File URL
        // copy_url.addEventListener('click', () => {
        //     var textBox = document.getElementById("file_url");
        //     textBox.select();
        //     document.execCommand("copy");
        // })
        //Preview
        preview.addEventListener('click', () => {
            const blob = new Blob(recordedBlobs, {
                type: 'video/mp4'
            });
            var video = document.getElementById("video");
            video.src = window.URL.createObjectURL(blob);
        });

        pause_play.addEventListener('click', function() {
            if (isRecording) {
                mediaRecorder.pause();
                isRecording = false;
                pause_play.innerHTML = '再開';

                Swal.fire({
                    icon: 'info',
                    title: '一時停止中!',
                    showConfirmButton: false,
                    timer: 1000
                })
            } else {
                Swal.fire({
                    icon: 'info',
                    title: '録画再開中!',
                    showConfirmButton: false,
                    timer: 1000
                }).then((result) => {
                    mediaRecorder.resume();
                    isRecording = true;
                    pause_play.innerHTML = "一旦停止";
                })
            }
        })

        function cancelButton(id) {
            Swal.fire({
                icon: 'info',
                title: '録画をキャンセルしてよろしいですか？',
            }).then((result) => {
                var current_url = "<?php echo e(dirname(url()->current())); ?>";
                var url = current_url + "/dashboard?client_id=" + id;
                window.location = url;
            })
        }

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
                return;
            }
            stopButton.disabled = false;
            mediaRecorder.onstop = (event) => {
                console.log('Recorder stopped: ', event);
                console.log('Recorded Blobs: ', recordedBlobs);
            };
            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.start();
            isRecording = true;
            console.log(window.stream.getAudioTracks());
            if (window.stream.getAudioTracks()) {
                window.stream.getAudioTracks().forEach(function(track) {
                    console.log(track);
                    if (track.enabled) {
                        muteButton.innerHTML = 'ミュートオン';
                    } else {
                        muteButton.innerHTML = 'ミュートオフ';
                    }
                });
            }
        }

        function stopRecording() {
            mediaRecorder.stop();
            isRecording = false;
            Swal.fire({
                icon: 'warning',
                title: '録画完了',
                showConfirmButton: false,
                timer: 1000
            })
        }

        function handleSuccess(stream) {
            window.stream = stream;
            startRecording();
        }
        async function init(constraints) {
            try {
                const displayStream = await navigator.mediaDevices.getDisplayMedia(constraints);
                const voiceStream = await navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: false
                });
                let tracks = [...displayStream.getTracks(), ...voiceStream.getAudioTracks()]
                const stream = new MediaStream(tracks);
                handleSuccess(stream);

            } catch (e) {

            }
        }
        document.querySelector('button#start').addEventListener('click', async () => {
            Swal.fire({
                title: "録画画面選択について",
                text: 'upfiling.jpのみを録画する場合、録画開始クリック後に1. Chromeタブ 2.upfiling.jpを選択 3. 共有をクリックしてください。4. 音声なしで録画する場合、タブの音声を共有にチェックが入っていることを確認してください。音声ありで録画する場合チェックを外してください。'
            }).then((result) => {
                const constraints = {
                    video: {
                        width: 1280,
                        height: 720
                    },
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        sampleRate: 44100
                    }
                };
                init(constraints);
            })
        });
        var formData = new FormData();
        const fileInput = document.querySelector('#pdfSource')
        fileInput.onchange = () => {
            filename = fileInput.files[0];
            $('#pdf-name').innerHTML = filename
            formData.append('file', fileInput.files[0])
            var url = "<?php echo e(route('get-pdf-source')); ?>"
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.blank-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/host/individual-clients/video-creation.blade.php ENDPATH**/ ?>