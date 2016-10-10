<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 11:31 AM
 */

namespace Pi\Http\ViewComposers;


use Illuminate\View\View;
use Pi\Snippets\SnippetService;

class SnippetsViewComposer
{
    /**
     * @var SnippetService
     */
    private $snippetService;

    /**
     * SnippetsViewComposer constructor.
     * @param SnippetService $snippetService
     */
    public function __construct(SnippetService $snippetService)
    {
        $this->snippetService = $snippetService;
    }

    public function compose(View $view)
    {
        $snippetClasses = [];
        foreach($view->getData() as $variable)
        {
            if (is_object($variable))
                $snippetClasses[] = get_class($variable);
        }
        $availableSnippets = $this->snippetService->getAvailableSnippets($snippetClasses);
        $availableSnippets->each(function(&$snippet) {
            $snippet = $snippet->toArray();
        });
        $view->with('availableSnippets', $availableSnippets);
    }

}