@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12">

                        @if ( Session::has('success') )
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{ Session::get('success') }}</strong>
                        </div>
                        @endif
                        <div class="div card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    事業者一覧
                                </h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-auto"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>新規追加</th>
                                                    <td>
                                                        {{-- @if($client->count < $subscription->subscription_plan->max_clients) data-toggle="modal" data-placement="top" title="Add a new customer" data-target="#newClientModal" @else onclick="launchMaxClientNotif() @endif" --}}
                                                        <button class="btn btn-block btn-success float-right" @if(auth()->user()->role_id == 2) data-toggle="modal" data-placement="top" title="Add a new customer" data-target="#newClientModal" @else onclick="launchNoAccess()" @endif type="button">
                                                            追加
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-auto">
                                        <h3 class="text-bold">顧客一覧</h3>
                                        <h3 class="text-bold">閲覧する顧客名を選びクイックして下さい。</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12 col-md-12  table-responsive">
                                        <table class="table mt-2 table-hover table-striped text-center table-bordered">
                                            <thead class="thead bg-info">
                                                <th>事業者名</th>
                                                <th>種類</th>
                                                <th>決算月</th>
                                                <th>新規投稿</th>
                                                <th>確認待ち</th>
                                            </thead>
                                            <tbody>
                                                @if($clients)
                                                    @foreach($clients as $client)
                                                        <tr>
                                                            <td><a href="view-individual-clients/client_id={{$hashids->encode($client->id)}}/dashboard">{{$client->name}}</a></td>
                                                            <td>@if($client->business_type_id == 1) 個人 @else 法人 @endif</td>
                                                            <td>{{date("F", mktime(0, 0, 0, $client->tax_filing_month, 10)) }}</td>
                                                            <td></td>
                                                            <td>@if($client->verified_at == '') <a href="#" class="btn btn-danger btn-block"><i class="fas fa-circle"></i></a>@endif</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">現在、あなたの会社に登録されているクライアントはありません。 上の新しいクライアントボタンをクリックして登録してください。</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="newClientModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新しいクライアントを登録する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="newClientForm">
                        @csrf
                        <div class="row">
                            <div class="pull-left col-4">
                                <h3 class="modal-title">顧客の情報</h3>
                            </div>
                            <div class="col-8">
                                <input type="submit" value="新規登録" class="btn btn-primary btn-block">
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table-bordered table">
                                <tbody>
                                    <tr>
                                        <th colspan="2"><label for="business_name">社名</label></th>
                                        <td>
                                            <div class="form-row">
                                                <div class="col-8">
                                                    <input type="text" name="business_name" id="business_name" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="radio" name="business_type" id="business_type" value="1" class="mx-auto my-auto">法人
                                                    <input type="radio" name="business_type" id="business_type" value="2" class="mx-auto my-auto">個人
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="business_address">本店所在地</label></th>
                                        <td>
                                            <input type="text" name="business_address" id="business_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="business_telephone">電話番号</label></th>
                                        <td>
                                            <input type="text" name="business_telephone" id="business_telephone" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="representative_name">代表者</label></th>
                                        <td>
                                            <input type="text" name="representative_name" id="representative_name" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="representative_address">代表者住所</label></th>
                                        <td>
                                            <input type="text" name="representative_address" id="representative_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="final_accounts_month">決算月</label></th>
                                        <td>
                                            <select name="final_accounts_month" id="final_accounts_month" class="col-auto form-control">
                                                <option value="1">1月</option>
                                                <option value="2">2月</option>
                                                <option value="3">3月</option>
                                                <option value="4">4月</option>
                                                <option value="5">5月</option>
                                                <option value="6">6月</option>
                                                <option value="7">7月</option>
                                                <option value="8">8月</option>
                                                <option value="9">9月</option>
                                                <option value="10">10月</option>
                                                <option value="11">11月</option>
                                                <option value="12">12月</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="contact_email_address">ワンタイムパスワードの </label></th>
                                        <th><label for="">送付先メールアドレス</label></th>
                                        <td>
                                            <input type="email" name="contact_email_address" id="contact_email_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        $("#newClientForm").on('submit', function(event) {
            event.preventDefault()

            var type_id = document.querySelector('input[name="business_type"]:checked').value;
            var url = "{{route('register-new-client')}}";

            axios.post(url, {
                name: $('#business_name').val(),
                business_type_id: type_id,
                address: $('#business_address').val(),
                telephone: $('#business_telephone').val(),
                representative: $('#representative_name').val(),
                tax_filing_month: $('#final_accounts_month').val(),
                email: $('#contact_email_address').val()
            }).then(function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'クライアント登録が成功しました',
                }).then((result) => {
                    if(result.isConfirmed) {
                        $('#business_name').val('')
                        $('#business_address').val('')
                        $('#business_telephone').val('')
                        $('#representative_name').val('')
                        $('#contact_email_address').val('')
                        $('#newClientModal').modal('hide')
                    }
                })
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Check your inputs and try again.',
                })
            })
        })


        function launchNoAccess() {
            Swal.fire({
                icon: 'info',
                title: 'アクセスできません',
                text: '新しいクライアントを追加するには、管理者権限が必要です。'
            })
        }
    </script>
@endsection