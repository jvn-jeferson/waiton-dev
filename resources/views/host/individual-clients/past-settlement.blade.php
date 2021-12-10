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
                                        <p><a href="#" onclick="window.open('{{route('video-creation', ['client_id'=>$hashids->encode($client->id)])}}');">こちらから動画を作成し. URLを貼り付けてください。</a></p>
                                        <input type="url" name="video_url" id="video-url" class="form-control" placeholder="動画のURLを貼り付けてください" value="{{old('video_url')}}">
                                        @error('video_url')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
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
                                                        <td class="bg-light">
                                                            <input type="text" name="kinds" id="kinds" class="form-control" value="{{old('kinds')}}">
                                                            @error('kinds')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>決算日</th>
                                                        <td class="bg-light">
                                                            <input type="date" class="form-control" name="settlement_date" id="settlement_date" value="{{old('settlement_date')}}">
                                                            @error('settlement_date')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>提出済み申告書一式</th>
                                                        <td class="bg-light">
                                                            <input type="file" name="file" id="file" class="form-control">
                                                            @error('file')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th>承認日</th>
                                                        <td class="bg-light">
                                                            <input type="date" class="form-control" name="proposal_date" id="proposal_date" value="{{old('proposal_date')}}">
                                                            @error('proposal_date')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>提出日</th>
                                                        <td class="bg-light">
                                                            <input type="date" class="form-control" name="recognition_date" id="recognition_date" value="{{old('recognition_date')}}">
                                                            @error('recognition_date')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>会社担当者</th>
                                                        <td class="bg-light">
                                                            <input type="text" name="company_representative" id="company_representative" class="form-control" value="{{old('company_representative')}}">
                                                            @error('company_representative')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>会計事務所担当者</th>
                                                        <td class="bg-light">
                                                            <input type="text" name="accounting_office_staff" id="accounting_office_staff" class="form-control" value="{{old('accounting_office_staff')}}">
                                                            @error('accounting_office_staff')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>動画投稿者</th>
                                                        <td class="bg-light">
                                                            <input type="text" name="video_contributor" id="video_contributor" class="form-control" value="{{old('video_contributor')}}">
                                                            @error('video_contributor')
                                                            <span class="text-danger">
                                                                {{$message}}
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>閲覧期限</th>
                                                        <td class="bg-light">
                                                            <input type="text" name="viewing_deadline" id="viewing_deadline" class="form-control" readonly value={{date("Y年m月d日", strtotime('+7 years'))}}>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>コメント</th>
                                                        <td class="bg-light">
                                                            <input type="text" name="comments" id="comments" class="form-control" value="{{old('comments')}}">
                                                        </td>
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
