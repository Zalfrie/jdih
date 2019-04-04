<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Peraturan;
use App\Model\PerBentuk;
use App\Model\Berita;

class SitemapController extends Controller
{
    
    public function __construct()
    {
        header("X-Robots-Tag: noindex", true);
    }
    
    public function index (Request $request)
    {
        $sitemap = \App::make("sitemap");
        //$sitemap->setCache('laravel.sitemap-index', 3600);
        $perBentukList = PerBentuk::where('is_etc', 'f')->orderBy('urutan')->get();
        foreach ($perBentukList as $val){
            $url = '/sitemap/'.strtolower($val->bentuk_short);
            $sitemap->add(\URL::to($url), date('Y-m-d H:i:s'), 1.0, 'daily');
        }
        $sitemap->add(\URL::to('/sitemap/etc'), \Carbon\Carbon::now()->subDays(7)->format('Y-m-d H:i:s'), 0.7, 'weekly');
        $sitemap->add(\URL::to('/sitemap/berita'), date('Y-m-d H:i:s'), 0.8, 'daily');
        $sitemap->add(\URL::to('/visi-misi'), null, 0.5, 'monthly');
    
        return $sitemap->render('xml');
    }
    
    public function berita (Request $request)
    {
        $berita = Berita::orderBy('published_at', 'desc')->get();
        $sitemap_posts = \App::make("sitemap");
        //$sitemap_posts->setCache('laravel.sitemap-posts', 3600);
        $now = \Carbon\Carbon::now();
        foreach ($berita as $post)
        {
            $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->diffInDays($now);
            if ($diff > 90){
                $priority = 0.5;
                $freq = 'monthly';
            }elseif ($diff > 30){
                $priority = 0.6;
                $freq = 'weekly';
            }else{
                $priority = 0.9;
                $freq = 'daily';
            }
            $sitemap_posts->add(\URL::to('/berita').'/'.$post->slug, $post->published_at, $priority, $freq);
        }
        return $sitemap_posts->render('xml');
    }
    
    public function perBentuk (Request $request, $bentuk)
    {
        $peraturan = Peraturan::where('is_publish', 1)->whereNotNull('file_id');
        $perBentukList = false;
        if ($bentuk == 'etc'){
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) IN (SELECT LOWER(bentuk_short) FROM per_bentuk_ref WHERE is_etc IS TRUE)", []);
        }else{
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) = ?", [strtolower($bentuk)]);
        }
        $peraturan = $peraturan->orderBy('published_at', 'desc')->get();
        
        $sitemap_posts = \App::make("sitemap");
        //$sitemap_posts->setCache('laravel.sitemap-posts', 3600);
        $now = \Carbon\Carbon::now();
        foreach ($peraturan as $post)
        {
            $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->diffInDays($now);
            if ($diff > 90){
                $priority = 0.5;
                $freq = 'monthly';
            }elseif ($diff > 30){
                $priority = 0.7;
                $freq = 'weekly';
            }else{
                $priority = 1.0;
                $freq = 'daily';
            }
            $sitemap_posts->add(\URL::to('/lihat/'.$post->per_no), $post->published_at, $priority, $freq);
            $sitemap_posts->add(\URL::to('/baca/'.$post->per_no.'.pdf'), $post->published_at, $priority, $freq);
        }
    
        return $sitemap_posts->render('xml');
    }
}
