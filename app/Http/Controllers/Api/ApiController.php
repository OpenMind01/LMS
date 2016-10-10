<?php
/**
 * Created by Justin McCombs.
 * Date: 11/23/15
 * Time: 11:00 AM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pi\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function updateInlineEditable(Request $request, $id, $instance)
    {
        $field = $request->get('name');
        $instance->$field = $request->get('value');
        $instance->save();
        return $this->responseSuccess($instance);
    }

    public function responseSuccess($data, $message = 'Success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function responseError($message = 'Error', $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }

}