<?php

namespace App\Traits;

Trait ImageTrait
{
    // this function used to upload single photo if you have a media morph table to add all photos in it
    public function uploadMedia($modelRecord, $folder, $request)
    {
        //remove old file
        if($modelRecord->media)
        {
            Storage::disk('attachments')->delete($folder . '/' . $modelRecord->media->file_name);
            $modelRecord->media->delete();
        }

        $file_size = $request->getSize();
        $file_type = $request->getMimeType();
        $file_name = time() . $request->getClientOriginalName();
        $request->storeAs($folder, $file_name, 'attachments');
        $modelRecord->media()->create([
            'file_path' => asset('public/attachments/' . $folder . '/' . $file_name),
            'file_name' => $file_name,
            'file_size' => $file_size,
            'file_type' => $file_type,
            'file_sort' => 1,
        ]);
    }
}