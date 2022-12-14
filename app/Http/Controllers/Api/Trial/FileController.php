<?php

namespace App\Http\Controllers\Api\Trial;

use App\Http\Controllers\Api\FileController as BaseFileController;
use App\Support\Filesystem\Filers\Filer;
use App\Support\Models\File;
use Illuminate\Http\Request;

class FileController extends BaseFileController
{
    protected function storeRules(Request $request): array
    {
        return [
            'file' => 'required|file',
        ];
    }

    protected function storeExecute(Request $request)
    {
        return $this->modelProvider()
            ->enablePublish($request->has('publish'))
            ->usePublic($request->has('public'))
            ->useInline($request->has('inline'))
            ->createWithFiler(
                Filer::from($request->file('file'))
            );
    }

    protected function showFile(Request $request, $id)
    {
        return with($this->modelProvider()->model($id), static function (File $file) {
            return $file->responseFile();
        });
    }

    protected function showDownload(Request $request, $id)
    {
        return with($this->modelProvider()->model($id), static function (File $file) {
            return $file->responseDownload();
        });
    }
}
