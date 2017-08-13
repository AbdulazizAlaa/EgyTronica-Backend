<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>News Form</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">

      <div class="row page-header">
        <h1>Egytronica <small>Form</small></h1>
      </div>

      <div class="row panel panel-default">

        <div class="panel-heading">
          <h2 class="panel-title">Add News <small>Form</small></h2>
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


              {!! Form::open(array('route' => 'news_store', 'class' => 'form')) !!}
              <div class="form-group">
                {!! Form::label('Title') !!}
                {!! Form::text('title', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Title')) !!}
              </div>

              <div class="form-group">
                {!! Form::label('Content') !!}
                {!! Form::textarea('content', null,
                array('required',
                'class'=>'form-control',
                'placeholder'=>'Content')) !!}
              </div>

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
