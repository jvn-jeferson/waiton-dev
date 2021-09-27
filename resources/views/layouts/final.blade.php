
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-envelope"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-bell"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        株式会社ABC
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('img/sample/w-logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Waiton</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/sample/w-logo.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">株式会社ABC</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="home" class="nav-link  @if(request()->route()->getName() == 'home') active  @endif">
              <i class="nav-icon fas fa-home"></i>
              <p>
              ホーム
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-phone-square-alt"></i>
              <p>
              個人の連絡先
              </p>
            </a>
          </li>
          
          <li class="nav-header mt-3">文書</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-upload"></i>
              <p>
              To　会計事務所
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-download"></i>
              <p>
              From　会計事務所
                <span class="right badge badge-danger">2</span>
              </p>
            </a>
          </li>
          
          <li class="nav-header mt-3">記録</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                過去の決算
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                通知
                  <span class="right badge badge-warning">3</span>
                </p>
              </a>
          </li>

          
          <li class="nav-header mt-3">ツール</li>
          <li class="nav-item">
             
            <a href="screen-recording" class="nav-link  @if(request()->route()->getName() == 'screen_recording') active  @endif">
                <i class="nav-icon fas fa-video"></i>
                <p>
                過去の決算
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                届届出
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                各種設定
                </p>
              </a>
          </li>
          
          <li class="nav-header mt-5"></li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-question-circle"></i>
              <p>
                FAQ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-comment-dots"></i>
              <p>
              問合せ
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a class="log-out-btn" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout </a>
            
        <li class="nav-item">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <main class="py-4">
            @yield('content')
        </main>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

<script>

'use strict';

let mediaRecorder;
let recordedBlobs;

const stop = document.querySelector('button#stop');
const record = document.querySelector('button#record');
const video = document.querySelector('video#video');
const play = document.querySelector('button#play');
const download = document.querySelector('button#download');

document.querySelector("button#start").addEventListener("click", async()=>{
    const constraints = {
        audio:false,
        video:{width:1280, height:720}
    };

    await init(constraints);
});

async function init(constraints) {
    try {
        const stream = await navigator.mediaDevices.getDisplayMedia(constraints);
        handleSuccess(stream)
    }catch(e){
        console.log(e.message);
    }
}

function handleSuccess(stream) {
    record.disabled = false

    window.stream = stream

    const video = document.querySelector("video#video")
    video.srcObject = stream

}

</script>

</body>
</html>
