<?php

namespace PVincenT\Commons\Traits;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function upLoadFile(UploadedFile $file, $attribute, $folder)
    {
        tap($this->attributes[$attribute], function ($previous) use ($file, $folder, $attribute) {
            $this->forceFill([
                $attribute => $file->storePublicly(
                    $folder,
                    ['disk' => $this->fileDisk()]
                ),
            ])->save();
            if ($previous) {
                Storage::disk($this->fileDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteFile($attribute)
    {
        if (is_null($this->attributes[$attribute])) {
            return;
        }

        Storage::disk($this->fileDisk())->delete($this->attributes[$attribute]);

        $this->forceFill([
            $attribute => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getFileAttribute($attribute, $defaultFromColumnAttribute = null)
    {
        return $this->attributes[$attribute]
            ? Storage::disk($this->fileDisk())->url($this->attributes[$attribute])
            : $this->defaultFileUrl($defaultFromColumnAttribute);
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultFileUrl($attribute = null)
    {
        if ($attribute === null) return '';
        $name = trim(collect(explode(' ', $this->attributes[$attribute]))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function fileDisk()
    {
        return config('filesystems.default');
    }
}
