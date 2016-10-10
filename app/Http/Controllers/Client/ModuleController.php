<?php
/**
 * Created by Justin McCombs.
 * Date: 10/15/15
 * Time: 3:31 PM
 */

namespace Pi\Http\Controllers\Client;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;
use Pi\Importing\Exceptions\FiletypeNotSupportedException;
use Pi\Importing\Word\WordImporter;
use Pi\Utility\Assets\AssetStorageService;

class ModuleController extends Controller
{

    public function show($clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        return view('pages.clients.courses.modules.show', compact('client', 'course', 'module'));
    }

    public function edit($clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();

        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('manage', $module);
        return view('pages.clients.courses.modules.edit', compact('client', 'course', 'module'));
    }


    public function uploadWordFile(Request $request, WordImporter $wordImporter, AssetStorageService $assetStorage, $clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('manage', $module);

        $file = $request->file('file');
        $path = sys_get_temp_dir().'/'.$file->getClientOriginalName();
        $file->move(sys_get_temp_dir(), $file->getClientOriginalName());
        $wordImporter->setFilePath($path);
        try {
            $wordImporter->import();
        }catch(FiletypeNotSupportedException $e)
        {
            return redirect()->back()->withInput($request->all())->with('message', ['warning', 'That file type is not supported.  Please upload a .docx file.']);
        }

        $wordImporter->getImages()->each(function($localpath) use ($assetStorage, $module) {
            $assetStorage->attachAssetFromPath($module, $localpath, 'image');
        });

        $module->load('assets');

        $articles = $wordImporter->getArticlesForModule($module);

        return redirect()->back()->with('message', ['success', 'Word file imported successfully.']);
    }

}