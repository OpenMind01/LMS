<h5>Do</h5>
@if($article->doQuiz)
    <a href="{{ route('clients.manage.courses.modules.articles.quizzes.edit', [
        'clientSlug' => $client->slug,
        'courseSlug' => $course->slug,
        'moduleSlug' => $module->slug,
        'articleId' => $article->id,
        'quizId' => $article->doQuiz->id,
    ]) }}" class="btn btn-info">Edit Do Quiz</a>
@else
    <a href="{{ route('clients.manage.courses.modules.articles.quizzes.create', [
        'clientSlug' => $client->slug,
        'courseSlug' => $course->slug,
        'moduleSlug' => $module->slug,
        'articleId' => $article->id,
        'quizType' => Pi\Clients\Courses\Quizzes\Quiz::TYPE_DO,
    ]) }}" class="btn btn-info">Create Do Quiz</a>
@endif

<h5>Answer</h5>
@if($article->answerQuiz)
    <a href="{{ route('clients.manage.courses.modules.articles.quizzes.edit', [
        'clientSlug' => $client->slug,
        'courseSlug' => $course->slug,
        'moduleSlug' => $module->slug,
        'articleId' => $article->id,
        'quizId' => $article->answerQuiz->id,
    ]) }}" class="btn btn-info">Edit Answer Quiz</a>
@else
    <a href="{{ route('clients.manage.courses.modules.articles.quizzes.create', [
        'clientSlug' => $client->slug,
        'courseSlug' => $course->slug,
        'moduleSlug' => $module->slug,
        'articleId' => $article->id,
        'quizType' => Pi\Clients\Courses\Quizzes\Quiz::TYPE_ANSWER,
    ]) }}" class="btn btn-info">Create Answer Quiz</a>
@endif