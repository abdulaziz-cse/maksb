<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Support\Facades\Storage;
use App\Services\V2\Settings\RegionService;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Requests\Api\V2\Settings\Upload\UploadManageRequest;

class UploadController extends BaseApiController
{
    public function __construct(private RegionService $regionService)
    {
    }

    public function store(UploadManageRequest $request)
    {
        $contents = Storage::disk('s3')->get('mak.txt');
        dd($contents);
        // $requestData = $request->validated();

        // $file = $requestData->file('image');

        // $name = time() . $file->getClientOriginalName();

        // $filePath = $name;

        // dd(Storage::disk('s3')->put('ss/', file_get_contents(public_path('d.png'))));

        // $requestData = $request->validated();
        // dd($requestData);
        $file = $request->file('file1');
        // dd($file);
        $name = time() . $file->getClientOriginalName();

        $path = 'images/' . $name;  // Create a subfolder for avatars
        dd(Storage::disk('s3')->put($path, file_get_contents($file)));
        // $result = $file->storeAs($path, $name, 's3');

        // $imagePath = public_path('d.png');  // Replace with the actual path
        // $result = Storage::disk('s3')->put('ss/' . basename($imagePath), fopen($imagePath, 'r'));

        // if ($result) {
        //     // Upload successful, handle the response
        //     dd('Image uploaded to S3!');
        // } else {
        //     // Upload failed, handle the error
        //     dd('Error uploading image to S3!');
        // }

        // $rsult = Storage::disk('s3')->exists('mak.txt');
        // dd($rsult);
    }
}
