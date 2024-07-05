<?php

namespace App\Http\Controllers;

use App\Services\GitHubReleaseService;
use Illuminate\Http\Request;

class UpdaterController extends Controller
{
    
    protected $gitHubReleaseService;

    public function __construct(GitHubReleaseService $gitHubReleaseService)
    {
        $this->gitHubReleaseService = $gitHubReleaseService;
    }
    
    public function check(Request $request, $target, $arch, $current_version) {
        $sig_file = 'signature.sig';
        $latestRelease = $this->gitHubReleaseService->getLatestRelease("FrazionZ", "FzLauncherReleases");

        if(count($latestRelease['assets']) < 2) return response()->json(['status' => 'error', 'message' => 'Assets list empty']);

        /*if ($latestRelease && isset($latestRelease['assets'])) {
            foreach ($latestRelease['assets'] as $asset) {
                if ($asset['name'] === $sig_file) {
                    $fileContent = $this->gitHubReleaseService->downloadFile($asset['browser_download_url'], $sig_file);
                    if ($fileContent !== null) {
                        $latestRelease['sig_content'] = $fileContent;
                    }
                }
            }
        }*/

        $tag_splited = explode('-', $latestRelease['name']);
        if(count($tag_splited) !== 3) return response()->json(['status' => 'error', 'message' => 'Name version not valid.']);
        
        $name_version = $tag_splited[0];
        $target_version = $tag_splited[1];
        $arch_version = $tag_splited[2];

        return response()->json([
            'version' => $name_version,
            'pub_date' => $latestRelease['published_at'],
            'url' => $latestRelease['assets'][0]['browser_download_url'],
            'signtaures' => $latestRelease['sig_content'],
            'notes' => $latestRelease['body']
        ]);
    }

}
