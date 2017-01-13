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
                       <div class="btn-group btn-group-vertical" data-toggle="buttons">
                        <label class="btn active">
                            {!! Form::radio('isCorrect', 1, true,
                                array('class'=>'form-check-input', 'type'=>'radio', 'id'=>'correct', 'onClick' => 'updateMarkerImage(markerId)')) 
                            !!}
                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Correct Antwoord</span>
                        </label>
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #2') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #2')) !!}
                        <div class="btn-group btn-group-vertical" data-toggle="buttons">
                        <label class="btn active">
                            {!! Form::radio('isCorrect', 0, false,
                                array('class'=>'form-check-input', 'type'=>'radio', 'id'=>'correct', 'onClick' => 'updateMarkerImage(markerId)')) 
                            !!}
                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Correct Antwoord</span>
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #3') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #3')) !!}
                        <div class="btn-group btn-group-vertical" data-toggle="buttons">
                        <label class="btn active">
                            {!! Form::radio('isCorrect', 0, false,
                                array('class'=>'form-check-input', 'type'=>'radio', 'id'=>'correct', 'onClick' => 'updateMarkerImage(markerId)')) 
                            !!}
                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Correct Antwoord</span>
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Antwoord #4') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Antwoord #4')) !!}
                        <div class="btn-group btn-group-vertical" data-toggle="buttons">
                        <label class="btn active">
                            {!! Form::radio('isCorrect', 0, false,
                                array('class'=>'form-check-input', 'type'=>'radio', 'id'=>'correct', 'onClick' => 'updateMarkerImage(markerId)')) 
                            !!}
                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span>Correct Antwoord</span>
                        </label>
                        </div>
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