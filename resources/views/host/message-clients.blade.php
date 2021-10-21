@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Send Message to Every Client
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form">
                                    <div class="form-group">
                                        <label for="message_date">Notification Date</label>
                                        <input type="date" name="message_date" id="message_date" class="form-control col-12 col-sm-6 col-md-3">
                                    </div>
                                    <div class="form-group">
                                        <label for="message_subject">Subject</label>
                                        <input type="text" name="message_subject" id="message_subject" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="message_details">Details</label>
                                        <textarea type="text" name="message_details" id="message_details" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="message_attachment">Attach a File</label>
                                        <input type="file" name="message_attachment" id="message_attachment">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info float-right" type="submit" name="message_send"><i class="fas fa-paper-plane"></i> Send Message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-success card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Post Records</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead bg-info">
                                            <th>Select</th>
                                            <th>Date Posted</th>
                                            <th>Post Schedule</th>
                                            <th>Subject</th>
                                            <th>Details</th>
                                            <th>Posted Material</th>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($records as $record) --}}
                                                <tr>
                                                    <td><input type="checkbox" name="" id=""></td>
                                                    <td>2021/06/15</td>
                                                    <td></td>
                                                    <td>Notice</td>
                                                    <td>We would like to express our deepest sympathies during the heat.
                                                        Let's do our best without being overwhelmed by Corona.
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            {{-- @endforeach --}}
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
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@endsection