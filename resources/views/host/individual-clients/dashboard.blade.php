@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                連絡事項
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <ul class="list-group list-group-flush">
                                  @forelse($messages as $message)
                                    <li class="list-group-item">
                                      <i class="fas fa-circle @if($message->is_global == 0) text-success @else text-primary @endif"></i>
                                      <strong class="@if($message->is_global == 0) text-success @else text-primary @endif">
                                        @if($message->scheduled_at)
                                        {{date_format($message->scheduled_at, 'Y年m月d日')}}
                                        @else
                                        {{$message->created_at->format('Y年m月d日')}}
                                        @endif
                                      </strong>
                                      - {!! nl2br(e($message->contents)) !!}  @if($message->file) <a href="#" onclick="downloadFile({{$message->file->id}}, this)"><i class="fa fas fa-paperclip"></i></a> @endif
                                    </li>
                                  @empty
                                    <li class="text-info list-group-item">
                                      新しい通知はありません.
                                    </li>
                                  @endforelse
                                </ul>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                To会計事務所
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>アップロード日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                        <th>視聴期限</th>
                                    </thead>
                                    <tbody>
                                        @forelse($uploads as $upload)
                                            <tr>
                                                <td>{{date_format($upload->created_at, 'Y年m月d日')}}</td>
                                                <td class="text-primary"><a href="#" onclick="downloadFile({{$upload->file->id}}, this)">{{$upload->file->name}}</a></td>
                                                <td>をアップロードしました。</td>
                                                <td>{{$upload->created_at->modify('+1 month')->format('Y年m月d日')}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    表示するレコードがありません
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
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                From会計事務所
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>郵送日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                        <th>確認状況</th>
                                        <th>視聴期限</th>
                                    </thead>
                                    <tbody>
                                        @forelse($downloads as $download)
                                           <tr>
                                               <td>{{$download->created_at->format('Y年m月d日')}}</td>
                                               <td class="text-info">@if($download->file) <a href="#" onclick="downloadFile({{$download->file->id}}, this)">{{$download->file->name ?? ''}}@endif</a></td>
                                               <td>
                                                   @switch($download->status)
                                                        @case(1)
                                                            UPLOADED
                                                            @break
                                                        @case(2)
                                                            ADMITTED
                                                            @break
                                                        @case(3)
                                                            RESERVED
                                                            @break
                                                        @default
                                                            {{""}}
                                                            @break
                                                    @endswitch
                                               </td>
                                               <td>
                                                   @if($download->priority > 0)
                                                    確認依頼あり
                                                   @else
                                                    {{""}}
                                                    @endif
                                                </td>
                                               <td>{{$download->created_at->modify('+1 month')->format('Y年m月d日')}}</td>
                                           </tr>
                                        @empty
                                           <tr>
                                               <td colspan="5" class="text-center text-info">
                                                表示するレコードがありません
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
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                資料の保管
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <th>アップロード日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                    </thead>
                                    <tbody>
                                        @forelse($uploads as $upload)
                                            <tr>
                                                <td>{{$upload->created_at->format('Y年m月d日')}}</td>
                                                <td><a href="#" onclick="downloadFile({{$upload->file->name}}, this)">{{$upload->file->name}}</a></td>
                                                <td>が保存されました。</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-info">
                                                表示するレコードがありません
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
        </section>
    </div>
@endsection

@section('extra-scripts')

<script>

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
