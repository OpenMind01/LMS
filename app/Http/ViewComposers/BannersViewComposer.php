<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 12:21 PM
 */

namespace Pi\Http\ViewComposers;


use Illuminate\Auth\Guard;
use Illuminate\View\View;
use Pi\Banners\BannersRepository;
use Illuminate\Cache\Repository as Cache;

class BannersViewComposer
{

    /**
     * @var BannersRepository
     */
    private $bannersRepository;
    /**
     * @var Guard
     */
    private $auth;
    /**
     * @var Cache
     */
    private $cache;

    /**
     * BannersViewComposer constructor.
     * @param Guard $auth
     * @param Cache $cache
     * @param BannersRepository $bannersRepository
     */
    public function __construct(Guard $auth, Cache $cache, BannersRepository $bannersRepository)
    {
        $this->bannersRepository = $bannersRepository;
        $this->auth = $auth;
        $this->cache = $cache;
    }

    public function compose(View $view)
    {
        $userBanners = $this->bannersRepository->getNonDismissedForUser($this->auth->user());
        $view->with('userBanners', $userBanners);
    }
}
