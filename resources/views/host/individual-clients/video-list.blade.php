@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            投稿リスト（表の線は分かりやすくするためにいれている）
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-hover table-striped">
                                <thead class="bg-info">
                                    <th>選択</th>
                                    <th>動画名</th>
                                    <th>動画名</th>
                                    <th>投稿日</th>
                                    <th>閲覧URL</th>
                                </thead>
                                <tbody>
                                    @forelse($videos as $video)
                                        <tr class="text-center">
                                            <td><input type="checkbox" name="" id=""></td>
                                            <td>{{ $video->name ?? '' }}</td>
                                            <td>
                                                <center>
                                                    <video
                                                        style="width: 70%; border:2px darkgreen dashed; position: relative; display:flex">
                                                        <source src="{{ $video->video_url }}">
                                                    </video>
                                                </center>
                                            </td>
                                            <td>{{ $video->created_at->format('Y-m-d') }}</td>
                                            <td style="width:45%;">
                                                <div class="container-fluid">
                                                            <input type="text" id="tocopy"  size="50" class="form-control" style="border:0;" value="" disabled>
                                                            <input type="hidden" id="copyUrl" value="{{ $video->video_url }}">
                                                    <div class="row align-items-center justify-content-center">

                                                        <button id="copySource" class="btn btn-warning col-3 mx-2"
                                                            onclick="copyVSOURCE('{{ $video->video_url }}')">COPY
                                                            URL</button>
                                                        <button class="btn btn-warning col-3 mx-2" type="button"
                                                            onclick="changeVSOURCE('{{ $video->video_url }}')">PREVIEW</button>
                                                        <button class="btn btn-danger col-3 mx-2">DELETE</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">NOTHING TO SEE HERE</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Video PREVIEW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video src="" id="player" class="w-100" style="border: 1px solid #c6c6c6" controls>
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
<script>
        function changeVSOURCE(srcVideo) {
            var video = document.getElementById('player');
            video.setAttribute('src', srcVideo);
            video.load();
            video.play();
            $(".modal").modal('show');
        }
        let value_url = $('#copyUrl').val()
        $('#tocopy').val(Base64.encode(value_url))


        function copyVSOURCE(data) {
            var data = Base64.encode(data);
            var dummy = document.createElement("input");

            // Add it to the document
            document.body.appendChild(dummy);

            // Set its ID
            dummy.setAttribute("id", "dummy_id");

            // Output the array into it
            document.getElementById("dummy_id").value = data;

            // Select it
            dummy.select();

            // Copy its contents
            document.execCommand("copy");

            // Remove it as its not needed anymore
            document.body.removeChild(dummy);
        }
    </script>
@endsection
