<?php

namespace Pi\Clients\Courses\Services;

use Illuminate\Support\Collection;
use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Courses\Quizzes\QuizzesService;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\ArticleTopic;
use Pi\Events\Courses\ArticleActionCompleted;

class ArticlesService
{
    /**
     * @var QuizzesService
     */
    private $quizzesService;

    public function __construct(QuizzesService $quizzesService)
    {
        $this->quizzesService = $quizzesService;
    }

    public function markArticleAsReadForUser(Article $article, User $user)
    {
        if ( in_array($user->role, [Role::SUPER_ADMIN, Role::ADMIN])) {
            return $this;
        }

        $_user = $article->module->course->users()->where('user_id', '=', $user->id)->first();

        if ( ! $_user ) {
            throw new \Exception('User does not belong to course');
        }

        $articles = $_user->pivot->articles;
        if ( ! in_array($article->id, $articles->toArray())) {
            $articles->push($article->id);
        }
        $_user->pivot->articles = $articles;
        $_user->pivot->current_article_id = $article->id;
        $_user->pivot->save();

        \Event::fire(new ArticleActionCompleted($user, $article));

        return $this;
    }

    public function userHasReadArticle(Article $article, User $user)
    {
        $_user = $article->module->course->users->filter(function($_user) use($user) {
            return ($user->id == $_user->id);
        })->first();

        if ( in_array($user->role, [Role::SUPER_ADMIN, Role::ADMIN])) {
            return false;
        }

        if ( ! $_user ) {
            throw new \Exception('User does not belong to course');
        }

        \Event::fire(new ArticleActionCompleted($user, $article));

        return in_array($article->id, $_user->pivot->articles->toArray());
    }

    /**
     * Clones article into new module.
     *
     * @param Article $article
     * @param Module $parent
     * @return Article
     */
    public function cloneArticle(Article $article, $parent)
    {
        $newArticle = new Article();
        $newArticle->client_id = $parent->client_id;
        $newArticle->module_id = $parent->id;
        $newArticle->name = $article->name;
        $newArticle->body = $article->body;

        $newArticle->save();

        foreach($article->quizzes as $quiz)
        {
            $this->quizzesService->cloneQuiz($quiz, $newArticle);
        }

        return $newArticle;
    }

    public function renderArticleContentBoxes($articleBody) {
        // Remove html entitites causing errors
        $body = preg_replace("/<p> ?\[contentBox=? ?(.*?)\]<\/p>/", "[contentBox=$1]", $articleBody);
        $body = preg_replace("/<p> ?\[\/contentBox\]<\/p>/", "[/contentBox]<br />", $body);

        // Title Based
        $body = preg_replace("/\[contentBox=(.*?)\](.*?)\[\/contentBox\]/", "<span class='content-box modal-content-box'> <span class='title'>$1</span> <span class='content'>$2</span> </span>", $body, -1, $count);

        // Image Based
        $body = preg_replace("/\[contentBox (.*?)\](.*?)\[\/contentBox\]/", "<span class='content-box modal-content-box'> <span class='title title-$1'></span> <span class='content'>$2</span> </span>", $body, -1, $count);
        return $body;
    }

    public function renderArticleTooltipBoxes($articleBody) {
        $body = preg_replace("/<p> ?\[tooltipBox=(.*?)\]<\/p>/", "[tooltipBox=$1]", $articleBody);
        $body = preg_replace("/<p> ?\[\/tooltipBox\]<\/p>/", "[/tooltipBox]<br />", $body);
        return preg_replace_callback("/\[tooltipBox=(.*?)\](.*?)\[\/tooltipBox\]/", function ($matches) {
            return "<span class='content-box tooltip-content-box'> <span class='title' rel='popover' data-original-title='".ucwords($matches[1])."'>{$matches[1]}</span> <span class='content'>{$matches[2]}</span> </span>";
        }, $body, -1, $count);
    }

    public function renderArticleTooltips($articleBody)
    {
        return preg_replace('/\[tooltip=(.+)\](.+)\[\/tooltip\]/s', '<div class="article-tooltip">$1<div class="article-tooltip-body"><div class="article-tooltip-inner">$2</div><div class="article-tooltip-close"></div></div></div>', $articleBody);
    }
    
