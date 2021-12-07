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
@endsection