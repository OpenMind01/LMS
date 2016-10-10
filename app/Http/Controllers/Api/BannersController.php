<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 12:41 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Auth\User;
use Pi\Banners\Banner;
use Pi\Banners\BannersRepository;
use Pi\Http\Controllers\Controller;

class BannersController extends Controller
{

    /**
     * @var BannersRepository
     */
    private $bannersRepository;

    public function __construct(BannersRepository $bannersRepository)
    {
        $this->bannersRepository = $bannersRepository;
    }

    public function dismiss(Request $request)
    {
        $banner = Banner::find($request->get('banner_id'));
        $user = User::find($request->get('user_id'));

        if ( ! $banner || ! $user || ! $user->id == \Auth::id() )
            return response()->json([
                'success' => false,
                'message' => 'Request not valid'
            ]);

        $this->bannersRepository->dismissBannerForUser($banner, $user);

        return response()->json(['success' => true]);

    }

}