@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                        {{date_format($message->scheduled_at, 'Y年m月d日')}}
                                      </strong>
                                      - {{$message->contents}}
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
                                                <td>{{$upload->file_name}}</td>
                                                <td>をアップロードしました。</td>
                                                <td>{{$upload->created_at->modify('+1 month')->format('Y年m月d日')}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center"></td>
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
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                From会計事務所
                            </h3>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection