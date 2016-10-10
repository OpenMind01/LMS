@inject('courseUsers', 'Pi\Clients\Courses\Repositories\CourseUserRepository')
@inject('userProgress', 'Pi\Clients\Courses\Services\UserProgressService')
@inject('quizScoring', 'Pi\Clients\Courses\Quizzes\Scoring\QuizScoringService')

@extends('layouts.default')

@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="#">Courses</a></li>
    <li><a href="{{ route('clients.courses.show', [$client->slug, $course->slug]) }}">{{ $course->name }}</a></li>
    <li><a href="{{ route('clients.courses.modules.show', [$client->slug, $course->slug, $module->slug]) }}">{{ $module->name }}</a></li>
    <li><a href="{{ route('clients.courses.modules.articles.show', [
    $client->slug,
    $course->slug,
    $module->slug,
    $article->number]) }}">
            {{ $article->name }}</a></li>
    <li class="active">View Quiz Results</li>
@stop

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $user->full_name }}'s Quiz Results for {{ $quiz->article->name }}</h3>
        </div>
        <div class="panel-body">
            <h3>Quiz Score: {{ $quizScoring->getLastAttemptForQuiz($quiz, $user)->score }}%</h3>
            <hr>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Label</th>
                    <th>Options</th>
                    <th>{{ $user->name }} Answerd</th>
                    <th>Correct</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quiz->responses as $response)
                    <tr>
                        <td>{!! str_limit($response->quizElement->label, 50) !!}</td>
                        <td>
                            @foreach($response->quizElement->options as $option)
                                <div>{{ $option->value }}. {{ $option->label }}</div>
                            @endforeach
                        </td>
                        <td>
                            @if($response->is_array)
                                {{ implode(' & ', json_decode($response->value, true)) }}
                            @else
                                {{ $response->value }}
                            @endif
                        </td>
                        <td>
                            @if($response->is_correct)
                                <i class="fa fa-check fa-2x" style="color: green"></i>
                            @else
                                <i class="fa fa-ban fa-2x" style="color: red"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('inline-scripts')
    <script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            $(".delete-user-progress-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete the progress for this user? All user progress will be lost and cannot be recovered.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            })
            $(".user-checkbox").change(function(e) {
                var $chkbox = $(this);
                var userId = $chkbox.data('userId');
                var url;
                var type;
                if (!$chkbox.is(":checked")) {
                    url = '{{ url('api/courses/'.$course->id.'/users') }}/'+userId;
                    $.ajax({
                        url: url,
                        type: 'delete',
                        success: function(response) {
                            if (!response.success) {
                                bootbox.alert(response.message);
                            }
                        }
                    })
                }else {
                    url = '{{ url('api/courses/'.$course->id.'/users') }}';
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            user_id: userId
                        },
                        success: function(response) {
                            if (!response.success) {
                                bootbox.alert(response.message);
                            }
                        }
                    })
                }
            });
        })(jQuery);
    </script>

@stop