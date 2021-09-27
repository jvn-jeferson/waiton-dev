@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-lg-12 p-2">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">購入を確認します</h1>
                <p class="lead">お支払い情報を入力して購入を確認します。 お支払いが完了すると、登録ページにリダイレクトされます。</p>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-8 p-3">
                    <form>
                        <h4 class="mx-auto text-justify">課金情報</h4>
                        <div class="form-group">
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="カード所有者の名前">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="請求先住所">
                        </div>
                        <h4 class="mx-auto text-justify">カードの詳細</h4>
                        <div class="form-row form-group">
                            <input type="text" class="form-control col-md-6 mx-auto" placeholder="カード番号">
                            <input type="text" class="form-control col-md-3 mx-auto" placeholder="有効期限">
                            <input type="text" class="form-control col-md-3 mx-auto" placeholder="CVV">
                        </div>
                            <button type="submit" class="btn btn-success btn-block" value="Confirm Payment">Confrim Payment</button>
                    </form>
                </div>
                <div class="col-md-4 p-3">
                    <h3 class="mx-auto text-justify">あなたは<strong class="text-info">基本</strong>のプランを選択しました。</h3>
                    <p class="lead">年間10ドル/月の請求。 合計金額：$ 120</p>
                    <p class="lead">これには、次の機能が含まれます:</p>
                    <ul>
                        <li>最大5クライアント。</li>
                        <li>24時間年中無休のメールサポート</li>
                        <li> 100GBの月間ストレージ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection