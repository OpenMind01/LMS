<?php
/**
 * Created by Justin McCombs.
 * Date: 12/9/15
 * Time: 4:37 PM
 */

namespace Pi\Http\Controllers\Api;


use Pi\Clients\Courses\Article;

class ArticleVersionControlController extends ApiController
{

    public function show($uuid)
    {
        $article = Article::whereUuid($uuid)->first();
        $this->authorize($article);

        $response = [
            'current' => [
                'identifier' => $article->id,
                'content' => $article->body,
                'updated' => $article->updated_at->timestamp.'000'
            ],
            'revisions' => [],
        ];
        foreach($article->previousVersions as $version)
        {
            /** @var $version Article */
            $response['revisions'][] = [
                'identifier' => $version->id,
                'content' => $version->body,
                'updated' => $version->updated_at->timestamp.'000',
            ];
        }

        return response()->json($response);
    }

}