<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Courses;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Http\Controllers\Controller;

class ModuleController extends Controller
{

    public function create($clientSlug, $courseSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);

        $this->addBreadcrumbs($client, $course, 'Create module');

        return view('pages.clients.manage.courses.modules.create', compact('client', 'course'));
    }

    public function store(Request $request, $clientSlug, $courseSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);

        $this->authorize('manage', [(new Module), $client]);
        $this->validate($request, Module::rules(null, $course));
        $module = $course->modules()->create($request->all());
        return redirect()
            ->route('clients.manage.courses.modules.edit', [$clientSlug, $courseSlug, $module->slug])
            ->with('message', ['success', 'Successfully created a new module: '. $module->name.'.']);
    }

    public function edit($clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
//        $this->authorize('manage', $module);
        if ( ! $module )
            return redirect()->back()->with('message', ['danger', 'Could not find the module.']);

        $this->addBreadcrumbs($client, $course, 'Edit module ' . $module->name);

        return view('pages.clients.manage.courses.modules.edit', compact('module', 'course', 'client'));
    }

    /**
     * Updates a Module
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $courseSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.id', $id)->first();
        if ( ! $module )
            return redirect()->back()->with('message', ['danger', 'Could not find the module.']);
        $this->authorize('manage', $module);
        $this->validate($request, Module::rules($module, $course));
        $module->update($request->all());
        return redirect()->route('clients.manage.courses.modules.edit', ['clientSlug' => $clientSlug, $courseSlug, $module->slug])->with('message', ['success', 'Successfully updated the module '.$module->name.'.']);
    }

    public function destroy($clientSlug, $courseSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.id', $id)->first();
        if ( ! $module )
            return redirect()->back()->with('message', ['danger', 'Could not find the module.']);
        $module->delete();
        return redirect()->back()->with('message', ['warning', 'Module was removed.']);
    }

    public function postArticleOrder(Request $request, $clientSlug, $courseId, $moduleId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereId($courseId)->first();
        $this->authorize('manage', $course);
        $module = $course->modules()->whereId($moduleId)->first();
        $this->authorize('manage', [$module, $client]);
        if ( ! $module )
            return response()->json(['success' => false]);


        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $articleId)
        {
            $module->articles()->whereId($articleId)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $articleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }

    private function addBreadcrumbs(Client $client, Course $course, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addManagementCourseLink($course, $client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}