<div id="markerFormBlock" hidden="true">
    <div class="panel panel-default" id="markerListItemMarkerId">
        <div class="panel-heading" role="tab" id="headingOneMarkerId">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#markerCollapseMarkerId" aria-expanded="true" aria-controls="markerCollapseMarkerId" id="markerHeaderMarkerId">
              Marker Name
            </a>
          </h4>
        </div>
        <div id="markerCollapseMarkerId" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneMarkerId">
          <div class="panel-body">
                {{ Form::open(array('url' => 'quests/post')) }}
                    <div class="form-group">
                        {!! Form::label('Locatie Naam') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'id' => 'markerNameInputMarkerId',
                                        'placeholder'=>'Locatie Naam',
                                        'onkeyup'=>'updateText(this)')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Locatie Informatie') !!}
                        {!! Form::textarea('info', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Locatie Informatie',
                                  'id'=>'markerInfoMarkerId')) !!}
                    </div>

                    <div class="form-check" style="display:inline">
                        {!! Form::checkbox('isQr', null, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheckMarkerId', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                        {!! Form::label('QR Marker') !!}
                    </div>

                     <div class="qr-Padding" id="qr-codeMarkerId">
                        <!-- QR-code is generated here -->
                    </div>

                    <div class="form-check">
                        {!! Form::checkbox('isVisible', null, false,
                            array('class'=>'form-check-input', 'id'=>'visibleCheckMarkerId', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                        {!! Form::label('Altijd Zichtbaar') !!}
                        
                    </div>
                    
                    <div class="form-group">
                        {!! Form::button('Vraag Toevoegen', 
                          array('class'=>'btn btn-primary',
                                'id' => 'addQuestionBtnMarkerId',
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
                                'id' => 'removeMarkerButtonMarkerId',
                                'onclick'=>'removeMarker(this)')) !!}
                    </div>
                {{ Form::close() }}
          </div>
        </div>
    </div>
</div>