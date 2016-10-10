@inject('elementRendering', 'Pi\Clients\Courses\Quizzes\ElementTypes\Rendering\QuizElementService')
@extends('layouts.default')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Quiz</h3>
        </div>
        <div class="panel-body body-editable" data-id="body">
          {!! Form::open(['class' => 'form']) !!}
            <div class="quiz">
                {{-- */ $number = 1; /* --}}
                @foreach($quiz->elements as $element)
                    @if($element->is_question)
                        <div class="question-title" style="font-weight: bold;">Question #{{ $number }}</div>
                        {{-- */ $number++; /* --}}
                    @endif
                    {!! $elementRendering->render($element) !!}
                    <hr>
                @endforeach
            </div>
            <div class="form-actions">
                {!! Form::submit('Submit Answers', ['class' => 'btn btn-info']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop