@extends('layouts.host')
@section('extra-css')
    <style>
        label.label input[type="file"] {
            position: absolute;
            top: -1000px;
        }
        .label {
            cursor: pointer;
            border: 1px solid #cccccc;
            border-radius: 5px;
            padding: 5px 15px;
            margin: 5px;
            background: #dddddd;
            display: inline-block;
        }
        .label:hover {
            background: #5cbd95;
        }
        .label:active {
            background: #9fa1a0;
        }
        .label:invalid+span {
            color: #000000;
        }
        .label:valid+span {
            color: #ffffff;
        }

        #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.75) url(images/loading2.gif) no-repeat center center;
        z-index: 10000;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    全顧客への連絡
                                </h3>
                                @if(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <strong>{{ Session::get('success') }}</strong>
                                    </div>

                                @endif
                            </div>
                            <div class="card-body">
                                <div class="row text-bold">
                                    <div class="col-auto">
                                        <h4>全顧客向けに共通連絡を行うことができます</h4>
                                    </div>
                                </div>
                                <form method="post" enctype="multipart/form-data" id="messageClientsForm" action="send-notification">
                                    @csrf
                                    <div class="card bg-primary">
                                        <div class="card-body text-light">
                                            <input type="hidden" name="is_global" id="is_global" value="1">
                                            <input type="hidden" name="targeted_at" id="targeted_at" value="0">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label for="scheduled_at" class="text-bold">指定日（設定しない場合は、投稿日で連絡されます)</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="date" name="scheduled_at" id="scheduled_at" class="form-control" min="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-auto">
                                                    <label for="contents" class="text-bold">コメント欄</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <textarea required name="contents" id="contents" rows="5" class="form-control" placeholder="コメントを投稿 "></textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-auto">
                                                    <input type="file" name="files" id="files">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 align-items-right">
                                        <div class="col-9"></div>
                                        <div class="col-3">
                                            <input type="submit" class="btn btn-warning btn-block text-light text-bold" value="登録">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-success card-outline collapsed-card">
                            <div class="card-header">
                                <h2 class="card-title tex-bold">投稿履歴</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3">
                                        <button class="btn btn-primary btn-block">選択した投稿を削除</button>
                                    </div>
                                </div>

                                <div class="table-responsive mt-2">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead bg-light">
                                            <th>選択</th>
                                            <th>投稿日</th>
                                            <th>指定日程</th>
                                            <th>コメント</th>
                                            <th>投稿資料</th>
                                        </thead>
                                        <tbody>
                                            @forelse($messages as $message)
                                                <tr>
                                                    <td><input type="checkbox" name="select" id="select" value="{{$message->id}}"></td>
                                                    <td>{{$message->created_at->format('Y年m月d日 • H:i')}}</td>
                                                    <td>@if($message->scheduled_at)
                                                        {{$message->scheduled_at->format('Y年m月d日')}}
                                                        @else
                                                        {{""}}
                                                        @endif
                                                    </td>
                                                    <td>{!! nl2br($message->contents) !!}</td>
                                                    <td class="text-info">
                                                        @if($message->file)
                                                            <a href="#" onclick="downloadFile({{$message->file->id}}, this)">{{$message->file->name}}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        表示するレコードはありません。
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="loader"></div>
@endsection

@section('extra-scripts')

<script>
    var spinner = $('#loader')

    $(function() {
        $('form').submit(function(e) {
            Swal.showLoading()
        })
    })

    function downloadFile(id, button)
    {
        var url = "{{route('download-document-files')}}"

        axios.post(url, {
            file_id: id
        }).then(function (response) {
            const link = document.createElement('a')
            link.href = response.data[0]
            link.setAttribute('download', response.data[1]);
            link.click();
            button.disabled = 'disabled'
        }).catch(function (error) {
            Swal.fire({
                title: "ERROR",
                text: error.message,
                icon: 'danger',
                showCancelButton: false
            })
        })
    }
</script>
@endsection
