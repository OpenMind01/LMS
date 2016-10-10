<?php
namespace Pi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;
use Pi\Utility\Assets\AssetStorageService;
use Pi\Utility\Assets\Asset;

class FileManagerController extends Controller
{

    public function index(Request $request, AssetStorageService $assetStorage, $clientSlug, $courseSlug)
//    public function index(Request $request, $clientSlug, $courseSlug)
    {
        // Initialize variables.
        $response = array();
        $action = $request->input('action');

        // Get client and course.
        $client = Client::whereSlug($clientSlug)->first();
        $course = $client->courses()->whereSlug($courseSlug)->first();

		//$input = $request->all();
		//print_r($input);

        // Execute action.
        if ($action) {
            switch ($action) {
                case 'delete': {
                    // TODO
                    $response = "delete";
                    break;
                }
                case 'rename': {
                    // TODO
                    $response = "rename";
                    break;
                }
                case 'save': {
                    // TODO
                    $imageBased64encoded = $request->get('image');
                    $image = base64_decode(substr($imageBased64encoded, strpos($imageBased64encoded, 'base64,') + 7));
                    $filename = basename($request->input('id'));

                    $tempPath = sys_get_temp_dir().'/'.$filename;
                    file_put_contents($tempPath, $image);
                    $assetStorage->attachAssetFromPath($course, $tempPath, 'gallery');

                    $response = "saved";
                    break;
                }
                case 'upload': {
                    // TODO: Verify that this implementation works an put a try-catch and send an error response if an exception occurs.
                    // Get file and move it to a temporary location.
                    $fileName = basename($request->input('name'));
                    $file = $request->file('file');
                    $filename = $file->getClientOriginalName();
                    $fileExt = $file->getClientOriginalExtension();
                    $tempPath = sys_get_temp_dir().'/'.$filename;
                    $file->move(sys_get_temp_dir(), $filename);
                    $assetStorage->attachAssetFromPath($course, $tempPath, 'gallery');
                    // Return success message.
                    $response = [
                        'jsonrpc' => '2.0',
                        'result' => $fileName,
                        'id' => 1234,
                        'debug' => '',
                    ];
                    break;
                }
                case 'download': {
                    // TODO: Get the image URL from the database.
					$imgUrl = $request->input('path');
					return redirect()->away($imgUrl);
					//return response()->download($imgUrl); // This method do not works when the file is from an external URL source
                    break;
                }
                case 'view': {
                    // TODO
                    $response = "view";
                    break;
                }
                case 'list': {
                    $files = [];
                    foreach($course->assets as $asset) {
                        /** @var $asset Asset */
                        // '{ "name": "bxJ33DL.jpg", "iconSrc": "http://i.imgur.com/bxJ33DL.jpg", "attributes": { "alt": "" }, "type": "JPG", "size": 0, "mtime": 946684800, "tags": [ "Image" ] }, ' .

                        $files[] = [
//                            'name' => pathinfo($asset->path, PATHINFO_FILENAME),
                            'name' => $assetStorage->getUrlForAsset($asset),
                            'iconSrc' => $assetStorage->getUrlForAsset($asset),
                            'attributes' => ['alt' => ''],
                            'type' => 'JPG',
                            'size' => 1000,
                            'mtime' => $asset->created_at->timestamp,
                            'tags' => 'Image'
                        ];

                    }
                    $response = [
                        'directories' => [],
                        'tags' => [],
                        'files' => $files,
                        'totalFiles' => $course->assets->count(),
                        'total' => 1,
                        'currentDirectory' => 0,
                        'start' => 1,
                        'limit' => 10,
                        'filteredTotal' => count($files)
                    ];

                    break;
                }
            }
        }

        // Return result.
        return response()->json($response, Response::HTTP_OK);
    }

    public function getTestView($clientSlug, $courseSlug)
	{
		// TODO: make the URI dynamics (remove the hardcoded value "http://192.168.10.10/c/tpi-test/manage/courses/course-1/").
		echo '<html>' .
				'<head>' .
					'<script src="/assets/js/jquery-2.1.1.min.js"></script>' .
					'<script src="/assets/plugins/raptor-editor/raptor.js"></script>' .
					'<link rel="stylesheet" href="/assets/plugins/raptor-editor/raptor-front-end.css" />' .
				'</head>' .
				'<body>' .
				    '<div id="file-manager"></div>' .
				    '<script type="text/javascript">' .
				        'var rfm = new RFM({' .
				            'node: document.getElementById("file-manager"),' .
				            'uriAction: "http://192.168.10.10/c/tpi-test/manage/courses/course-1/filemanager",' .
				            'uriIcon: "http://i.imgur.com/"' .
				       '});' .
				        'rfm.refresh();' .
				    '</script>' .
				'</body>' .
			'</html>';
	}
}