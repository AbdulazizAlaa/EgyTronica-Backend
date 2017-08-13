<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Events Form</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

  </head>
  <body>

    <div class="container">

      <div class="row page-header">
        <h1>Egytronica <small>Form</small></h1>
      </div>

      <div class="row panel panel-default">

        <div class="panel-heading">
          <h2 class="panel-title">Add Events <small>Form</small></h2>
        </div>

        <div class="panel-body">
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>


              @isset($message)

              <div class="alert alert-success" role="alert">{{ $message }}</div>

              @endisset


              {!! Form::open(array('route' => 'events_store', 'class' => 'form')) !!}
              <div class="form-group">
                {!! Form::label('Title') !!}
                {!! Form::text('title', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Title')) !!}
              </div>

              <div class="form-group">
                {!! Form::label('Address') !!}
                {!! Form::text('address', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Address')) !!}
              </div>

              <div class="form-group">
                {!! Form::label('Latitude') !!}
                {!! Form::text('lat', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Latitude')) !!}
              </div>
              <div class="form-group">
                {!! Form::label('Longitude') !!}
                {!! Form::text('lng', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Longitude')) !!}
              </div>

              <div class="form-group" style="position: relative">
                {!! Form::label('Time and Date') !!}
                {!! Form::text('date', null,
                array('required',
                'class'=>'form-control',
                'id'=>'timedate',
                'placeholder'=>'Time and Date')) !!}
              </div>

              <script>
                  $('#timedate').datetimepicker({
                      format: 'DD/MM/YYYY HH:mm:ss'
                  });
              </script>


              <div class="form-group">
                {!! Form::submit('Add Record',
                array('class'=>'btn btn-primary btn-lg btn-block')) !!}
              </div>
              {!! Form::close() !!}

        </div>

      </div>
    </div>

  </body>
</html>
