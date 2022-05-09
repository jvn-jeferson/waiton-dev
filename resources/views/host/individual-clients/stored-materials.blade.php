@extends('layouts.host-individual')

@section('extra-css')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h4 class="card-title">

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped tabled-bordered" id="storedMaterialsTable">
                                    <thead class="bg-primary text-bold">
                                        <th>年</th>
                                        <th>月と日付</th>
                                        <th>時間</th>
                                        <th>承認・保留PDF</th>
                                        <th>対象ファイル</th>
                                        <th>日付</th>
                                        <th>承認者</th>
                                    </thead>
                                    <tbody>
                                        @forelse($materials as $material)
                                            <tr>
                                                <td>{{ date_format($material->request_sent_at, 'Y年') }}</td>
                                                <td>{{ date_format($material->request_sent_at, 'm月d日') }}</td>
                                                <td>{{ date_format($material->request_sent_at, 'H:i') }}</td>
                                                <td>
                                                    <a href="#"
                                                        onclick="downloadDocumentFiles({{ $material->pdf->id }})" role="button">{{ $material->pdf->name }}</a>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        onclick="downloadDocumentFiles({{ $material->document->id }})" role="button">{{ $material->document->name }}</a>
                                                </td>
                                                <td>
                                                    @switch($material->is_approved)
                                                        @case(0)
                                                        @case(1)
                                                            <span class="text-gray"><i class="fa fas fa-circle"></i> 承認不要データ
                                                                •</span>
                                                        @break

                                                        @case(2)
                                                            <span class="text-success"><i class="fa fas fa-check"></i> 承認済み
                                                                •</span>
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
                                                <td>{{ $material->viewer->name ?? ''}}</td>
                                            </tr>
                                            @empty
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
             function downloadDocumentFiles(id) {
                    var url = "{{ route('download-document-files') }}"

                    axios.post(url, {
                        file_id: id
                    }).then(function(response) {
                        const link = document.createElement('a')
                        link.href = response.data[0]
                        link.download = response.data[1];
                        link.click();
                    }).catch(function(error) {
                        console.log(error.response);
                    })
                }
            $(document).ready(function() {
                $('#storedMaterialsTable').DataTable();
            });
        </script>
    @endsection
