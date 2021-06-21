<?php

namespace App\Http\Controllers\Home;

use Toastr;
use App\Post;
use App\Lesson;
use App\Comment;
use App\Category;
use Carbon\Carbon;
use App\AdobeGroup;
use App\AdobeUsers;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Services\AdobeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Artesaos\SEOTools\Facades\TwitterCard;
use Morilog\Jalali\Jalalian;

class PostController extends Controller
{

    public function getChildComments($collection)
    {

        foreach ($collection as $item) {

            $commentsArray[] = $item;
            if (count(Comment::where(['parent_id' => $item, 'approved' => 1])->get())) {

                $this->getChildComments(Comment::where(['parent_id' => $item, 'approved' => 1])->get());
            }
        }

        return $commentsArray;
    }

    public function show($slug = null)
    {

        //         dd($slug);
        $data['post'] = Post::whereSlug($slug)->first();
        if (!$data['post']) abort(404);
        $data['post']->increment('views');
        $data['related_posts'] = Post::where('post_type', $data['post']->post_type)
            ->where('start_date', '>=', Carbon::now())
            ->where('id', '!=', $data['post']->id)
            ->latest()->take(8)->get();



        $parents = $data['post']->comments()->where(['parent_id' => 0, 'approved' => 1])->get();
        $col = new Collection();
        foreach ($parents as $key => $parent) {
            $col->push($parent);
            foreach (Comment::where(['parent_id' => $parent->id, 'approved' => 1])->latest()->get() as $key => $value) {
                $col->push($value);
            }
        }

        $data['comments'] =  $col->paginate(6);




        $data['title'] = 'تکوان | ' . $data['post']->title;
        /* Seo Tools */
        SEOMeta::setTitle($data['post']->seo_title);
        SEOMeta::setDescription($data['post']->seo_description);
        SEOMeta::setCanonical($data['post']->seo_canonical);
        OpenGraph::setTitle($data['post']->seo_title);
        OpenGraph::setDescription($data['post']->seo_description);
        OpenGraph::setUrl($data['post']->seo_canonical);
        OpenGraph::addImage(asset($data['post']->picture));
        TwitterCard::setTitle($data['post']->seo_title);
        TwitterCard::setDescription($data['post']->seo_description);
        TwitterCard::setUrl($data['post']->seo_canonical);
        TwitterCard::addImage(asset($data['post']->picture));

        return view('home.' . $data['post']->post_type, $data);
    }

    public function posts(Request $request, $category = null)
    {

        if (\Request::path() == 'courses') {
            $page_title =  'تکوان | دوره ها';
            $title = 'دوره';
            $post_type = 'course';
            $data['latest_posts'] = Post::where('post_type', $post_type)->where('private', 0)->latest()->take(5)->get();
            $paginate = Post::COURSES_COUNT;
        } elseif (\Request::path() == 'podcasts') {
            $page_title =  'تکوان | پادکست ها';
            $title = 'پادکست';
            $post_type = 'podcast';
            $paginate = Post::PODCASTS_COUNT;
            $data['latest_posts'] = Post::where('post_type', $post_type)->latest()->take(5)->get();
        } else {
            $page_title =  'تکوان | وبینار ها';
            $post_type = 'webinar';
            $paginate = Post::WEBINARS_COUNT;
            $title = isset($request->q) && $request->q == 'archive' ? 'وبینارهای گذشته' : 'وبینار';
            $data['latest_posts'] = Post::where('post_type', $post_type)->where('start_date', '>', Carbon::now())->latest()->take(5)->get();
        }
        $seo_description = 'تکوان 24 , آموزش , امنیت , آموزش برنامه نویسی , جرم شناسی در زمینه امنیت اطلاعات , ...';

        /* Seo Tools */
        SEOMeta::setTitle($page_title);
        SEOMeta::setDescription($seo_description);
        SEOMeta::setCanonical(\Request::url());
        OpenGraph::setTitle($page_title);
        OpenGraph::setDescription($seo_description);
        OpenGraph::setUrl(\Request::url());
        OpenGraph::addImage(asset('assets/imgs/Logo.png'));
        TwitterCard::setTitle($page_title);
        TwitterCard::setDescription($seo_description);
        TwitterCard::setUrl(\Request::url());
        TwitterCard::addImage(asset('assets/imgs/Logo.png'));


        $order =  $request->order ?? 'created_at';

        $data['posts'] = Post::where(function ($q) use ($category, $post_type, $request) {

            if ($category) {
                $q->whereHas('category', function ($q) use ($category, $post_type) {
                    $q->whereSlug($category);
                });
            }
            if ($post_type == 'webinar' && isset($request->q) && $request->q == 'archive') {
                $q->where('archive', 1);
            } elseif ($post_type == 'podcast') {
            } elseif ($post_type == 'course') {
                $q->where('private', 0);
            }

            $q->where('post_type', $post_type);
        })->orderByDesc($order)->paginate($paginate);
        // dd($data);

        $data['page_title'] = $page_title;
        $data['title'] =   $title;
        $data['post_type'] = $post_type;


        if ($data['post_type'] == 'podcast') {
            //            dd(strip_tags($data['posts']->first()->description));
            return view('home.podcasts', $data);
        }

        return view('home.posts', $data);
    }
    public function courses(Request $request)
    {
        // dd($request->url());
    }
    public function podcasts(Request $request)
    {
        // dd($request->url());
        $data['title'] =   $title;
        return view('home.posts', $data);
    }

