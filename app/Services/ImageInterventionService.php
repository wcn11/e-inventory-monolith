<?php


namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageInterventionService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store($directoryName, $data = null, $imageEncode = 100, $thumbEncode = 60)
    {

        return $this->imageIntervention('store', $data, $directoryName);
    }

    public function update($oldFile, $directoryName = "categories", $imageEncode = 100, $thumbEncode = 60)
    {

        return $this->imageIntervention('update', $oldFile, $directoryName);
    }

    private function imageIntervention($type = 'store', $data = null, $directoryName = "categories", $imageEncode = 100, $thumbEncode = 60): array
    {

        $response = [];

        if ($this->request->has('image')) {

            $file = $this->request->file('image');
            $filename = time() . '-' . $file->getClientOriginalName();

            $image = Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($file->getClientOriginalExtension(), $imageEncode);

            $thumb = Image::make($file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($file->getClientOriginalExtension(), $thumbEncode);

            $imagePath = "public/$directoryName/" . $filename;
            $thumbPath = "public/$directoryName/thumb/" . $filename;

            if ($type === 'update') {
                $this->delete($data, $directoryName);
            }

            Storage::put($imagePath, $image);
            Storage::put($thumbPath, $thumb);

            $response = [
                'status' => true,
                'message' => "",
                'data' => [
                    "filename" => $filename,
                    "imageURL" => Storage::url($imagePath),
                    "thumbURL" => Storage::url($thumbPath)
                ]
            ];
        } else {
            $response = [
                'status' => false,
                'message' => __('File Tidak Ditemukan')
            ];
        }
        return $response;
    }

    public function delete($file, $directoryName = 'categories'): void
    {
        $filename = json_decode($file['image'], true);
        Storage::delete(['public/' . $directoryName . '/' . $filename['filename'], 'public/' . $directoryName . '/thumb/' . $filename['filename']]);
    }
}
