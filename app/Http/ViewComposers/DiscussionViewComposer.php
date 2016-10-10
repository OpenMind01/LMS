<?php

namespace Pi\Http\ViewComposers;

use Illuminate\View\View;

class DiscussionViewComposer
{
    public function compose(View $view)
    {
        $urlParams = (object) $this->getUrlParams();

        if (isset($urlParams->clientSlug) || isset($urlParams->c)) {

            $clientSlug = isset($urlParams->clientSlug) ? $urlParams->clientSlug : $urlParams->c;
            $routeParams = [$clientSlug];
            $route = 'clients';

            if (isset($urlParams->courseSlug)) {
                $route .= '.courses';
                $routeParams[] = $urlParams->courseSlug;

                if (isset($urlParams->moduleSlug)) {
                    $route .= '.modules';
                    $routeParams[] = $urlParams->moduleSlug;
                }
            }

            $route .= '.discussions.index';

            $view->with('discussionRoute', $route);
            $view->with('discussionRouteParams', $routeParams);
        }
    }

    /**
     * Gets the current URL and Route and parses them to match the URL parameters
     *
     * This method gets an url and route like this:
     * - URL: users/1/apps/15/clients/45
     * - Route: users/{userId}/apps/{appId}/clients/{clientId}
     * And based on that information, gets the actual userId, appId and clientId
     * values returned in an $urlValues array:
     *
     * $urlValues = [
     *     'userId' => 1,
     *     'appId' => 15,
     *     'clientId' => 45
     * ];
     *
     * @return array
     */
    public function getUrlParams()
    {
        $currentPath = \Route::getCurrentRoute()->getPath();
        $currentUrl = \Request::url();
        // If you want to test it with sample data...
        // $currentUrl = 'users/1/apps/15/clients/45';
        // $currentPath = 'users/{userId}/apps/{appId}/clients/{clientId}';
        /**
         * This is gonna match something like users/{userId}/apps/{appId}/clients/{clientId}
         * and replace it into users\/(?P<userId>[a-zA-Z-_0-9]+)\/apps\/(?P<appId>[a-zA-Z-_0-9]+)\/clients\/(?P<clientId>[a-zA-Z-_0-9]+)
         * That's a regex that will be used for matching the parameters form the URL
         * and name the captures
         */
        $pattern = preg_replace('/{([a-zA-Z_-]+)}/', '(?P<$1>[a-zA-Z-_0-9]+)', $currentPath);
        $pattern = str_replace('/', '\/', $pattern);
        /**
         * Do the matches and parse them into a values array
         */
        $matches = [];
        preg_match_all('/' . $pattern . '/', $currentUrl, $matches);
        $urlValues = [];
        foreach ($matches as $key => $match) {
            if (is_string($key)) {
                $urlValues[$key] = array_shift($match);
            }
        }
        return $urlValues;
    }
}
