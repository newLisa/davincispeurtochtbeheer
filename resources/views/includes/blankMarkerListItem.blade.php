<div id="markerFormBlock" hidden="true">
    <div class="panel panel-default" id="markerListItem">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#replaceThis" aria-expanded="true" aria-controls="replaceThis" id="markerHeader">
              Marker Name
            </a>
          </h4>
        </div>
        <div id="replaceThis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
                {{ Form::open(array('url' => 'quests/post')) }}
                    <div class="form-group">
                        {!! Form::label('Locatie Naam') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'id' => 'markerNameInput',
                                        'placeholder'=>'Locatie Naam',
                                        'onkeyup'=>'updateText(this)')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Locatie Informatie') !!}
                        {!! Form::textarea('info', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Locatie Informatie',
                                  'id'=>'markerInfo')) !!}
                    </div>

                    <div class="form-check">
                        {!! Form::checkbox('isQr', null, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                        {!! Form::label('QR Marker') !!}
                    </div>

                    <div class="form-check">
                        {!! Form::checkbox('isVisible', null, false,
                            array('class'=>'form-check-input', 'id'=>'visibleCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                        {!! Form::label('Altijd Zichtbaar') !!}
                        
                    </div>

                    <div class="form-group">
                        {!! Form::button('Vraag Toevoegen', 
                          array('class'=>'btn btn-primary',
                                'id' => 'addQuestionBtn',
                                'onclick'=>'showQuestionModel(markerId)')) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Latitude') !!}
                        {!! Form::number('lat', null, 
                                        array('required', 
                                        'class'=>'form-control LatitudeId', 
                                        'readonly' => 'true',
                                        'placeholder'=>'Latitude')) !!}

                        {!! Form::label('Longitude') !!}
                        {!! Form::number('lng', null, 
                                        array('required', 
                                        'class'=>'form-control LongitudeId',
                                        'readonly' => 'true',  
                                        'placeholder'=>'Longitude')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::button('Verwijder Locatie', 
                          array('class'=>'btn btn-danger',
                                'id' => 'removeMarkerButton',
                                'onclick'=>'removeMarker(this)')) !!}
                    </div>
                {{ Form::close() }}
          </div>
        </div>
    </div>
</div>