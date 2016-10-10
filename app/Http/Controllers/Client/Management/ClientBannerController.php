<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Client\Management;


use Illuminate\Http\Request;
use Pi\Banners\Banner;
use Pi\Banners\BannersRepository;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;

class ClientBannerController extends Controller
{

    /**
     * @var BannersRepository
     */
    private $bannersRepository;

    public function __construct(BannersRepository $bannersRepository)
    {
        $this->bannersRepository = $bannersRepository;
    }

    public function index($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', [(new Banner), $client]);
        $banners = Banner::whereClientId($client->id)->with('dismissedUsers', 'author')->get();
        return view('pages.clients.manage.banners.index', compact('banners', 'client'));
    }

    public function create($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', [(new Banner), $client]);
        return view('pages.clients.manage.banners.create', compact('client'));
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', [(new Banner), $client]);
        $this->validate($request, Banner::rules());
        $banner = Banner::create($request->all());
        $this->bannersRepository->clearCacheForClient($client);
        return redirect()->route('clients.manage.banners.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new banner: '. $banner->name.'.']);
    }

    public function edit($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $banner = Banner::whereId($id)->with('dismissedUsers')->first();
        $this->authorize('manage', [$banner, $client]);
        if ( ! $banner )
            return redirect()->back()->with('message', ['danger', 'Could not find the banner.']);

        return view('pages.clients.manage.banners.edit', compact('banner', 'client'));
    }

    /**
     * Updates a Banner
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $banner = Banner::find($id);
        $this->authorize('manage', [$banner, $client]);
        if ( ! $banner )
            return redirect()->back()->with('message', ['danger', 'Could not find the banner.']);

        $this->validate($request, Banner::rules($banner));

        $banner->update($request->all());

        $this->bannersRepository->clearCacheForClient($client);

        return redirect()->route('clients.manage.banners.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the banner '.$banner->name.'.']);
    }

    public function destroy($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $banner = Banner::find($id);
        $this->authorize('manage', [$banner, $client]);
        if ( ! $banner )
            return redirect()->back()->with('message', ['danger', 'Could not find the banner.']);
        $banner->delete();
        $this->bannersRepository->clearCacheForClient($client);
        return redirect()->back()->with('message', ['warning', 'Banner was removed.']);
    }

}