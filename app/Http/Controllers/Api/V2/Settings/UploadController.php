<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\Settings\Upload\UploadManageRequest;

class UploadController extends BaseApiController
{
    public function __construct()
    {
    }

    public function upload(UploadManageRequest $request)
    {
        // $requestData = $request->validated();

        // $originalFilename = $requestData['file']->getClientOriginalName();
        // $filename = time() . '_' . $originalFilename; // Generate unique filename

        // $path = Storage::disk('s3')->put($filename, $requestData['file']);

        // if ($path) {
        //     return response()->json([
        //         'message' => 'File uploaded successfully!',
        //         'url' => Storage::disk('s3')->url($filename), // Get public URL from S3
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Upload failed!',
        //     ], 500);
        // }

        try {
            $requestData = $request->validated();

            // Check if 'file' key is present (considering nullability)
            if (!isset($requestData['file'])) {
                throw new \Exception('No file uploaded!');
            }

            $originalFilename = $requestData['file']->getClientOriginalName();
            $filename = time() . '_' . $originalFilename; // Generate unique filename

            $path = Storage::disk('s3')->put($filename, $requestData['file']);

            if ($path) {
                return response()->json([
                    'message' => 'File uploaded successfully!',
                    'url' => Storage::disk('s3')->url($filename), // Get public URL from S3
                ]);
            } else {
                throw new \Exception('Upload to S3 failed!');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
