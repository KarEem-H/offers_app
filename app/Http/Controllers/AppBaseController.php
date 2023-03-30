<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use App\Helpers\FileHelper;

/**
 * @SWG\Swagger(
 *   basePath="/api",
 *   @SWG\Info(
 *     title="All BU Websites API Endpoints",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{

    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    public function handleRequest($input)
    {
        $input = $this->setTranslations($input);
        $input = $this->uploadFiles($input);
        return $input;
    }

    public function setTranslations(array $input)
    {
        if( !isset($this->model) || !isset(optional($this->model)->translatable)  )
            return $input;

        foreach ($this->model->translatable as $key) {
            $input[$key] = ['ar' => $input[$key . '_ar'] ?? '', 'en' => $input[$key . '_en'] ?? ''];
        }
        return $input;
    }

    public function uploadFiles($input)
    {
        if( !isset($this->model) ||  !isset($this->model->files) || !isset($this->model->dir)  )
            return $input;

        foreach($this->model->files as $file){

            if(isset($input[$file]) && is_file($input[$file])){
                //delete old images when edit
                if($file_path = $this->model->$file){
                    FileHelper::delete_picture($file_path);
                }
                $input[$file] = FileHelper::upload_file(request('bussinessUnit')->name . '/' . $this->model->dir, $input[$file]);
            } else {
                unset($input[$file]);
            }

        }

        if($this->model->has_gallery && isset($input['gallery'])){
            $input['gallery_paths'] = [];
            foreach($input['gallery'] as $image){
                $input['gallery_paths'][] = ['path' => FileHelper::upload_file(request('bussinessUnit')->name . '/' . $this->model->dir . 'gallery/', $image)];
            }
        }

        return $input;
    }


}
