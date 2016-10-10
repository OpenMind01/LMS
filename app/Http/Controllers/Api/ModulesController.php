<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 4:54 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Module;
use Pi\Http\Controllers\Controller;

class ModulesController extends ApiController
{

    public function update(Request $request, $id)
    {
        $module = Module::find($id);
        $this->authorize('manage', $module);

        if ( $request->has('pk')) {
            return $this->updateInlineEditable($request, $id, $module);
        }
        dd($request->all());
    }

    public function inlineUpdate(Request $request, $id)
    {

        $article = Article::find($id);

        if ( ! $article )
            return response()->json(['success' => false]);

        $this->authorize('manage', $article);

        $attributes = [];

        foreach(json_decode($request->get('raptor-content')) as $field => $value)
        {
            $attributes[$field] = $value;
        }

        $newArticle = $article->createNewVersion($attributes);



        return response()->json([
            'success' => true,
        ]);
    }

    public function updateOrder(Request $request, $id)
    {
        $module = Module::whereId($id)->first();
        $this->authorize('manage', $module);

        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $articleId)
        {
            $module->articles()->whereId($articleId)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $articleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }

}