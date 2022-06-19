<?php

namespace Tests\E2E\Services\Storage;

use Tests\E2E\Client;
use Tests\E2E\Scopes\ProjectCustom;
use Tests\E2E\Scopes\Scope;
use Tests\E2E\Scopes\SideServer;

class VideoCustomServerTest extends Scope
{
    use StorageBase;
    use ProjectCustom;
    use SideServer;

    public function testTranscoding(): array
    {


//        $bucket = $this->client->call(Client::METHOD_POST, '/storage/buckets', [
//            'content-type' => 'application/json',
//            'x-appwrite-project' => $this->getProject()['$id'],
//            'x-appwrite-key' => $this->getProject()['apiKey'],
//        ], [
//            'bucketId' => 'unique()',
//            'name' => 'Test Bucket 2',
//            'permission' => 'file',
//            'read' => ['role:all'],
//            'write' => ['role:all']
//        ]);
//
//        $source = __DIR__ . "/../../../resources/disk-a/large-file.mp4";
//        $totalSize = \filesize($source);
//        $chunkSize = 5 * 1024 * 1024;
//        $handle = @fopen($source, "rb");
//        $fileId = 'unique()';
//        $mimeType = mime_content_type($source);
//        $counter = 0;
//        $size = filesize($source);
//        $headers = [
//            'content-type' => 'multipart/form-data',
//            'x-appwrite-project' => $this->getProject()['$id']
//        ];
//        $id = '';
//
//        while (!feof($handle)) {
//            $curlFile = new \CURLFile('data:' . $mimeType . ';base64,' . base64_encode(@fread($handle, $chunkSize)), $mimeType, 'in1.mp4');
//            $headers['content-range'] = 'bytes ' . ($counter * $chunkSize) . '-' . min(((($counter * $chunkSize) + $chunkSize) - 1), $size) . '/' . $size;
//
//            if (!empty($id)) {
//                $headers['x-appwrite-id'] = $id;
//            }
//
//            $file = $this->client->call(Client::METHOD_POST, '/storage/buckets/' . $bucket['body']['$id'] . '/files', array_merge($headers, $this->getHeaders()), [
//                'fileId' => $fileId,
//                'file' => $curlFile,
//                'read' => ['role:all'],
//                'write' => ['role:all'],
//            ]);
//            $counter++;
//            $id = $file['body']['$id'];
//        }
//        @fclose($handle);
//
//          $pid = $this->getProject()['$id'];
//          $key = $this->getProject()['apiKey'];
//          $fid = $id;
//          $bid = $bucket['body']['$id'];
//
//          var_dump($pid);
//          var_dump($key);
//          var_dump($fid);
//          var_dump($bid);

//
        $pid = '62aedd7c27c6f34ca44d';
        $key = '1cd0589616c0b0b98dbc42764399799e3dcf0fbcfa0d1f1db2a258573783802267551853ffa77d2895e57597835055afb645237e84d07cffd33f946af6598f40cdfdc11b9eb6bee09fdd0a325a4b5e3ef34fdf4ba745a87dc4de16f9935803c9ff6349f424774b2a4d3c8ce8a40a835b16486dec9e8c1f8fc16bc37e357f9daf';
        $fid = '62aedd7dcdcc014783ff';
        $bid = '62aedd7c90a8570ebf31';

        $transcoding = $this->client->call(Client::METHOD_POST, '/video/buckets/' . $bid . '/files/' .  $fid, [
            'content-type' => 'application/json',
            'x-appwrite-project' => $pid,
            'x-appwrite-key' => $key,
        ], [
            'read' => ['role:all'],
            'write' => ['role:all']
        ]);

        return [
            'projectId' => $pid,
            'apiKey' => $key,
            'bucketId' => $bid,
            'fileId' => $fid,
        ];
    }


    public function testRenditions(): void
    {

        $pid = '62aedd7c27c6f34ca44d';
        $key = '1cd0589616c0b0b98dbc42764399799e3dcf0fbcfa0d1f1db2a258573783802267551853ffa77d2895e57597835055afb645237e84d07cffd33f946af6598f40cdfdc11b9eb6bee09fdd0a325a4b5e3ef34fdf4ba745a87dc4de16f9935803c9ff6349f424774b2a4d3c8ce8a40a835b16486dec9e8c1f8fc16bc37e357f9daf';
        $fid = '62aedd7dcdcc014783ff';
        $bid = '62aedd7c90a8570ebf31';


        $renditions = $this->client->call(Client::METHOD_GET, '/video/buckets/' . $bid . '/files/' .  $fid . '/renditions', [
            'content-type' => 'application/json',
            'x-appwrite-project' => $pid,
            'x-appwrite-key' =>  $key,
        ]);
         var_dump($renditions['body']);
    }


    public function testPlaylist(): void
    {

        $pid = '62aedd7c27c6f34ca44d';
        $key = '1cd0589616c0b0b98dbc42764399799e3dcf0fbcfa0d1f1db2a258573783802267551853ffa77d2895e57597835055afb645237e84d07cffd33f946af6598f40cdfdc11b9eb6bee09fdd0a325a4b5e3ef34fdf4ba745a87dc4de16f9935803c9ff6349f424774b2a4d3c8ce8a40a835b16486dec9e8c1f8fc16bc37e357f9daf';
        $fid = '62aedd7dcdcc014783ff';
        $bid = '62aedd7c90a8570ebf31';
        $stream = 'dash';

        $renditions = $this->client->call(Client::METHOD_GET, '/video/buckets/' . $bid . '/files/' . $stream . '/' .  $fid, [
            'content-type' => 'application/json',
            'x-appwrite-project' => $pid,
            'x-appwrite-key' =>  $key,
        ]);
        var_dump($renditions['body']);
    }
}