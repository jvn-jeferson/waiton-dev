@extends('layouts.client')

@section('extra-css')
    <style>
        .file-upload {
        background-color: #ffffff;
        margin: 0 0;
        padding: 20px;
        }

        .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
        }

        .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
        }

        .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
        }

        .file-upload-content {
        display: none;
        text-align: center;
        }

        .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
        }

        .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
        }

        .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
        }

        .drag-text {
        text-align: center;
        }

        .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
        }

        .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
        }

        .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
        }

        .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
        }

        .remove-image:active {
        border: 0;
        transition: all .2s ease;
        }

        textarea {
            margin: 0;
            padding: 0;
            border: 0;
            width: 100%;
            height: 100%;
            vertical-align:top;
        }
    </style>
@endsection

@section('content')
    <!-- Main Wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <section class="content">
            <!-- Upload Files -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-success">
                        経理部にデータを送信（閲覧期限1ヶ月)
                    </h3>
                    
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        次のファイルを経理部にアップロードします。アップロード資料にファイルをドロップするか、アップロードボタンからファイルを選択します。
                    </p>
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="thead bg-dark">
                            <th>アップロードされた資料</th>
                            <th>備考</th>
                        </thead>
                        <tbody>
                            <tr class="align-items-center">
                                <td class="file-upload">
                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h3>ファイルをドラッグアンドドロップするか、この領域をクリックします。</h3>
                                        </div>
                                        </div>
                                        <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                        </div>
                                        </div>
                                </td>
                                <td class="align-items-center">
                                    <textarea name="textarea1" id="textarea1" rows="7"class="form-control" placeholder="Put your comments here."></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="float-right btn btn-success" type="submit">アップロード</button>
                </div>
            </div>
            <!-- /upload files -->

            <!-- Upload List -->
            <div class="card card-warning card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-dark">
                        アップロードされたファイル
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 4px">
                        <button class="float-left btn btn-primary" type="button">Delete Selected File</button>
                    </div>
                    <br>
                    <div class="mt-2">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark text-center">
                                <th>撰ぶ</th>
                                <th>投稿日</th>
                                <th>締め切りの表示</th>
                                <th>寄稿者</th>
                                <th>ファイル名</th>
                                <th>備考</th>
                            </thead>
                            <tbody class="text-center">
                                {{-- foreach $file in $files --}}
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>2021年4月10日21:40</td>
                                    <td>2021年5月10日21:40</td>
                                    <td>Ichikawa-san</td>
                                    <td class="text-info">sample.pdf</td>
                                    <td>ありがとうございました</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /upload list -->
        </section>
        <!-- End Content -->
    </div>
    <!-- end Main Wrapper -->
@endsection

@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

<script>
    function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
        $('.image-upload-wrap').hide();

        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();

        $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
    }

    function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
    });
</script>
@endsection