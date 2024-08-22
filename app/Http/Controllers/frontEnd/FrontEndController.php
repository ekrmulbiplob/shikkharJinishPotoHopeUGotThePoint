<?php

namespace App\Http\Controllers\frontEnd;


use Illuminate\Http\Request;
use Modules\CMS\Entities\Blog;
use Modules\CMS\Entities\Book;
use App\Models\SeoPage;
use App\Services\FrontEndService;
use App\Http\Controllers\Controller;
use Modules\CMS\Entities\BlogDetails;
use App\Http\Requests\JobApplicationRequest;
use Modules\Settings\Entities\BlogCategory;
use App\Models\User;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Artesaos\SEOTools\Facades\SEOMeta;

class FrontEndController extends Controller
{
    private $service;
    use SEOToolsTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FrontEndService $service)
    {
       $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $seo = SeoPage::where('status', '1')->first();

        $this->seo()->setTitle($seo->title);
        $this->seo()->setDescription($seo->description);
        $this->seo()->setCanonical($seo->canonical);
        SEOMeta::addKeyword(explode(',', $seo->keywords));
        SEOMeta::addMeta('article:section', $seo->section, 'property');
        $this->seo()->opengraph()->setUrl($seo->og_url);
        $this->seo()->opengraph()->addProperty('type', $seo->og_type);
        $this->seo()->opengraph()->addProperty('locale', $seo->og_locale);
        //$this->seo()->twitter()->setSite('@mekbiplob');
        $this->seo()->jsonLd()->setType($seo->og_type);


        $categories = BlogCategory::active()->pluck('name', 'id');
        $popularBlogs = $this->getPopularBlogDetailsWithFirstimage();
        $latestBlogs = $this->getLatestBlogDetailsWithFirstimage();
        $topCategories = $this->topCategoriesByViewCount();
        $latestBooks = $this->getLatestBook();

        $authors = User::with(['profile.image']) 
                ->where('role_id', 2)
                ->limit(3)
                ->get();
        //$home = BlogDetails::where('type', BlogDetails::TYPE_HOME)->select('content')->first();

        return view('frontEnd.index', compact('categories','popularBlogs', 'latestBlogs', 'authors','topCategories', 'latestBooks'));
    }

    public function getPopularBlogDetailsWithFirstimage()
    {
        return Blog::with(['user:id,name', 'details', 'details.images'])
                ->orderBy('view_count', 'desc')
                ->limit(3) 
                ->get()
                ->map(function($blog){
                    $firstImage = $blog->details->flatMap(function($detail){
                        return $detail->images;
                    })->first();

                    return [
                        'title' => $blog->title,
                        'created_by' => $blog->user->name,
                        'created_at' => $blog->created_at,
                        'details' => $blog->details->map(function($detail){
                            return $detail->details;
                        })->first(),
                        'first_image' =>  $firstImage ?  $firstImage->path : null
                    ];
                });

    }

    public function getLatestBlogDetailsWithFirstimage()
    {
        return Blog::with(['user:id,name', 'details', 'details.images'])
                ->orderBy('created_at', 'desc')
                ->limit(3) 
                ->get()
                ->map(function($blog){
                    $firstImage = $blog->details->flatMap(function($detail){
                        return $detail->images;
                    })->first();

                    return [
                        'title' => $blog->title,
                        'created_by' => $blog->user->name,
                        'created_at' => $blog->created_at,
                        'details' => $blog->details->map(function($detail){
                            return $detail->details;
                        })->first(),
                        'first_image' =>  $firstImage ?  $firstImage->path : null
                    ];
                });

    }

    public function topCategoriesByViewCount()
    {
        $topCategories = Blog::select('blog_categories.name')
            ->join('blog_categories', 'blogs.blog_category_id', '=', 'blog_categories.id')
            ->groupBy('blog_categories.id', 'blog_categories.name')
            ->orderByRaw('SUM(blogs.view_count) DESC')
            ->limit(3)
            ->pluck('blog_categories.name');

        return $topCategories;
    }

    public function getLatestBook()
    {
        return Book::orderBy('created_at', 'desc')
                ->limit(3) 
                ->get();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about(Request $request)
    {
        //$about = BlogDetails::where('type', BlogDetails::TYPE_ABOUT)->select('content')->first();
        //return view('frontEnd.about', compact('about'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact(Request $request)
    {
        $contact = BlogDetails::where('type', BlogDetails::TYPE_CONTACT)->select('content')->first();
        return view('frontEnd.contact', compact('contact'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobs(Request $request)
    {
        $jobs = $this->service->jobs($request);

        return view('frontEnd.jobs.jobs', compact('jobs'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobShow(Request $request, $id)
    {
        $job = $this->service->job($request, $id);

        return view('frontEnd.jobs.show', compact('job'));
    }

    /**
     * Apply load
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobApply(Request $request, $id)
    {
        $job = $this->service->job($request, $id);
        return view('frontEnd.jobs.apply', compact('job'));
    }

    /**
     * Apply load
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobApplyStore(JobApplicationRequest $request, $id)
    {
        if ($this->service->storeApplication($request, $id)) {

            sendActivityNotification(trans('msg.noty.created', ['model' => trans('model.job_application')]));

            return redirect()->back()->with('success', trans('msg.create_success', ['model' => trans('model.job_application')]));
        }

        return redirect()->back()->with('error', trans('msg.create_failed', ['model' => trans('model.job_application')]))->withInput();
    }


}
