<?php

namespace Pi\Clients\Courses\Services;
use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\CourseUser;
use Pi\Clients\Courses\Module;
use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Clients\Courses\Quizzes\Scoring\QuizScoringService;
use Pi\Exceptions\Clients\Courses\InvalidPassedArticle;
use Pi\Exceptions\Clients\Courses\UserAlreadyAssignedException;
use Pi\Exceptions\EntityNotFoundException;

class UserProgressService
{
    /**
     * @var CoursesService
     */
    private $coursesService;
    /**
     * @var ArticlesService
     */
    private $articlesService;
    /**
     * @var ArticleActionService
     */
    private $articleActionService;
    /**
     * @var QuizScoringService
     */
    private $quizScoring;

    public function __construct(CoursesService $coursesService, ArticlesService $articlesService, ArticleActionService $articleActionService, QuizScoringService $quizScoring)
    {
        $this->coursesService = $coursesService;
        $this->articlesService = $articlesService;
        $this->articleActionService = $articleActionService;
        $this->quizScoring = $quizScoring;
    }

    public function getCourseCompletionPercentageOverall(Course $course)
    {
        $avg = CourseUser::whereCourseId($course->id)->avg('progress_percent');
        $avg = (int) round($avg, 0);
        return $avg;
    }

    public function getCourseCompletionPercentageForUser(Course $course, User $user, $saveToDatabase = true)
    {
        $articleCount = $course->articles->count();
        if ($articleCount == 0) return 100;

        $user = $course->users->where('id', $user->id)->first();

        if ( ! $user )
            throw new \Exception('User does not belong to course.');

        $completion = (int) number_format($user->pivot->articles->count()/$articleCount*100, 0);

        if ($saveToDatabase) {
            $user->pivot->progress_percent = $completion;
            $user->pivot->save();
        }

        return $completion;
    }

    /**
     * Has the user passed the article?  This will calculate if all article actions are done.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function userPassedArticle(Article $article, User $user)
    {
        return ($this->getArticleCompletionPercentageForUser($article, $user) == 100);
    }

    public function getModuleCompletionPercentageForUser(Module $module, User $user, $saveToDatabse = false)
    {
        $articleCount = $module->articles->count();
        if ($articleCount == 0) return 100;
        $articleCompletion = [];
        foreach($module->articles as $article) {
            $articleCompletion[] = $this->getArticleCompletionPercentageForUser($article, $user);
        }

        $sum = array_sum($articleCompletion);
        if (count($articleCompletion) == 0) return 100;
        $pct = intval(number_format($sum/count($articleCompletion), 0));

        return $pct;

    }

    public function getArticleCompletionPercentageForUser(Article $article, User $user, $saveToDatabse = false)
    {
        $hasRead = ($this->articlesService->userHasReadArticle($article, $user))
            ? 100
            : 0;
        $quizPercent = $this->getUserQuizCompletionPercentage($user, $article);
        $actionPercent = $this->getUserArticleActionCompletionPercentage($user, $article);

        $sum = $hasRead + $quizPercent + $actionPercent;
        $pct = intval(number_format($sum/3, 0));

        return $pct;

    }

    public function getUserQuizCompletionPercentage(User $user, Article $article)
    {
        $quizzes = $article->quizzes;

        if ( $quizzes->count() == 0 ) return 0;
        $completionArray = [];
        foreach($quizzes as $quiz) {
            $completionArray[] = (int) $this->quizScoring->userHasPassedQuiz($quiz, $user);
        }
        if ( count($completionArray) == 0) return 0;
        return round(array_sum($completionArray)/count($completionArray), 2) * 100;
    }

    public function getUserArticleActionCompletionPercentage(User $user, Article $article)
    {
        if ( ! $this->coursesService->userBelongsToCourse($user, $article->getCourse())) return 0;
        if ( $article->watchActions->count() == 0 && $article->listenActions->count() == 0) return 0;
        $completionArray = [];
        foreach($article->watchActions as $action) {
            $completionArray[] = (int) $this->articleActionService->userHasCompletedAction($action, $user);
        }
        foreach($article->listenActions as $action) {
            $completionArray[] = (int) $this->articleActionService->userHasCompletedAction($action, $user);
        }
        if ( count($completionArray) == 0) return 0;
        return round(array_sum($completionArray)/count($completionArray), 2) * 100;
    }


    /**
     * @param Course $course
     * @param User $user
     * @return CourseUser
     * @throws EntityNotFoundException
     */
    public function getCourseUser(Course $course, User $user)
    {
        $courseUser = CourseUser::whereCourseId($course->id)->whereUserId($user->id)->first();

        if($courseUser == null)
        {
            throw new EntityNotFoundException(CourseUser::class, 'course_id and user_id', $course->id . '_'. $user->id);
        }

        return $courseUser;
    }

