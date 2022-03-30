@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <form action="{{route('save-taxation-history', ['client_id'=>$hashids->encode($client->id)])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">過去決算</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <input type="hidden" name="client_id" id="client_id" value="{{$hashids->encode($client->id)}}">
                                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                                        @if($record)
                                        <input type="hidden" name="record_id" id="record_id" value="{{$record->id}}">
                                        @endif
                                        <p><a href="#" onclick="window.open('{{route('video-creation', ['client_id'=>$hashids->encode($client->id), 'record_id' => $record->id ?? 0])}}');">こちらから動画を作成し. URLを貼り付けてください。</a></p>
                                        <input type="text" name="video-url" id="video-url" class="form-control" placeholder="動画のURLを貼り付けてください" value="{{base64_encode($record->video_url) ?? ''}}">
                                        <input type="hidden" name="video_url" id="video_url" value="{{$record->video_url ?? ''}}">
                                        @error('video_url')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                        <video style="width: 100%; border:2px darkgreen dashed; position: relative; display:flex" class="mt-2" id="video-player" controls><source src="@if($record){{$record->video_url}}@endif"></video>
                                    </div>
                                    <div class="col-5">
                                        <h4 class="text-bold">
                                            必要事項を入力・アップロードしてください。
                                        </h4>
                                        <div class="table-responsive">
                                            <table class="table-bordered table">
                                                <tbody>
                                                    <tr>
                                                        <th>種類</th>
                                                        <td class="bg-light">
                                                            <select name="kinds" id="kinds" class="form-control">
                                                                <option value="決算書">決算書</option>
                                                                <option value="届出">届出</option>
                                                                <option value="申請">申請</option>
                                                                <option value="その他">その他</option>
                                                            </select>
                                                            @error('kinds')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>提出日</th>
                                                        <td class="bg-light">
                                                            <input type="date" class="form-control" name="settlement_date" id="settlement_date" value="{{$record != null ? $record->settlement_date->format('Y-m-d') : date('Y-m-d')}}">
                                                            @error('settlement_date')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>保管ファイル</th>
                                                        <td class="bg-light">
                                                            @if($record == null)
                                                                <input type="file" name="file" id="file" class="form-control" >
                                                                @error('file')
                                                                <span class="text-danger">
                                                                    {{$message}}
                                                                </span>
                                                                @enderror
                                                            @else
                                                                <input type="text" name="file" id="file" class="form-control" readonly value="{{ $record->file->name ?? ''}}">
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>コメント</th>
                                                        <td class="bg-light">
                                                            <textarea rows="5" type="text" name="comment" id="comment" class="form-control" value="{{$record->comment ?? ''}}"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card">
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <button type="button" onclick="window.open('{{route('video-creation', ['client_id'=>$hashids->encode($client->id), 'record_id' => $record->id ?? 0])}}');" class="btn btn-warning btn-block">動画作成</button>
                                                </div>
                                                <div class="col-6">
                                                    <button class="btn btn-warning  btn-block" type="button">プレビュー</button>
                                                </div>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <button class="btn btn-warning  btn-block" type="submit">登録</button>
                                                </div>
                                                <div class="col-6">
                                                    <button class="btn btn-danger  btn-block" type="button">削除</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
<script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
    <script>
        var video_player = document.querySelector('#video-player')
        var src_input = document.querySelector('#video-url')

        $('#video-url').keyup(function() {
            var url = src_input.value;
            var value_url = Base64.decode(url)
            var ci = document.getElementById('video-player')
            var vidSrc = document.getElementById('vidsrc');
            if(isValidHttpUrl(value_url)){
                $('source').attr('src',value_url)
                $("#video_url").val(value_url)
                video_player.load()
            }
            else {
                console.log('ERROR')
            }
        })

        function isValidHttpUrl(string) {
            let url;

            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }

            return url.protocol === "http:" || url.protocol === "https:";
        }



        function openVideoRecorder()
        {
            var target_url = "{{route('video-creation', ['client_id'=>$hashids->encode($client->id)])}}"
            var kinds = document.querySelector('input#kinds')
            var settlement_date = document.querySelector('input#settlement_date')
            var file = document.querySelector('input#file')
            var recognition_date = document.querySelector('input#recognition_date')
            var proposal_date = document.querySelector('input#proposal_date')
            var company_representative = document.querySelector('input#company_representative')
            var accounting_office_staff = document.querySelector('input#accounting_office_staff')
            var video_contributor = document.querySelector('input#video_contributor')
            var comment = document.querySelector('input#comment')


        }

        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })
    </script>
@endsection
