<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class GitHubReleaseService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com/',
            'timeout'  => 15.0,
        ]);
    }

    public function getLatestRelease($owner, $repo)
    {
        try { 
            $response = $this->client->request('GET', "repos/{$owner}/{$repo}/releases/latest");
            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        } catch (RequestException $e) {
            // Handle the exception or log it as necessary
            return null;
        }
    }

    public function downloadFile($url)
    {
        try {
            $response = $this->client->request('GET', $url);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // Handle the exception or log it as necessary
            return null;
        }
    }

    public function getCachedSigContent($url, $fileName)
    {
        $cacheKey = 'github_release_sig_release_fz_launcher';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }else{
            return Cache::remember($cacheKey, 3600, function () use ($url) {
                try {
                    $response = $this->client->request('GET', $url);
                    return $response->getBody()->getContents();
                } catch (RequestException $e) {
                    // Handle the exception or log it as necessary
                    return null;
                }
            });
        }

       
    }
}