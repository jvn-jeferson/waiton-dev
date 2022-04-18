@extends('layouts.client')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="text-bold card-title">
                            確認済の資料
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped tabled-bordered">
                                <thead class="bg-primary text-bold">
                                    <th></th>
                                    <th>承認・保留PDF</th>
                                    <th>対象ファイル</th>
                                    <th>日付</th>
                                    <th>承認者</th>
                                </thead>
                                <tbody>
                                    @forelse($materials as $material)
                                        <tr>
                                            <td>{{ date_format($material->request_sent_at, 'Y年m月d日H:i') }}</td>
                                            <td> <a href="#" onclick="downloadDocumentFiles({{ $material->pdf->id }})"
                                                    role="button">{{ $material->pdf->name }}</a></td>
                                            <td> <a href="#"
                                                    onclick="downloadDocumentFiles({{ $material->document->id }})"
                                                    role="button">{{ $material->document->name }}</a>
                                            </td>
                                            <td>
                                                @switch($material->is_approved)
                                                    @case(0)
                                                    @case(1)
                                                        <span class="text-gray"><i class="fa fas fa-circle"></i> 承認不要データ
                                                            •</span>
                                                    @break

                                                    @case(2)
                                                        <span class="text-success"><i class="fa fas fa-check"></i> 承認済み •</span>
                                                    @break

                                                    @case(3)
                                                        <span class="text-danger"><i class="fa fas fa-ban"></i> 保留 •</span>
                                                    @break

                                                    @default
                                                        <span class="text-gray"><i class="fa fas fa-circle"></i>承認不要データ
                                                            •</span>
                                                @endswitch
                                                {{ date_format($material->response_completed_at, 'Y年m月d日H:i') }}
                                            </td>
                                            <td>{{ $material->viewer->name }}</td>
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
    @endsection
    @section('extra-scripts')
        <script>
            function downloadDocumentFiles(id) {
                var url = "{{ route('download') }}"

                axios.post(url, {
                    id: id
                }).then(function(response) {
                    const link = document.createElement('a')
                    link.href = response.data[0]
                    link.download = response.data[1];
                    link.click();
                }).catch(function(error) {
                    console.log(error.response);
                })
            }
        </script>
    @endsection
