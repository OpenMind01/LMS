<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 10:35 AM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;
use Pi\Snippets\SnippetService;

class SnippetsController extends Controller
{

    /**
     * @var SnippetService
     */
    private $snippets;

    public function __construct(SnippetService $snippets)
    {
        $this->snippets = $snippets;
    }

    public function index(Request $request)
    {
        if ( ! $request->has('classes') || ! is_array($request->get('classes'))) {
            return response()->json([
                'success' => false,
                'message' => 'You must provide an array, "classes", of class names',
            ]);
        }
        $snippets = $this->snippets->getAvailableSnippets($request->get('classes'));

        return response()->json([
            'success' => true,
            'snippets' => $snippets
        ]);
    }

}