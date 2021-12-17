@extends('layouts.host-individual')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">
                            過去の決算
                        </h3>
                        <a class="btn btn-primary col-2 float-right" href="{{route('create-video', ['client_id' => $hashids->encode($client->id)])}}">
                            新規登録
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped text-center">
                                <thead class="thead-dark">
                                    <th>種類</th>
                                    <th>決算日</th>
                                    <th>提出済み申告書一式</th>
                                    <th>承認日 • 提出日</th>
                                    <th>説明動画</th>
                                </thead>
                                <tbody>
                                    @forelse($archives as $archive)
                                        <tr>
                                            <td>
                                                {{$archive->kinds}} <br>
                                                <a class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="ACCESS FILE" href="{{route('access-data-financial-record', ['record_id' => $hashids->encodeHex($archive->id), 'client_id' => $hashids->encode($client->id)])}}">アクセス</a>
                                            </td>
                                            <td>{{$archive->settlement_date->format('Y年m月d日')}}</td>
                                            <td class="text-info">{{$archive->file->name}}</td>
                                            <td>{{$archive->recognition_date->format('Y年m月d日')}} • {{$archive->proposal_date->format('Y年m月d日')}}</td>
                                            <td class="align-items-center text-center justify-content-center">
                                                <video style="width: 25%; border:2px darkgreen dashed; position: relative; display:flex">
                                                    <source src="{{$archive->video_url}}">
                                                </video>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"></td>
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
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection