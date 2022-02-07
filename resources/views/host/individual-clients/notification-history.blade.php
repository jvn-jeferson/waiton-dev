@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">
                            届出サマリー
                        </h3>
                        <button class="float-right btn btn-warning col-2">変更・登録</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="w-25 text-bold" rowspan="5">主要な届出等の状況</td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                設立（開業）届出書
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                青色申告の申請
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                源泉所得税の納期の特例
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                給与支払事務所等の届出
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                申告期限の延長申請
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の課税事業者
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の免税事業者の届出
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の課税事業者の選択届出書
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">
                            過去の届出等の履歴
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <button class="float-right col-2 button btn-warning btn my-2" type="button" data-toggle="modal" data-target="#newNotificationModal">新規登録</button>
                            <table class="table table-bordered text-center">
                                <thead class="bg-lightblue">
                                    <th>種類</th>
                                    <th>提出日</th>
                                    <th>承認日</th>
                                    <th class="w-50">資料</th>
                                </thead>
                                <tbody>
                                    @forelse($archives as $archive)
                                        <tr>
                                            <td></td>
                                            <td>{{$archive->proposal_date->format('Y年m月d日')}}</td>
                                            <td>{{$archive->recognition_date->format('Y年m月d日')}}</td>
                                            <td class="text-info"><a href="{{Storage::disk('gcs')->url($archive->file->path)}}" download="{{$archive->file->name}}">{{$archive->file->name}}</a></td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

{{-- New Notification Modal --}}
<div class="modal fade" id="newNotificationModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="newNotificationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newNotificationModalLabel">新規登録フォーム</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <form action="{{route('save-notification-archive', ['client_id' => $client->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <table class="table-bordered bg-light table">
                            <tbody>
                                <tr>
                                    <td class="w-100">
                                        <label class="text-bold" for="notification_type">種類</label>
                                        <div class="form-group px-auto">
                                            <div class="form-check form-check-inline mr-5">
                                                <input class="form-check-input" type="radio" id="notification_type1" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type1">異動届</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type2" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type2">届出</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type3" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type3">申請</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type4" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type4">その他</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="proposal_date" class="col-sm-2 col-form-label">提出日</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="proposal_date" name="proposal_date" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="recognition_date" class="col-sm-2 col-form-label">承認日</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="recognition_date" name="recognition_date" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="attachment" class="col-sm-2 col-form-label">資料</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="file" name="file" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">新規登録</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')

@endsection
