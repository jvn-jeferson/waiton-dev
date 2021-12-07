<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Waiton Registration Successful</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

    <div class="container-fluid">
        <div class="row justify-content-center mx-auto my-5">
            <div class="col-md-9 col-sm-12 col-lg-6 col-xs-12">
                <div class="card">
                    <div class="card-body text-center mx-auto">
                        <h1 class="text-success">
                            Registration Successful
                        </h1>

                        <p class="text-strong">Welcome to Waiton </p>{{$data['name']}}

                        <p>We are thrilled to have you in our community. Please take a moment to review our <a href="#">Terms and Conditions</a> before your proceed.</p>
                        <p>Your 90% done in setting an account for your company, <strong class="text-primary">{{$data['company']}}</strong>. All you need to do now is to update your password so you can access your dashboard.</p>
                        <p>Please click on this to update your password.</p>

                        <p>Your unique ID is: <strong class="text-primary">{{$data['login_id']}}</strong> .</p>
                        <p>Your temporary password is: <strong class="text-primary">{{$data['pw']}}</strong> .</p>
                        {!! $data['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
