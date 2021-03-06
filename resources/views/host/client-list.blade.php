@extends('layouts.host')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto col-md-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">登録顧客の一覧</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped text-center">
                                    <thead class="thead bg-info">
                                        <tr>
                                            <th>選択 <br> <input type="checkbox" name="all" id="all" value="0"> </th>
                                            <th>事業者名</th>
                                            <th>種類</th>
                                            <th>決算月</th>
                                            <th>国税識別番号 <br> ID/PW</th>
                                            <th>EL-Tax <br> ID/PW</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($clients as $client)
                                        <tr>
                                            <td rowspan="2"><input type="checkbox" name="select" id="select" value="{{ $client->id }}"></td>
                                            <td rowspan="2">{{$client->name }}</td>
                                            <td rowspan="2">@if($client->business_type_id == 1) 法人 @else 個人 @endif</td>
                                            <td rowspan="2">{{$client->tax_filing_month}}月</td>
                                            <td>
                                                @if($client->credentials)
                                                    {{$client->credentials->nta_id}}
                                                @else
                                                無し
                                                @endif
                                            </td>
                                            <td>
                                                @if($client->credentials)
                                                    {{$client->credentials->nta_password}}
                                                @else
                                                無し
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($client->credentials)
                                                    {{$client->credentials->el_tax_id}}
                                                    @else
                                                    無し
                                                @endif
                                            </td>
                                            <td>
                                                @if($client->credentials)
                                                    {{$client->credentials->el_tax_password}}
                                                    @else
                                                    無し
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">表示するレコードはありません。</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-warning float-left text-light" id="downloadBtn">選択データのダウンロード</button>
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
    var select_all = document.querySelector('#all')
    var selects = document.getElementsByName('select')

    select_all.addEventListener('change', function() {
        if (select_all.checked) {
            $.each(selects, function(index, value) {
                selects[index].checked = true
            })
        } else {
            $.each(selects, function(index, value) {
                selects[index].checked = false
            })
        }
    })

    var download = document.querySelector('#downloadBtn')

    download.addEventListener('click', function() {

        var client_id = $('input#select:checked').map(function() {
            return this.value
        }).get()
        var url = "{{route('download-client')}}";

        axios.post(url, {
            client_id: client_id
        }).then(function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Congrats'
            })

            function download_files(files) {
                function download_next(i) {
                    if (i >= files.length) {
                        return;
                    }
                    var a = document.createElement('a');
                    console.log(files[i].file_url);
                    a.href = files[i].file_url;
                    a.target = '_blank';

                    if ('download' in a) {
                        a.download = files[i].file_name;
                    }

                    (document.body || document.documentElement).appendChild(a);
                    if (a.click) {
                        a.click(); // The click method is supported by most browsers.
                    } else {
                        window.open(files[i].file_url);
                    }
                    a.parentNode.removeChild(a);
                    setTimeout(function() {
                        download_next(i + 1);
                    }, 500);
                }
                // Initiate the first download.
                download_next(0);
            }

            function do_dl() {
            var data = response.data;
                download_files(data);
            };
            do_dl();
        }).catch(function(error) {
            console.log(error.response.data);
        })



        //loop through each checked value
        //for each key:value create a zip file
        //initiate download process
    })
</script>
@endsection
