<!-- The Modal -->
<div id="questionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div id="modal-content" class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Locatie Naam</h3>
        <button id="closeQuestionModel" type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'quests/post')) }}
<!--                     <div class="form-group">
                        {!! Form::label('Locatie Naam') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Locatie Naam',
                                        'readonly' => 'true')) !!}
                    </div> -->
                    <div class="form-group">
                        {!! Form::label('vraag') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'De Vraag')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #1') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #1')) !!}
                        {!! Form::label('Correct antwoord') !!}
                        {!! Form::radio('isCorrect', 1, true,
                            array('class'=>'form-check-input', 'id'=>'qrCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #2') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #2')) !!}
                        {!! Form::label('Correct antwoord') !!}
                        {!! Form::radio('isCorrect', 2, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #3') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #3')) !!}
                        {!! Form::label('Correct antwoord') !!}
                        {!! Form::radio('isCorrect', 3, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #4') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #4')) !!}
                        {!! Form::label('Correct antwoord') !!}
                        {!! Form::radio('isCorrect', 4, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheck', 'onClick' => 'updateMarkerImage(markerId)')) 
                        !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('punten') !!}
                        {!! Form::number('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'punten')) !!}
                    </div>


                    <div class="modal-footer">
                        {!! Form::button('Opslaan', 
                          array('class'=>'btn btn-primary',
                          'type'=>'button',
                          'onClick' => 'closeQuestionModel()')) !!}
                    </div>
                {{ Form::close() }}
      </div>
    </div>
  </div>

</div>