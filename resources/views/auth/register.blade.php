@extends('layouts.app')
@section('content')
<div class="container p-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">登録情報</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('registration') }}" method="post">
                    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light">事務所名</th>
                            <th>
                                <div class="form-group">
                                    <label for="name"><i class="zmdi zmdi-home material-icons-name"></i></label>
                                    <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" placeholder="事務所名"/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td class="bg-light">代表者</td>
                            <td>
                                <div class="form-group">
                                    <label for="representative"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="text" name="representative" id="representative" class="@error('representative') is-invalid @enderror" value="{{ old('representative') }}" autocomplete="representative" placeholder="代表者"/>
                                    @error('representative')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">所在地</td>
                            <td>
                                <div class="form-group">
                                    <label for="address"><i class="zmdi zmdi-pin-drop material-icons-name"></i></label>
                                    <input type="text" name="address" id="address" class="@error('address') is-invalid @enderror" value="{{ old('address')}}" autocomplete="address" placeholder="所在地">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">電話番号</td>
                            <td>
                                <div class="form-group">
                                    <label for="telephone"><i class="zmdi zmdi-phone material-icons-name"></i></label>
                                    <input type="text" name="telephone" id="telephone" class="@error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" autocomplete="telephone" placeholder="電話番号">
                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">メールアドレス</td>
                            <td>
                                <div class="form-group">
                                    <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                    <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" placeholder="メールアドレス">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justify-content-center"><input type="submit" value="登録" class="btn btn-warning btn-flat"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



