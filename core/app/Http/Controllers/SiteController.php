<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\JobPost;
use App\Models\Language;
use App\Models\Page;
use App\Models\SubCategory;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller {
    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    public function index() {
        $count = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->count();

        if ($count == 0) {
            $page           = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name     = 'HOME';
            $page->slug     = 'home';
            $page->save();
        }
//         echo session('id');

// print_r(session()->all());exit;
        $country_code = session('country_code');
        $pageTitle = 'Home';
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->first();
        $categories    = Category::where('featured', 1)->orderBy('name')->with('subcategory')->get();
        $keywords      = JobPost::where('status', 1)->groupBy('category_id')->selectRaw('count(status) as count, category_id')->orderBy('count', 'desc')->take(4)->get();
// print_r($keywords);exit;
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'categories', 'keywords', 'country_code'));
    }

    public function pages($slug) {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact() {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function about() {
        $pageTitle = "About Us";
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'about-us')->first();
        return view($this->activeTemplate . 'about', compact('pageTitle', 'sections'));
    }

    public function blogs() {
        $pageTitle = "Blogs";
        $blogs = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate());
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->first();
        return view($this->activeTemplate . 'blogs', compact('pageTitle', 'sections','blogs'));
    }

    public function blogDetail($id) {
        $pageTitle = 'Blog Detail';
        $blog      = Frontend::findOrFail($id);
        $blogs     = Frontend::where('data_keys', 'blog.element')->where('id', '!=', $id)->latest()->take(5)->get();
        return view($this->activeTemplate . 'blog_detail', compact('pageTitle', 'blog', 'blogs'));
    }

    public function faq() {
        $pageTitle = "FAQ";
        return view($this->activeTemplate . 'faq', compact('pageTitle'));
    }

    public function contactSubmit(Request $request) {

        $attachments = $request->file('attachments');
        $allowedExts = ['jpg', 'png', 'jpeg', 'pdf'];

        $this->validate($request, [
            'name'    => 'required|max:191',
            'email'   => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = 2;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = 0;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                   = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message          = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);

    }

    public function changeLanguage($lang = null) {
        $language = Language::where('code', $lang)->first();

        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function cookieAccept() {
        session()->put('cookie_accepted', true);
        return response('Cookie accepted successfully');
    }

    public function placeholderImage($size = null) {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize  = round(($imgWidth - 50) / 8);

        if ($fontSize <= 9) {
            $fontSize = 9;
        }

        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function pageDetails($id, $slug) {
        $page      = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $page->data_values->title;
        return view($this->activeTemplate . 'policy_pages', compact('page', 'pageTitle'));
    }

    public function categories() {
        $pageTitle    = 'All Categories';
        $emptyMessage = 'No category found';
        $allCategory  = Category::where('featured', 1)->orderBy('name')->paginate(getPaginate());
        return view($this->activeTemplate . 'categories', compact('pageTitle', 'emptyMessage', 'allCategory'));
    }

    public function subcategories($id, $name) {
        $pageTitle     = $name;
        $emptyMessage  = 'No category found';
        $subcategories = SubCategory::where('category_id', $id)->where('status', 1)->with('category')->paginate(getPaginate());
        return view($this->activeTemplate . 'subcategories', compact('pageTitle', 'emptyMessage', 'subcategories'));
    }

    public function allJobs() {
        $pageTitle    = 'All Jobs';
        $emptyMessage = 'No job found';
        $jobs         = JobPost::where('status', 1)->latest()->paginate(getPaginate());
        $categories   = Category::where('featured', 1)->orderBy('name')->with('subcategory')->get();
        return view($this->activeTemplate . 'all_jobs', compact('pageTitle', 'emptyMessage', 'jobs', 'categories'));
    }

    public function sortAllJobs(Request $request) {

        $sort         = $request->sort;
        $date         = $request->date;
        $category_id  = $request->category_id;
        $emptyMessage = 'No job found';

        $filterJobs = $this->categoryQuery($category_id);
        $filterJobs = $this->filterJob($filterJobs, $sort, $date);
        $jobs       = $filterJobs->where('status', 1)->paginate(getPaginate());
        return view($this->activeTemplate . 'partials.jobs', compact('emptyMessage', 'jobs'));

    }

    protected function categoryQuery($category_id) {

        if ($category_id) {

            if (in_array('all', $category_id)) {
                $jobs = JobPost::query();

            } else {
                $jobs = JobPost::whereIn('category_id', $category_id);
            }

        } else {
            $jobs = JobPost::query();
        }

        return $jobs;
    }

    public function categoryJobs($id, $name) {
        $pageTitle    = $name;
        $emptyMessage = 'No job found';
        $jobs         = JobPost::where('category_id', $id)->where('status', 1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'jobs', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function subcategoryJobs($id, $name) {
        $pageTitle      = $name;
        $emptyMessage   = 'No job found';
        $subcategory_id = $id;
        $jobs           = JobPost::where('subcategory_id', $id)->where('status', 1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'jobs', compact('pageTitle', 'emptyMessage', 'jobs', 'subcategory_id'));
    }

    public function sortSubCateJobs(Request $request) {
        $emptyMessage   = 'No job found';
        $sort           = $request->sort;
        $date           = $request->date;
        $subcategory_id = $request->subcategory_id;
        $filterJobs     = JobPost::where('subcategory_id', $subcategory_id)->where('status', 1);
        $filterJobs     = $this->filterJob($filterJobs, $sort, $date);

        $jobs = $filterJobs->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'partials.jobs', compact('emptyMessage', 'jobs'));

    }

    public function jobSearch(Request $request) {
        $emptyMessage = 'No job found';
        $search       = $request->search;
        $category     = $request->category;
        $jobs         = JobPost::where('status', 1);

        $jobs = $this->searchQuery($category, $search, $jobs);

        $jobs      = $jobs->latest()->paginate(getPaginate());
        $pageTitle = 'Your Search Job';

        return view($this->activeTemplate . 'search_jobs', compact('pageTitle', 'emptyMessage', 'jobs', 'category', 'search'));
    }

    public function sortSearchJobs(Request $request) {
        $emptyMessage = 'No job found';
        $search       = $request->search;
        $category     = $request->category;
        $sort         = $request->sort;
        $date         = $request->date;
        $filterJobs   = JobPost::where('status', 1);

        $filterJobs = $this->searchQuery($category, $search, $filterJobs);

        $filterJobs = $this->filterJob($filterJobs, $sort, $date);

        $jobs = $filterJobs->latest()->paginate(1);
        return view($this->activeTemplate . 'partials.jobs', compact('emptyMessage', 'jobs'));
    }

    protected function searchQuery($category, $search, $jobs) {

        if ($category) {
            $jobs = $jobs->where('category_id', $category);
        }

        if ($search) {
            $jobs = $jobs->where(function ($q) use ($search) {
                $q->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', '%' . $search . '%');
            });
        }

        return $jobs;
    }

    protected function filterJob($jobs, $sort, $date) {

        if ($sort == 'low_to_high') {

            $jobs = $jobs->orderBy('rate', 'asc');

        }

        if ($sort == 'high_to_low') {

            $jobs = $jobs->orderBy('rate', 'desc');

        }

        if ($date == 'today') {

            $jobs = $jobs->whereDate('created_at', Carbon::today());
        }

        if ($date == 'weekly') {
            $jobs = $jobs->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }

        if ($date == 'monthly') {
            $jobs = $jobs->whereMonth('created_at', Carbon::now()->month);
        }

        return $jobs;
    }

    public function jobDetail($id, $title) {
        $pageTitle = 'Job Details';
        $job       = JobPost::where('id', $id)->with('user')->first();
        // print_r($job);exit;
        return view($this->activeTemplate . 'job_details', compact('pageTitle', 'job'));
    }

}