    public function play(Request $request, $slug = null)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        // $data['title'] = $request[''];

        if (isset($request->lesson) && $request->lesson) {
            $lesson = Lesson::findOrFail($request->lesson);
            if (getCurrentUser()->hasRole('admin')) {
            } else {

                if ($lesson->quiz) {
                    // check if user can view lesson
                    if (!Auth::user()->posts->contains($post->id)) abort(403);
                    // if($lesson->number !== 1) {
                    //    if($lesson->)
                    // }
                }
            }
            $data['url'] = $lesson->files->first()->file;
            $data['title'] = $lesson->title;
        } else {
            $data['url'] = $post->files->first()->file;
            $data['title'] = $post->title;
        }

        return view('home.play', $data);
    }

    public function register($slug)
    {


        $post = Post::whereSlug($slug)->first();
        if (!$post) abort(404);

        if (getCurrentUser()->posts->contains($post->id)) {

            Toastr::info('ثبت نام مجدد امکان پذیر نمیباشد', ' پیغام');
            return Redirect::route('post.show', $post->slug);
        }

        try {

            if ($post->post_type == 'webinar') {
                $name = 'وبینار';

                if (!AdobeUsers::where('user_id', getCurrentUser()->id)->first()) {
                    $adobe = new AdobeService;
                    $addedUser =  $adobe->addUserInAdobe(getCurrentUser());
                    if (!$addedUser) throw new \Exception("Oops not connected to adobe ; check internet  :/");
                    $response = json_decode(json_encode(simplexml_load_string($addedUser)), true);

                    if (is_array($response) && $response['status']['@attributes']['code'] == 'ok') {
                        $userobj = new AdobeUsers;
                        $userobj->principal_id = $response['principal']['@attributes']['principal-id'];
                        $userobj->account_id = $response['principal']['@attributes']['account-id'];
                        $userobj->user_id = getCurrentUser()->id;
                        $userobj->save();
                    } else {
                        Toastr::info('خطایی در روند ثبت نام رخ داد!', ' پیغام');
                        return Redirect::route('post.show', $post->slug);
                    }
                } else {
                    $userobj = AdobeUsers::where('user_id', getCurrentUser()->id)->first();
                }

                // dd($response);


                $group = AdobeGroup::where('post_id', $post->id)->first();
                if ($group) {
                    $adobe = new AdobeService;
                    $addedUserToGroup =  $adobe->addUserInAdobeGroup($userobj->principal_id, $group->principal_id);
                    $response = json_decode(json_encode(simplexml_load_string($addedUserToGroup)), true);
                    if ($response['status']['@attributes']['code'] == 'ok') {

                        $group->users()->attach($userobj->id);

                        getCurrentUser()->posts()->attach($post->id);

                        //------ ارسال پیامک ثبت نام در وبینار
                        // $patterncode = "q9uaxab7bs";
                        // $data = array("name" => getCurrentUser()->username, 'post-title' => $post->title);
                        // $this->sendSMS($patterncode, getCurrentUser()->mobile, $data);


                        $notification = new Notification;
                        $notification->title = 'ثبت نام در وبینار';
                        $notification->text = "کاربر عزیز 
                         شما با موفقیت در وبینار ".str_replace('وبینار','',$post->title)." ثبت نام کردید 
                         تاریخ برگزاری وبینار ".Jalalian::forge($post->start_date)->ago()." دیگر به مدت ".$post->duration." میباشد.
                         یک ساعت قبل از برگزاری وبینار از طریق پیامک به شما اطلاع رسانی خواهد شد.";
                        $notification->user_id = getCurrentUser()->id;
                        $notification->save();

                    } else {
                        throw new \Exception("User No Added To AdobeGroup :/");
                    }
                }
            } else {
                $name = 'دوره';

                getCurrentUser()->posts()->attach($post->id);

                //------ ارسال پیامک ثبت نام در دوره
                $patterncode = "ts5qit1pfb";
                $data = array("name" => getCurrentUser()->username, 'post-title' => $post->title);
                $this->sendSMS($patterncode, getCurrentUser()->mobile, $data);
            }

            Toastr::success('شما برای همیشه با این ' . $name . ' دسترسی دارید', 'موفق ');
            return Redirect::route('member.posts', ['user' => getCurrentUser()->username, 'post_type' => $post->post_type]);
        } catch (\Exception $th) {
            return $th->getMessage() . " in line: " . $th->getLine();
        }
    }
}
