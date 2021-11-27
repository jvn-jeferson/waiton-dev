@extends('layouts.client')

@section('content')
    <div class="content-wrapper">

        <!-- Main Content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-outline">
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
                              {{date_format($message->created_at, 'F j, Y')}}
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
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      To会計事務所
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                          <tr>
                            <th>郵送日</th>
                            <th>ファイル名</th>
                            <th>状態</th>
                            <th>閲覧期限</th>
                          </tr>
                        </thead>
                        <tbody>
                          {{-- forelse here --}}
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
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>
@endsection


