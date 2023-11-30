<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    /**
     * Upload single file
     *
     * @param Request $request
     * @param FileUploadService $fileUploadService
     * @return JsonResponse
     */
    public function upload(Request $request, FileUploadService $fileUploadService): JsonResponse
    {
        $allowedFileExtensions = implode(',', $fileUploadService->images() + $fileUploadService->videos());
        $validator = Validator::make($request->all(), [
            'campaign_id' => ['nullable', 'string'],
            'file' => ['required','file', 'max:5120', 'mimes:' . $allowedFileExtensions],
            'size' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) { 
            return $this->validationError($validator->errors());
        }

        $file = $request->file('file');
        $data = [];
        if ($file->isValid()) {
            $options = [
                'id' => $request->campaign_id ?? 'default',
                'size' => $request->size ?? null,
                'disk' => 's3',
            ];
            $data = $fileUploadService->upload($file, $options);
        }
        return $this->sendSuccess($data);
    }

    /**
     * Upload multiple file
     *
     * @param Request $request
     * @param FileUploadService $fileUploadService
     * @return JsonResponse
     */
    public function uploadMultiple(Request $request, FileUploadService $fileUploadService): JsonResponse
    {
        $allowedFileExtensions = implode(',', $fileUploadService->images() + $fileUploadService->videos());
        $validator = Validator::make($request->all(), [
            'files.*.campaign_id' => ['required', 'string'],
            'files.*.file' => ['required','file', 'max:5120', 'mimes:' . $allowedFileExtensions],
            'files.*.size' => ['required', 'string'],
        ]);

        if ($validator->fails()) { 
            return $this->validationError($validator->errors());
        }

        $files = $request->all()['files'] ?? [];
        $data = [];
        foreach($files as $file) {
            if ($file['file']->isValid()) {
                $options = [
                    'id' => $file['campaign_id'],
                    'size' => $file['size'],
                    'disk' => 's3',
                ];
                $data[] = $fileUploadService->upload($file['file'], $options);
            }
        }
        return $this->sendSuccess(['results' => $data]);
    }
}
