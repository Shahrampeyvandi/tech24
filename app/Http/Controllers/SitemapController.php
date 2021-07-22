<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = app()->make('sitemap');

        $sitemap->add(URL::to('/sitemap-courses'), now(), '1.0', 'daily');
        $sitemap->add(URL::to('/sitemap-webinars'), now(), '1.0', 'daily');
        $sitemap->add(URL::to('/sitemap-podcasts'), now(), '1.0', 'daily');
        $sitemap->add(URL::to('/sitemap-blogs'), now(), '1.0', 'daily');
        return $sitemap->render('xml');
    }

    public function courses()
    {
        $sitemap = app()->make('sitemap');

        $courses = Post::where('post_type', 'course')->latest()->get();
        foreach ($courses as $key => $course) {

            $sitemap->add(URL::to($course->slug), $course->created_at, '1.0', 'weekly');
        }

        return $sitemap->render('xml');
    }
    
    public function webinars()
    {
        $sitemap = app()->make('sitemap');

        $courses = Post::where('post_type', 'webinar')->latest()->get();
        foreach ($courses as $key => $course) {

            $sitemap->add(URL::to($course->slug), $course->created_at, '1.0', 'weekly');
        }

        return $sitemap->render('xml');
    }

    public function podcasts()
    {
        $sitemap = app()->make('sitemap');

        $courses = Post::where('post_type', 'podcast')->latest()->get();
        foreach ($courses as $key => $course) {

            $sitemap->add(URL::to($course->slug), $course->created_at, '1.0', 'weekly');
        }

        return $sitemap->render('xml');
    }

    public function blogs()
    {
        $sitemap = app()->make('sitemap');

        $courses = Blog::latest()->get();
        foreach ($courses as $key => $course) {

            $sitemap->add('blog/' . URL::to($course->slug), $course->created_at, '1.0', 'weekly');
        }

        return $sitemap->render('xml');
    }
}