    /**
     * @param CourseUser $courseUser
     * @return Article
     */
    public function getCurrentArticle(CourseUser $courseUser)
    {
        return Article::findOrFail($courseUser->getCurrentArticleId());
    }

    /**
     * @param Course $course
     * @param User $user
     * @return CourseUser
     * @throws UserAlreadyAssignedException
     */
    public function createCourseUser(Course $course, User $user)
    {
        if($course->users->contains($user))
        {
            throw new UserAlreadyAssignedException();
        }

        $articles = $this->coursesService->getCourseArticles($course);

        $courseUser = new CourseUser();
        $courseUser->course_id = $course->id;
        $courseUser->user_id = $user->id;
        $courseUser->progress_percent = 0;
        $courseUser->progress = [
            CourseUser::CURRENT_ARTICLE => $articles[0]->id,
            CourseUser::CURRENT_POINTS => 0,
            CourseUser::PASSED_ARTICLES => [],
        ];

        $courseUser->save();

        return $courseUser;
    }

    public function articlePassed(CourseUser $courseUser, Article $article)
    {
        if(in_array($article->id, $courseUser->getPassedArticles())) return;

        if($article->getCourse()->id != $courseUser->course_id)
        {
            throw new InvalidPassedArticle();
        }

        if($courseUser->getCurrentArticleId() != $article->id)
        {
            // Only one article student can pass - current
            throw new InvalidPassedArticle();
        }

        $progress = $courseUser->progress;

        $progress[CourseUser::PASSED_ARTICLES][] = $article->id;
        $progress[CourseUser::CURRENT_POINTS] = $progress[CourseUser::CURRENT_POINTS]
            + $this->coursesService->getArticleComplexity($article);

        $totalPoints = $this->coursesService->getCourseComplexity($courseUser->course);

        $courseUser->passed = $progress[CourseUser::CURRENT_POINTS] >= $totalPoints;

        $courseUser->progress_percent = ceil(100 * $progress[CourseUser::CURRENT_POINTS] / $totalPoints);

        if(!$courseUser->passed)
        {
            // Find next current article
            foreach($this->coursesService->getCourseArticles($courseUser->course) as $courseArticle)
            {
                print $courseArticle->id . "<br/>";

                if(!in_array($courseArticle->id, $progress[CourseUser::PASSED_ARTICLES]))
                {
                    $progress[CourseUser::CURRENT_ARTICLE] = $courseArticle->id;
                    break;
                }
            }
        }

        $courseUser->progress = $progress;

        $courseUser->save();
    }

    public function resetUserProgressForCourse(Course $course, User $user)
    {
        $moduleIds = $course->modules->lists('id');
        $articleIds = Article::whereIn('module_id', $moduleIds)->lists('id');
        $quizIds = Quiz::whereIn('article_id', $articleIds)->lists('id');
        // Remove quiz attempts and responses
        $user->quizAttempts()->whereIn('quiz_id', $quizIds)->delete();

        // Remove article 'reads'
        \DB::table('course_users')
            ->whereCourseId($course->id)
            ->whereUserId($user->id)->update([
                'read_articles' => json_encode([]),
                'progress' => '',
                'progress_percent' => 0,
                'passed' => 0
            ]);
        // Remove user actions
        $user->articleActions()->whereIn('article_id', $articleIds)->delete();


        return true;
    }
}