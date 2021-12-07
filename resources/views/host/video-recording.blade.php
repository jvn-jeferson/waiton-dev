@extends('layouts.final')

@section('content')
<style>
    video {
        vertical-align: top;
        width: 100%;
        height: 100%;
    }
    
    video:last-of-type {
        margin: 0 0 20px 0;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home <i class="fa fa-angle-right"></i> Video Creation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item"><a href="video-creation">Video Creation</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-primary">Explanation Video Recording</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-9 align-items-center">
                        
                        <video src="" id="video" style="border: 1px solid #c6c6c6;" autoplay muted></video>
                        <div>
                            <span id="errorMsg"></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h3 class="text-dark">Video Information</h3>
                        <input type="text" class="form-control" placeholder="Enter a Video Title">
                        <div class="form-group mt-2">
                            <button class="btn btn-primary mx-auto" id="start"><i class="fas fa-play-circle"></i> START</button>
                            <button class="btn btn-info ml-1" id="record" disabled><i class="fas fa-record-vinyl"></i> RECORD</button>
                            <button class="btn btn-info ml-1" id="pause" disabled><i class="fas fa-pause"></i> PAUSE</button>
                            <button class="btn btn-danger ml-auto" id="stop" disabled><i class="fas fa-stop"></i> STOP</button>
                        </div>
                        <hr class="bg-info mt-3 mb-3">
                        <button class="btn btn-success" id="play"><i class="fas fa-eye"></i> PREVIEW</button>
                        <hr class="bg-info mt-3 mb-3">
                        <button class="btn btn-success" id="download"><i class="fas fa-arrow-alt-circle-down"></i> DOWNLOAD</button>
                        <hr class="bg-info mt-3 mb-3">
                        <button class="btn btn-info"><i class="fas fa-share-alt"></i> COPY URL</button>
                        <input type="text" class="form-control mt-3" placeholder="video url">
                        <hr class="bg-info mt-3 mb-3">
                        <button class="btn btn-primary">COMPLETION</button>
                    </div>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  @endsection

@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

<script>
  'use strict';

  /* globals MediaRecorder */

  let mediaRecorder;
  let recordedBlobs;

  const errorMsgElement = document.querySelector('span#errorMsg');
  const recordedVideo = document.querySelector('video#video');
  const recordButton = document.querySelector('button#record');
  const playButton = document.querySelector('button#play');
  const downloadButton = document.querySelector('button#download');
  const stopButton = document.querySelector('button#stop');


  recordButton.addEventListener('click', () => {
      startRecording();
  });

  stopButton.addEventListener('click', () => {
    stopRecording();
    playButton.disabled = false;
    downloadButton.disabled = false;
  })


  playButton.addEventListener('click', () => {
      const superBuffer = new Blob(recordedBlobs, {
          type: 'video/webm'
      });
      recordedVideo.src = null;
      recordedVideo.srcObject = null;
      recordedVideo.src = window.URL.createObjectURL(superBuffer);
      recordedVideo.controls = true;
      recordedVideo.play();
  });


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
      playButton.disabled = true;
      downloadButton.disabled = true;
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

@endsection