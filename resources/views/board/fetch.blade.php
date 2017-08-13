<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EGYTRONICA</title>

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <link rel="icon" type="image/x-icon" href="res/img/icon1.ico" >
    <link rel="icon" type="image/png" href="res/img/icon.png" sizes="16x16">

    <!-- Bootstrap Core -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous" />
    <link href="res/style.css" rel="stylesheet">

    <title>Board Components</title>

</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a class="navbar-brand">
                      <img class="logo img-fluid" src="res/img/logo.png">
                    </a>
                </div>
                <button class="navbar-toggler hidden-md-up pull-right" type="button" data-toggle="collapse" data-target="#CollapsingNavbar" aria-controls="CollapsingNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    &#9776;
                </button>
                <div id="CollapsingNavbar" class="collapse navbar-toggleable-sm">
                    <div class="col-md-8 col-sm-10 push-lg-2">
                        <p style="padding:20px;" class="hidden-md-up"></p>
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a href="{{ url('/#home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="{{ url('/#about') }}" class="nav-link">About Us</a></li>
                            <li class="nav-item"><a href="{{ url('/#services') }}" class="nav-link">Services</a></li>
                            <li class="nav-item"><a href="{{ url('/#news') }}" class="nav-link">News & Updates</a></li>
                            <li class="nav-item"><a href="{{ url('/#contact') }}" class="nav-link">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
        <div class="container" style="padding: 80px;">
          @isset($message)

          <div class="alert alert-danger" role="alert">{{ $message }}</div>

          @endisset
          <div class="row">
            <div class="col-sm-12 col-md-12">
                {!! Form::open(array('route' => 'board_fetch', 'class' => 'form')) !!}
                <div class="form-group row col-xs-12">
                  {!! Form::label('Email address') !!}
                  {!! Form::email('email', null,
                  array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Email')) !!}
                </div>

                <div class="form-group row col-xs-12">
                  {!! Form::label('Mobile') !!}
                  {!! Form::tel('mob', null,
                  array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Eg.: +20XXXXXXXXXX')) !!}
                </div>

                <div class="form-group row col-xs-12">
                  {!! Form::label('Board Name') !!}
                  {!! Form::text('board', null,
                  array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Board name')) !!}
                </div>

                <div class="form-group">
                  {!! Form::submit('Login',
                  array('class'=>'btn btn-default')) !!}
                </div>
                {!! Form::close() !!}
          </div>
        </div>
      </div>
   </body>

        <!-- FOOTER -->
    <div id = "index.html #contact" class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col text-xs-center col-sm-6">
                    <h2>Reach Us</h2>
                    <ul class="list-inline">
                        <li class="list-item">
                            <a class="btn-social btn-outline-primary" href="https://www.facebook.com/Egytronica-350229955370740/?fref=nf">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-item">
                            <a class="btn-social btn-outline-info" href="https://twitter.com/egy_tronica">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-item">
                            <a class="btn-social btn-outline-danger" href="https://plus.google.com/u/0/100339744739134276629">
                                <i class="fa fa-fw fa-google"></i>
                            </a>
                        </li>
                        <li class="list-item">
                            <a class="btn-social btn-outline-warning" href="https://www.instagram.com/egytronica/?hl=en">
                                <i class="fa fa-fw fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                    <p><a class="contact-btn btn btn-outline-info" data-toggle="modal" data-target="#contactModal">
                                Contact Us
                            </a></p>

                    <div id="contactModal" class="modal fade" role="dialog">
                        <div class="modal-dialog" role="document">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Contact Us</h4>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(array('route' => 'contactus_store', 'class' => 'form')) !!}
                                    <div class="form-group row col-xs-12">
                                      {!! Form::text('name', null,
                                      array('required',
                                      'class'=>'form-control',
                                      'placeholder'=>'Name')) !!}
                                    </div>

                                    <div class="form-group row col-xs-12">
                                      {!! Form::email('email', null,
                                      array('required',
                                      'class'=>'form-control',
                                      'placeholder'=>'Email Address')) !!}
                                    </div>

                                    <div class="form-group row col-xs-12">
                                      {!! Form::tel('phone', null,
                                      array('required',
                                      'class'=>'form-control',
                                      'placeholder'=>'Phone')) !!}
                                    </div>

                                    <div class="form-group row col-xs-12">
                                      {!! Form::text('message', null,
                                      array('required',
                                      'class'=>'form-control',
                                      'placeholder'=>'Message')) !!}
                                    </div>

                                    <div class="form-group">
                                      {!! Form::submit('Submit',
                                      array('class'=>'btn btn-info btn-lg bton')) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-col text-xs-center col-sm-6">
                    <h2>Find Us</h2>
                    <iframe frameborder="0" style="border-radius:8px;border:0," src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7287.15350890535!2d32.880997!3d24.045986!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4d4f00924f8bbeda!2z2KfZhNin2YPYp9iv2YrZhdmK2Kkg2KfZhNi52LHYqNmK2Kkg2YTZhNi52YTZiNmFINmI2KfZhNiq2YPZhtmI2YTZiNis2YrYpyDZiNin2YTZhtmC2YQg2KfZhNio2K3YsdmJ!5e0!3m2!1sar!2s!4v1488840831644" allowfullscreen width="350"></iframe>


                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <!-- Credits Start -->
    <div class="credits-div text-xs-center">
        <p>Copyrights © EGYTRONICA- All Rights Reserved.</p>
    </div>

    <!-- Jquery,Bootstrap and Tether  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script>
      $('.carousel').carousel()
    </script>
</body>

</html>
