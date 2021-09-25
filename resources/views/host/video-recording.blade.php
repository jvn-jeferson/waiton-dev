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
                            <button class="btn btn-info ml-1" id="play" disabled><i class="fas fa-pause"></i> PAUSE</button>
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