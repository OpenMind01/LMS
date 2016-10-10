@inject('courseUsers', 'Pi\Clients\Courses\Repositories\CourseUserRepository')
@inject('userProgress', 'Pi\Clients\Courses\Services\UserProgressService')
@inject('quizScoring', 'Pi\Clients\Courses\Quizzes\Scoring\QuizScoringService')

@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $user->full_name }}'s progress for {{ $course->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Completion %</th>
                    <th>Quizzes</th>
                    <th>Actions</th>
                    <th class="col-sm-3">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($course->modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>{{ $userProgress->getModuleCompletionPercentageForUser($module, $user) }}%</td>
                        <td>&nbsp;</td>
                    </tr>
                    @foreach($module->articles as $article)
                        <tr>
                            <td style="padding-left: 50px;">{{ $article->number }} - {{ $article->name }}</td>
                            <td>{{ $userProgress->getArticleCompletionPercentageForUser($article, $user) }}%</td>
                            <td>
                                @if($article->doQuiz)
                                    @if($attempt = $quizScoring->getLastAttemptForQuiz($article->answerQuiz, $user))
                                        Do Quiz: {{ $attempt->score }}%
                                        @else
                                        Do Quiz: Not Attempted
                                    @endif
                                @endif

                                @if($article->answerQuiz)
                                    <div class="quiz-links">
                                        @if($attempt = $quizScoring->getLastAttemptForQuiz($article->answerQuiz, $user))
                                            Answer Quiz: {{ $attempt->score }}% (<a style="color: blue" href="{{ route('clients.manage.courses.users.quiz.show', [$client->slug, $course->slug, $user->id, $article->answerQuiz->id]) }}">View Results</a>)
                                        @else
                                            Answer Quiz: Not Attempted
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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