    public function getArticleSections(Article $article)
    {
        $sections = new Collection;
        $articleBody = $article->rendered_body;
        preg_match_all("/\[topic=(.*?)\]/", $articleBody, $matches, PREG_OFFSET_CAPTURE);
        $firstSection = false;

        if (!$matches || !count($matches) || !count($matches[1])) {
            $section = new ArticleTopic();
            $section->setNumber(1);
            $section->setBody($articleBody);
            $section->setTitle('Table of Contents');
            $sections->push($section);
            return $sections;
        }
        foreach($matches[1] as $key => $valueArray)
        {
            // If the offset is more than 0, create a preliminary section with the title 'Introduction'
            if ($valueArray[1] > 0 && $key == 0) {
                $section = new ArticleTopic();
                $section->setNumber(1);
                $section->setBody(substr($articleBody, 0, $matches[0][$key][1]));
                $section->setTitle('Table of Contents');
                $firstSection = true;
                $sections->push($section);
            }
            // First offset is title offset + title length
            $offset1 = $matches[0][$key][1] + strlen($matches[0][$key][0]);
            // Last offset is first offset - next offset
            $offset2 = (!empty($matches[1][$key+1]))
                ? $matches[0][$key+1][1] - $offset1
                : strlen($articleBody) - $offset1;

            $body = substr($articleBody, $offset1, $offset2);
            $title = $valueArray[0];
            $number = ($firstSection) ? $key+2 : $key+1;


            $section = new ArticleTopic();
            $section->setTitle($title);
            $section->setNumber($number);
            $section->setBody($body);
            $sections->push($section);

        }

        return $sections;
    }

    public function articleIsLastInModule(Article $article)
    {
        $lastArticle = $article->module->articles
            ->sort(function($a, $b) {
                return ($a->number > $b->number);
            })
            ->last();
        return ($article->id == $lastArticle->id);
    }

    public function articleIsFirstInModule(Article $article)
    {
        $lastArticle = $article->module->articles->first();
        return ($article->id == $lastArticle->id);
    }

    public function getNextArticleForUser(Article $article, User $user) {
        // If last in module, look for the next module
        $isLast = $this->articleIsLastInModule($article);
        if ($isLast) {
            $module = null;
            $foundThisModule = false;
            foreach($article->getCourse()->modules->sort(function($a, $b) {
                return ($a->number > $b->number);
            }) as $_module) {
                if ($foundThisModule) {
                    $module = $_module;
                    break;
                }
                if ($_module->id == $article->module_id) {
                    $foundThisModule = true;
                }
            }
            if (!$module) return null;
            return $module->articles->first();
        }
        $nextArticle = null;
        $foundThisArticle = false;
        foreach($article->module->articles->sort(function($a, $b) {
            return ($a->number > $b->number);
        }) as $_article) {
            if ($foundThisArticle) {
                $nextArticle = $_article;
                break;
            }
            if ($_article->id == $article->id) {
                $foundThisArticle = true;
            }
        }
        return $nextArticle;
    }

    public function getPreviousArticleForUser(Article $article, User $user) {
        // If last in module, look for the next module
        $isFirst = $this->articleIsFirstInModule($article);

        if ($isFirst) {
            $module = null;
            $foundThisModule = false;
            foreach($article->getCourse()->modules->sort(function($a, $b) {
                return ($a->number > $b->number);
            })->reverse() as $_module) {
                if ($foundThisModule) {
                    $module = $_module;
                    break;
                }
                if ($_module->id == $article->module_id) {
                    $foundThisModule = true;
                }
            }
            if (!$module) return null;
            return $module->articles->last();
        }
        $prevArticle = null;
        $foundThisArticle = false;
        foreach($article->module->articles->sort(function($a, $b) {
            return ($a->number > $b->number);
        })->reverse() as $_article) {
            if ($foundThisArticle) {
                $prevArticle = $_article;
                break;
            }
            if ($_article->id == $article->id) {
                $foundThisArticle = true;
            }
        }
        return $prevArticle;
    }
}