<?php


namespace App\Controller;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateImageAction
{
    public function __invoke(Request $request): Image
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $cFile = new \CURLFile($uploadedFile);

        $ch = curl_init();

        $headers = array(
            'Authorization: Client-ID b35570d8e97a268'
        );

        $data = array(
            'image' => $cFile
        );

        $options = array(
            CURLOPT_URL => "https://api.imgur.com/3/upload",
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        );

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $json = json_decode($result, true);

        $url = $json['data']['link'];

        $image = new Image();
        $image->filePath = $url;

        return $image;
    }

}