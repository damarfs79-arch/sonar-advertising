<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.xml', function () {
    $baseUrl = config('app.url', 'https://sonaradvertising.com');
    $posts = \App\Models\BlogPost::where('status', 'published')->get();
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    $staticPages = ['', '/about', '/services', '/portfolio', '/blog', '/testimonials', '/contact', '/privacy', '/terms'];
    foreach ($staticPages as $page) {
        $xml .= '<url><loc>' . rtrim($baseUrl, '/') . $page . '</loc><changefreq>weekly</changefreq><priority>' . ($page === '' ? '1.0' : '0.8') . '</priority></url>';
    }
    
    foreach ($posts as $post) {
        $identifier = $post->slug ?: $post->id;
        $lastmod = $post->updated_at ? $post->updated_at->toAtomString() : ($post->published_at ? $post->published_at->toAtomString() : $post->created_at->toAtomString());
        $xml .= '<url><loc>' . rtrim($baseUrl, '/') . '/blog/' . $identifier . '</loc><lastmod>' . $lastmod . '</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>';
    }
    
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'text/xml');
});
