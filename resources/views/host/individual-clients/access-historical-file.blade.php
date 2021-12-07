@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Accessing Information for File from History</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <p><a href="#" onclick="window.open('{{route('video-creation')}}');">Create a video from here and paste the URL.</a></p>
                                    <input type="url" name="video-url" id="video-url" class="form-control" placeholder="Paste the video url here.">
                                    <video style="width: 100%; border:2px darkgreen dashed; position: relative; display:flex" class="mt-2" id="video-player" controls><source src=""></video>
                                </div>
                                <div class="col-5">
                                    <h4 class="text-bold">
                                        Please enter and upload the required information.
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table-bordered table">
                                            <tbody>
                                                <tr>
                                                    <th>Type</th>
                                                    <td class="bg-light">Confirm the declaration</td>
                                                </tr>
                                                <tr>
                                                    <th>Settlement Date</th>
                                                    <td class="bg-light">March 31, 2021
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Completed Tax Return</th>
                                                    <td class="bg-light"><input type="file" name="" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>Proposal Date</th>
                                                    <td class="bg-light">May 28, 2021</td>
                                                </tr>
                                                <tr>
                                                    <th>Recognition Date</th>
                                                    <td class="bg-light">May 30, 2021</td>
                                                </tr>
                                                <tr>
                                                    <th>Company Representative</th>
                                                    <td class="bg-light">Confirm the declaration</td>
                                                </tr>
                                                <tr>
                                                    <th>Accounting Staff</th>
                                                    <td class="bg-light">Ichiro Yamada</td>
                                                </tr>
                                                <tr>
                                                    <th>Video Contributor</th>
                                                    <td class="bg-light">Manabu Tanaka</td>
                                                </tr>
                                                <tr>
                                                    <th>Viewing Deadline</th>
                                                    <td class="bg-light">April 1, 2028</td>
                                                </tr>
                                                <tr>
                                                    <th>Remarks</th>
                                                    <td class="bg-light">It was a year with a lot of sales and a lot of taxes.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card">
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <button type="button" onclick="window.open('{{route('video-creation')}}');" class="btn btn-primary btn-block">Video Creation</button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-primary  btn-block">Preview Video</button>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-6">
                                                <button class="btn btn-success  btn-block">Register</button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-danger  btn-block">Delete</button>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="{{ asset('js/app.js')}}"></script>
    <script>
        var video_player = document.querySelector('#video-player')
        var src_input = document.querySelector('#video-url')

        $('#video-url').change(function() {
            var url = src_input.value;
            if(isValidHttpUrl(url)){
                $('source').attr('src',url)
                video_player.load()
                video_player.play()
            }
            else {
                console.log('ERROR')
            }
        })

        function isValidHttpUrl(string) {
            let url;
            
            try {
                url = new URL(string);
            } catch (_) {
                return false;  
            }

            return url.protocol === "http:" || url.protocol === "https:";
        }
    </script>
@endsection
