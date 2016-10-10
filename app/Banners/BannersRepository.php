<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 12:22 PM
 */

namespace Pi\Banners;


use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Client;
use Illuminate\Cache\Repository as Cache;

class BannersRepository
{

    /**
     * @var Cache
     */
    private $cache;

    public function __construct(Cache $cache)
    {

        $this->cache = $cache;
    }

    public function getNonDismissedForUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            $clientIds = Client::lists('id')->toArray();
        }else {
            $clientIds = [$user->client_id];
        }

        return $this->cache->remember($this->getCacheKeyForUserId($user->id), 30, function() use($clientIds, $user) {
            return Banner::whereIn('client_id', $clientIds)
                ->leftJoin('banner_user', function($j) use ($user) {
                    $j->on('banner_user.banner_id', '=', 'banners.id')
                        ->where('banner_user.user_id', '=', $user->id);
                })
                ->whereNull('banner_user.id')
                ->select('banners.*')
                ->get();
        });

    }

    public function getDismissedForUser(User $user)
    {
        return $user->dismissedBanners;
    }

    public function dismissBannerForUser(Banner $banner, User $user)
    {
        if ( ! $user->dismissedBanners()->where('banner_id', '=', $banner->id)->count() )
            $user->dismissedBanners()->attach($banner->id);

        $this->cache->forget($this->getCacheKeyForUserId($user->id));
        return true;
    }

    public function getCacheKeyForUserId($userId)
    {
        return 'user_banners_'.$userId;
    }

    public function clearCacheForClient(Client $client)
    {
        $userIds = $client->users()->lists('id');
        $superUserIds = User::whereRole(Role::SUPER_ADMIN)->lists('id');

        $userIds = $userIds->merge($superUserIds);

        foreach($userIds as $userId)
        {
            $this->cache->forget($this->getCacheKeyForUserId($userId));
        }
        return $this;
    }

}