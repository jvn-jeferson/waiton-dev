@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">過去決算</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <p><a href="#" onclick="window.open('{{route('video-creation', ['client_id'=>$hashids->encode($client->id)])}}');">こちらから動画を作成し. URLを貼り付けてください。</a></p>
                                    <input type="url" name="video-url" id="video-url" class="form-control" placeholder="動画のURLを貼り付けてください">
                                    <video style="width: 100%; border:2px darkgreen dashed; position: relative; display:flex" class="mt-2" id="video-player" controls><source src=""></video>
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
                                                    <td class="bg-light"><input type="text" name="settlement_type" id="settlement_type" class="form-control" /></td>
                                                </tr>
                                                <tr>
                                                    <th>決算日</th>
                                                    <td class="bg-light">
                                                        <input type="date" class="form-control" name="settlement_date" id="settlement_date">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>提出済み申告書一式</th>
                                                    <td class="bg-light"><input type="file" name="" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>承認日</th>
                                                    <td class="bg-light"><input type="date" class="form-control" name="proposal_date" id="proposal_date"></td>
                                                </tr>
                                                <tr>
                                                    <th>提出日</th>
                                                    <td class="bg-light"><input type="date" class="form-control" name="recognition_date" id="recognition_date"></td>
                                                </tr>
                                                <tr>
                                                    <th>会社担当者</th>
                                                    <td class="bg-light"><input type="text" name="company_representative" id="company_representative" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>会計事務所担当者</th>
                                                    <td class="bg-light"><input type="text" name="accouting_staff" id="accouting_staff" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>動画投稿者</th>
                                                    <td class="bg-light"><input type="text" name="video_contributor" id="video_contributor" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>閲覧期限</th>
                                                    <td class="bg-light"><input type="text" name="viewing_deadline" id="viewing_deadline" class="form-control" readonly></td>
                                                </tr>
                                                <tr>
                                                    <th>コメント</th>
                                                    <td class="bg-light"><input type="text" name="comments" id="comments" class="form-control"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card">
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <button type="button" onclick="window.open('{{route('video-creation', ['client_id'=>$hashids->encode($client->id)])}}');" class="btn btn-warning btn-block">動画作成</button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-warning  btn-block">プレビュー</button>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <button class="btn btn-warning  btn-block">登録</button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-danger  btn-block">削除</button>
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
@endsection

@section('extra-scripts')
    <script>
        var video_player = document.querySelector('#video-player')
        var src_input = document.querySelector('#video-url')

        $('#video-url').change(function() {
            var url = src_input.value;
            if(isValidHttpUrl(url)){
                $('source').attr('src',url)
                video_player.load()
                video_player.play()
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
    </script>
@endsection
