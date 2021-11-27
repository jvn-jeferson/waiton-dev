@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-sm-12 col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    現状のプラン：
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>選択プラン</th>
                                                <th>{{Auth::user()->accountingOffice->subscription->subscription_plan->name}}</th>
                                            </tr>
                                            <tr>
                                                <td>利用者数</td>
                                                <td>{{Auth::user()->accountingOffice->staff->count()}} 社</td>
                                            </tr>
                                            <tr>
                                                <td>ご利用期日</td>
                                                <td>{{date_format(Auth::user()->accountingOffice->subscription->created_at, 'F j, Y')}} ~ </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    プランの変更
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>プラン変更</th>
                                            <td>
                                                <button class="btn btn-warning btn-flat btn-block">利用規約に同意して購入依頼する</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>確認事項</th>
                                            <td class="text-info text-center">特定商取引に関する法律に基づく表記</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">サブスクリプションプランのオプション</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-bordered table ">
                                        <thead class="bg-success text-bold">
                                            <th>プラン名</th>
                                            <th>おためし</th>
                                            <th>ライトプラン</th>
                                            <th>ミドルプラン</th>
                                            <th>ミドルプラン</th>
                                            <th>ギガプラン</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>利用者数</th>
                                                <td>1社</td>
                                                <td>5社以下</td>
                                                <td>10社以下</td>
                                                <td>50社以下</td>
                                                <td>100社以下</td>
                                            </tr>
                                            <tr>
                                                <th>機能</th>
                                                <td>動画作成は年間３本までになります。</td>
                                                <td colspan='4' class="text-center">全ての機能をご利用できます</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    利用料金 <br>
                                                    （税別）
                                                </th>
                                                <td>無料</td>
                                                <td>年間 <br> 36,000円 <br><br>１社月額 <br>600円</td>
                                                <td>年間 <br> 60,000円 <br><br>１社月額 <br>500</td>
                                                <td>年間 <br> 240,000円 <br><br>１社月額 <br>400</td>
                                                <td>年間 <br> 360,000円 <br><br>１社月額 <br>300</td>
                                            </tr>
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
@endsection

@section('extra-scripts')
    <script type="text/javascript" src="{{ asset('js/app.js')}}"></script>
@endsection