@extends('layouts.client')

@section('content')
    <div class="content-wrapper">

        <!-- Main Content -->
        <section class="content">

            <!-- Reminders/Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        リマインダー
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-hover-primary" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-bars"></i>
                        </button>
                      </div>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1">2021年10月10日</h5>
                              <small>3 days ago</small>
                            </div>
                            <p class="mb-1">法人税、地方税、消費税の納付</p>
                            <small></small>
                        </li>
                        <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1">2021年10月10日</h5>
                              <small>3 days ago</small>
                            </div>
                            <p class="mb-1">Payment of corporate tax, local tax and consumption tax</p>
                            <small></small>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Reminders Information Card -->

            <!-- Reports Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        ファイルレコード
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-group">
                        <!-- To Accounting Office -->
                        <div class="card mr-1 card-success card-outline">
                            <div class="card-header">
                            <h3 class="card-title text-primary">アップロード済み</h3>
                            </div>
                            <div class="card-body">
                            <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
                                <thead class="thead bg-primary">
                                <th>DATE</th>
                                <th>FILE NAME</th>
                                <th>STATUS</th>
                                <th>VIEWING DEADLINE</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample.pdf</td>
                                    <td>Uploaded</td>
                                    <td>June 30, 2021</td>
                                </tr>
                                <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample2.pdf</td>
                                    <td>Uploaded</td>
                                    <td>June 30, 2021</td>
                                </tr>
                                <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample3.pdf</td>
                                    <td>Uploaded</td>
                                    <td>June 30, 2021</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
    
                        <!-- From Accounting Office -->
                        <div class="card ml-1 card-danger card-outline">
                            <div class="card-header">
                            <h3 class="card-title text-primary">受け取った</h3>
                            </div>
                            <div class="card-body">
                            <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
                                <thead class="thead bg-primary">
                                <th>DATE</th>
                                <th>FILE NAME</th>
                                <th>Remarks</th>
                                <th>VIEWING DEADLINE</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample.pdf</td>
                                    <td>Awaiting Confirmation</td>
                                    <td>June 30, 2021</td>
                                </tr>
                                {{-- <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample2.pdf</td>
                                    <td></td>
                                    <td>June 30, 2021</td>
                                </tr> --}}
                                <tr>
                                    <td>May 31, 2021</td>
                                    <td class="text-info">sample3.pdf</td>
                                    <td>No Confirmation Request</td>
                                    <td>June 30, 2021</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Reports Section -->
            <div class="card collapsed-card">
                <div class="card-header">
                  <h3 class="card-title">ファイルストレージ</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-bars"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
                    <thead class="thead bg-dark">
                      <th>DATE</th>
                      <th>FILE NAME</th>
                      <th>Storage</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>May 31, 2021</td>
                        <td class="text-info">sample.pdf</td>
                        <td>Saved</td>
                      </tr>
                      <tr>
                        <td>May 31, 2021</td>
                        <td class="text-info">sample2.pdf</td>
                        <td>Saved</td>
                      </tr>
                      <tr>
                        <td>May 31, 2021</td>
                        <td class="text-info">sample3.pdf</td>
                        <td>Saved</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>

        </section>
    </div>
@endsection

@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>
@endsection


