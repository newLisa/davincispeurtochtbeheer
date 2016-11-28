@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Add Quest</h2>
                    {{ Form::open(array('url' => 'quests/post')) }}
                        <div class="form-group">
                        {!! Form::label('Quest Name') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Quest name')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Course') !!}
                            <br>
                            {!! Form::select('course', array('Ict' => 'Ict', 'Kapper' => 'Kapper'), array('class'=>'form-control')); !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Information') !!}
                            {!! Form::textarea('info', null, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Quest Information')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Quest', 
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
