<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

class YoutubeController extends Controller
{
    //
    // return response($response, 200);
    public function get_youtube_qualities(Request $request)
    {
        // $url = 'https://tubemp4.is/q?id=XuGmr3OghlQ';

        // // Making a GET request to the external API
        // try {
        //     // Set custom headers to mimic a browser request
        //     $response = Http::withoutVerifying()
        //         ->timeout(60)
        //         ->withHeaders([
        //             'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        //             'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        //             'Accept-Language' => 'en-US,en;q=0.9',
        //             'Accept-Encoding' => 'gzip, deflate',
        //             'Connection' => 'keep-alive',
        //             'Upgrade-Insecure-Requests' => '1',
        //             'Referer' => 'https://google.com',
        //             // 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        //             // 'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        //             // 'Accept-Language' => 'en-US,en;q=0.9',
        //             // 'Accept-Encoding' => 'gzip, deflate, br',
        //             // 'Connection' => 'keep-alive',
        //             // 'Upgrade-Insecure-Requests' => '1',
        //             // 'Referer' => 'https://google.com',
        //         ])->get($url);

        //     // Check if the request was successful
        //     if ($response->successful()) {
        //         // Decode the JSON response
        //         $data = $response->json();

        //         // Return or process the data as needed
        //         return response()->json($data);
        //     } else {
        //         // Handle the error with a detailed response
        //         return response()->json(['error' => 'Failed to fetch data', 'status' => $response->status(), 'body' => $response->body()], $response->status());
        //     }
        // } catch (\Exception $e) {
        //     // Catch any exceptions and return the error message
        //     return response()->json(['error' => 'Exception occurred', 'message' => $e->getMessage()]);
        // }

        $urlYou = $request->youtube_url;
        $url = "https://theofficialvkr.xyz/data/trial.php?vkr=$urlYou&list=PLBNC0xAA8Xshb5CJ769bWjyGdOIrmBFQF&index=1";

        // Send the HTTP GET request with disabled SSL verification and increased timeout
        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Accept-Encoding' => 'gzip, deflate',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
                'Referer' => 'https://google.com',
            ])
            ->get($url);

        if ($response->successful()) {
            // Decode the JSON response into an associative array
            $data = $response->json();

            // Filter results to get only mp4 files
            $mp4Files = [];
            // if (!is_array($data)) {

            // }
            foreach ($data as $key => $item) {
                if (isset($item['ext']) && $item['ext'] === 'mp4') {
                    $mp4Files[] = [
                        'quality' => $item['format'],
                        'url' => $item['url']
                    ];
                }
            }

            return response()->json([
                'url' => $mp4Files
            ]);
        } else {
            return response()->json(['error' => 'Failed to retrieve data', 'message' => $response->body()], 403);
        }

        // Return the filtered results





        //     $youtube = new YouTubeDownloader();

        // try {
        //     $formats = [];
        //     $full_formats = [];
        //     $downloadOptions = $youtube->getDownloadLinks($request->youtube_url);
        //     if ($downloadOptions->getAllFormats()) {

        //         foreach($downloadOptions->getCombinedFormats() as $format){
        //             array_push($formats, ['quality' => $format->qualityLabel, 'url' => $format->url]);
        //             array_push($full_formats, $format);
        //         }
        //     } else {
        //         $data['url'] = [];
        //         return response($data, 203);
        //     }

        //     $data['url'] = $formats;
        //     return response($data, 200);

        //     } catch (YouTubeException $e) {
        //         $data['url'] = [];
        //         return response($data, 201);
        //     }
    }
}
