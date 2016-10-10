<?php
/**
 * Created by Justin McCombs.
 * Date: 12/9/15
 * Time: 4:37 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Courses\Article;
use Pi\Utility\Assets\AssetStorageService;

class ArticleGalleryController extends ApiController
{

    public function store(Request $request, AssetStorageService $assetStorageService, $articleId)
    {
        $article = Article::whereId($articleId)->first();
        $this->authorize('manage', $article);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = storage_path();
        $file->move($path, $filename);
        $asset = $assetStorageService->attachAssetFromPath($article, $path.'/'.$filename, 'image', $request->get('caption'));

        return response()->json(['success' => true, 'input' => $request->all(), 'id' => $asset->id]);
    }

    public function update(Request $request, $articleId, $assetId)
    {
        if ( ! $request->get('caption'))
            return $this->responseError('You must include a caption in the request.');

        $article = Article::whereId($articleId)->first();
        $this->authorize('manage', $article);
        $asset = $article->assets()->whereId($assetId);
        if ( ! $asset )
            return $this->responseError('Could not find the asset.');

        $asset->update(['caption' => $request->get('caption')]);

        return $this->responseSuccess($asset);
    }

    public function destroy(Request $request, AssetStorageService $assetStorageService, $articleId, $assetId) {
        $article = Article::whereId($articleId)->first();
        $this->authorize('manage', $article);
        $asset = $article->assets()->whereId($assetId)->first();
        if ($asset) {
            $asset->delete();
        }
        return redirect()->back()->with('message', ['success', 'Gallery Item Deleted.']);
    }



}