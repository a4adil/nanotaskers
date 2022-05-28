<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\File;
use App\Models\Continent;
use App\Models\Countries;
use App\Models\GeneralSetting;
use App\Models\JobPost;
use App\Models\CategorySubcategories;
use App\Models\ContinentCountries;
use App\Models\JobProve;
use App\Models\Transaction;
use App\Models\PostsSteps;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JobPostController extends Controller {
    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    public function create() {
        $pageTitle  = 'Create New Job';
        $categories = Category::where('featured', 1)->orderBy('name')->with('subcategory')->get();
        $files = File::where('status', 1)->get();
        $continents = Continent::get();
        $countries = Countries::where('continent_code', 'AS')->get();
        $subcategories = SubCategory::where('category_id', 17)->get();
        // print_r($continents);exit;
        return view($this->activeTemplate . 'user.job.create', compact('pageTitle', 'categories', 'files', 'continents', 'countries', 'subcategories'));
    }
    
    public function getcountry(Request $request) {
        
        $continent_code = $request->post('code');
        return $countries = Countries::where('continent_code', $continent_code)->orderBy('name', 'ASC')->get();
        
    }
    
    public function getcategory(Request $request) {
        
        $subcategory = $request->post('subcategory');
        return $subcategory = SubCategory::where('id', $subcategory)->limit(1)->first();
        
    }
    
    public function getsubcategory(Request $request) {
        
        $continent_code = $request->post('id');
        return $countries = SubCategory::where('category_id', $continent_code)->orderBy('name', 'ASC')->get();
        
    }

    public function store(Request $request) {
        dd($request->all());
        $request->validate([
            
            'quantity'    => 'required|integer|gt:0',
            'rate'        => 'required|numeric|gt:0',
            'title'       => 'required|string|max:255',
            'attachment'  => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'description' => 'required',
            'speed'       => 'required'  

        ]);

        $filename = '';

        if ($request->job_proof == 2) {
            $file = File::where('status', 1)->whereIn('name', $request->file_name)->count();

            if ($file != count($request->file_name)) {
                $notify[] = ['error', 'Job proof file name is wrong'];
                return back()->withNotify($notify)->withInput();
            }

            $filename = implode(',', $request->file_name);

        }

        $general        = GeneralSetting::first();
        $user           = auth()->user();
        $oldPostBalance = JobPost::where('user_id', $user->id)->where('status', [0, 1])->sum('due_amount');

        $restBalance = $user->balance - $oldPostBalance;
        $totalBudget = $request->quantity * $request->rate;

        if ($totalBudget > $restBalance) {
            $notify[] = ['error', 'You have no sufficient balance.'];
            return back()->withNotify($notify)->withInput();
        }

        $path = imagePath()['job']['attachment']['path'];
        $size = imagePath()['job']['attachment']['size'];
        $job  = new JobPost();
        $ContinentCountries  = new ContinentCountries();
        $CategorySubcategories  = new CategorySubcategories();

        if ($request->hasFile('attachment')) {

            try {
                $job->attachment = uploadImage($request->attachment, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }

        }
// print_r($request->continent);exit;
        $job->user_id           = $user->id;
        $job->category_id       = $request->category_id;
        $job->subcategory_id    = $request->subcategory;
        $job->job_proof         = $request->job_proof;
        $job->file_name         = $filename;
        $job->quantity          = $request->quantity;
        $job->vacancy_available = $request->quantity;
        $job->rate              = $request->rate;
        $job->total             = $totalBudget;
        $job->due_amount        = $totalBudget;
        $job->title             = $request->title;
        $job->description       = $request->description;
        $job->status            = $general->approve_job ?? 0;
        
        $job->additional_note       = $request->additional_note;
        $job->step1_proof       = $request->step1_proof;
        $job->step2_proof       = $request->step2_proof;
        $job->step3_proof       = $request->step3_proof;
        $job->step4_proof       = $request->step4_proof;
        $job->job_proof1       = $request->job_proof1;
        $job->job_proof2       = $request->job_proof2;
        $job->job_proof3       = $request->job_proof3;
        $job->job_proof4       = $request->job_proof4;
        $job->question1       = $request->question1;
        $job->question2       = $request->question2;
        $job->question3       = $request->question3;
        $job->answer1       = $request->answer1;
        $job->answer2       = $request->answer2;
        $job->answer3       = $request->answer3;
        $job->level       = $request->level;
        $job->speed       = $request->speed;
        $job->hold_job_time       = $request->hold_job_time;
        $job->workers_needed       = $request->workers_needed;
        $job->continent       = $request->continent;
        $job->promotion       = $request->promotion;
        $job->total_budget       = $request->total_budget;
        $job->job_code          = getTrx();
        $job->save();
        $job->id;
        
        foreach($request->input('country') as $key => $value) 
        {
            ContinentCountries::create([
    		'country' => $request->input('country')[$key],
    		'post_id' => $job->id,
    		'continent_code' => $request->continent,
    		
    	    ]);
        }
        
    //     foreach($request->input('step') as $key => $value) 
    //     {
    //         PostsSteps::create([
    // 		'step' => $request->input('step')[$key],
    // 		'post_id' => $job->id,
    // 	    ]);
    //     }
        
        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'Money has been deducted for job posting';
        $adminNotification->click_url = urlPath('admin.jobs.index');
        $adminNotification->save();

        notify($user, 'JOB_POST_SUCCESSFULLY', [
            'method_name' => 'Job post',
            'currency'    => $general->cur_text,
            'quantity'    => showAmount($request->quantity),
            'amount'      => showAmount($job->rate),
            'charge'      => showAmount($totalBudget),
            'job_code'    => $job->job_code,
            'name'        => $user->name,
        ]);

        $notify[] = ['success', 'Job created successfully'];
        return redirect()->route('user.job.history')->withNotify($notify);
    }

    public function edit($id) {
        $pageTitle  = 'Edit Job';
        $job        = JobPost::findOrFail($id);
        $categories = Category::where('featured', 1)->orderBy('name')->with('subcategory')->get();
        $continents = Continent::get();
        $countries = Countries::where('continent_code', $job->continent)->get();
        $ContinentCountries = ContinentCountries::where('post_id', $id)->get();
        $PostsSteps = PostsSteps::where('post_id', $id)->get();
        $subcategories = SubCategory::where('category_id', $job->category_id)->get();
        
        $files      = File::where('status', 1)->get();
        return view($this->activeTemplate . 'user.job.edit', compact('pageTitle', 'job', 'categories', 'files', 'continents', 'countries', 'subcategories', 'ContinentCountries', 'PostsSteps'));

    }

    public function update(Request $request, $id) {

        $request->validate([
            
            'quantity'    => 'required|integer|gt:0',
            'rate'        => 'required|numeric|gt:0',
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'speed' => 'required',
            
        ]);
        $general = GeneralSetting::first();
        $user    = auth()->user();
        $job     = JobPost::where('id', $id)->where('user_id', $user->id)->first();

        if ($job->status == 2 || $job->status == 9 || $job->status == 3) {
            $notify[] = ['error', 'Sorry! your job will not editable'];
            return back()->withNotify($notify)->withInput();
        }

        $attachment = $job->attachment;
        $totalBudget = 0;
        if ($job->status == 0) {

            if (!($job->quantity == $request->quantity && $job->rate == $request->rate)) {

                $oldPostBalance = JobPost::where('id', '!=', $job->id)->where('user_id', $user->id)->where('status', [0, 1])->sum('due_amount');

                $dueBalance  = $user->balance - $oldPostBalance;
                $totalBudget = $request->quantity * $request->rate;

                if ($totalBudget > $dueBalance) {
                    $notify[] = ['error', 'You have no sufficient balance in account'];
                    return back()->withNotify($notify)->withInput();
                }

                $job->quantity   = $request->quantity;
                $job->rate       = $request->rate;
                $job->total      = $totalBudget;
                $job->due_amount = $totalBudget;
            }

        }

        $filename = '';

        if ($request->job_proof == 2) {
            $file = File::where('status', 1)->whereIn('name', $request->file_name)->count();

            if ($file != count($request->file_name)) {
                $notify[] = ['error', 'Job proof file name is wrong'];
                return back()->withNotify($notify)->withInput();
            }

            $filename = implode(',', $request->file_name);

        }

        $path = imagePath()['job']['attachment']['path'];
        $size = imagePath()['job']['attachment']['size'];

        // if ($request->hasFile('attachment')) {
        //     try {
        //         $attachment = uploadImage($request->attachment, $path, $size, $job->attachment);
        //     } catch (\Exception $exp) {
        //         $notify[] = ['error', 'Image could not be uploaded.'];
        //         return back()->withNotify($notify);
        //     }

        // }

        $job->user_id           = $user->id;
        $job->category_id       = $request->category_id;
        $job->subcategory_id    = $request->subcategory;
        $job->job_proof         = $request->job_proof;
        $job->file_name         = $filename;
        $job->quantity          = $request->quantity;
        $job->vacancy_available = $request->quantity;
        $job->rate              = $request->rate;
        $job->total             = $totalBudget;
        $job->due_amount        = $totalBudget;
        $job->title             = $request->title;
        $job->description       = $request->description;
        $job->status            = $general->approve_job ?? 0;
        $job->step1       = $request->step1;
        $job->step2       = $request->step2;
        $job->step3       = $request->step3;
        $job->additional_note       = $request->additional_note;
        $job->step1_proof       = $request->step1_proof;
        $job->step2_proof       = $request->step2_proof;
        $job->step3_proof       = $request->step3_proof;
        $job->step4_proof       = $request->step4_proof;
        $job->job_proof1       = $request->job_proof1;
        $job->job_proof2       = $request->job_proof2;
        $job->job_proof3       = $request->job_proof3;
        $job->job_proof4       = $request->job_proof4;
        $job->question1       = $request->question1;
        $job->question2       = $request->question2;
        $job->question3       = $request->question3;
        $job->answer1       = $request->answer1;
        $job->answer2       = $request->answer2;
        $job->answer3       = $request->answer3;
        $job->level       = $request->level;
        $job->speed       = $request->speed;
        $job->hold_job_time       = $request->hold_job_time;
        $job->workers_needed       = $request->workers_needed;
        $job->continent       = $request->continent;
        $job->promotion       = $request->promotion;
        $job->total_budget       = $request->total_budget;
        // dd([$request->speed, $job]);
        $job->save();

        $res=ContinentCountries::where('post_id',$id)->delete();
        $res=PostsSteps::where('post_id',$id)->delete();


        foreach($request->input('country') as $key => $value) 
        {
            ContinentCountries::create([
    		'country' => $request->input('country')[$key],
    		'post_id' => $job->id,
    		'continent_code' => $request->continent,
    		
    	    ]);
        }
        
    //     foreach($request->input('step') as $key => $value) 
    //     {
    //         PostsSteps::create([
    // 		'step' => $request->input('step')[$key],
    // 		'post_id' => $job->id,
    // 	    ]);
    //     }

        $notify[] = ['success', 'Job updated successfully'];
        return redirect()->route('user.job.history')->withNotify($notify);

    }

    public function history() {
        $pageTitle    = 'My job post history';
        $emptyMessage = 'No job post found';
        $jobs         = JobPost::where('user_id', Auth::id())->with('proofNotification')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.job.history', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function applyJobs() {
        $pageTitle    = 'Apply Jobs';
        $emptyMessage = 'No job found';
        $jobs         = JobProve::where('user_id', Auth::id())->with('job.user')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.job.apply', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function jobSubmit(Request $request, $id) {
        $request->validate([
            'detail' => 'required',
        ]);
        $user       = auth()->user();
        $job        = JobPost::where('user_id', '!=', $user->id)->where('id', $id)->first();
        $oldRequest = JobProve::where('job_id', $job->id)->where('user_id', $user->id)->first();

        if ($oldRequest) {
            $notify[] = ['error', 'You\'ve already submitted'];
            return back()->withNotify($notify)->withInput();
        }

        $attachment = '';

        if ($job->job_proof == 2) {

            if (!$request->hasFile('attachment')) {
                $notify[] = ['error', 'Job proof attachment is required'];
                return back()->withNotify($notify)->withInput();
            }

            $extension = $request->attachment->getClientOriginalExtension();

            $filename = explode(",", $job->file_name);
            $result   = in_array($extension, $filename, true);

            if (!$result) {
                $notify[] = ['error', 'Job proof attachment will be ' . implode(",", $filename)];
                return back()->withNotify($notify)->withInput();
            }

            $path = imagePath()['job']['proof']['path'];
            try {
                $attachment = uploadFile($request->attachment, $path);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload your file'];
                return back()->withNotify($notify);
            }

        }

        $proof             = new JobProve();
        $proof->user_id    = $user->id;
        $proof->job_id     = $job->id;
        $proof->detail     = $request->detail;
        $proof->attachment = $attachment;
        $proof->save();

        if ($job->vacancy_available <= 0) {
            $notify[] = ['error', 'job already finished'];
            return back()->withNotify($notify);
        }

        $job->decrement('vacancy_available', 1);
        $job->save();

        if ($job->vacancy_available == 0) {
            $job->status = 2;
            $job->save();
        }

        $general = GeneralSetting::first();
        notify($user, 'JOB_PROOF', [
            'method_name' => 'Job proof request',
            'charge'      => showAmount($job->rate),
            'currency'    => $general->cur_text,
            'trx'         => $job->job_code,
        ]);

        $notify[] = ['success', 'Your job proof request has been taken.'];
        return back()->withNotify($notify);
    }

    public function detail($id) {
        $pageTitle    = 'Job Request Detail';
        $emptyMessage = 'No request found';
        $job          = JobPost::where('id', $id)->with('proof.user')->first();
        return view($this->activeTemplate . 'user.job.detail', compact('pageTitle', 'emptyMessage', 'job'));

    }

    public function detailAttachment($id) {
        $pageTitle           = 'Job Details';
        $emptyMessage        = 'No data found';
        $proof               = JobProve::where('id', $id)->with('user', 'job')->first();
        $proof->notification = 1;
        $proof->save();
        return view($this->activeTemplate . 'user.job.attachment', compact('pageTitle', 'emptyMessage', 'proof'));
    }

    public function downloadAttachment($id) {

        $attachment = JobProve::findOrFail($id);
        $file       = $attachment->attachment;
        $path       = imagePath()['job']['proof']['path'];
        $full_path  = $path . '/' . $file;
        return response()->download($full_path);
    }

    public function approve(Request $request) {
        $request->validate([
            'id'     => 'required',
            'amount' => 'required|numeric|gt:0',
        ]);

        $user = auth()->user();

        $jobProof = JobProve::where('id', $request->id)->with('job', 'user')->where('status', 0)->first();

        if (!$jobProof) {
            $notify[] = ['error', 'Job request already approved'];
            return back()->withNotify($notify);
        }

        $job = $jobProof->job;

        $amount = $job->rate;

        if ($user->balance < $amount) {
            $notify[] = ['error', 'You have no sufficient balance in account.'];
            return back()->withNotify($notify);
        }

        $job->decrement('due_amount', $amount);
        $job->save();

        if ($job->vacancy_available == 0) {
            $job->status = 2;
            $job->save();
        }

        $freelancer = $jobProof->user;
        $freelancer->balance += $amount;
        $freelancer->save();

        $user->balance -= $amount;
        $user->save();

        $jobProof->status = 1;
        $jobProof->save();

        // freelancer
        $transaction               = new Transaction();
        $transaction->user_id      = $freelancer->id;
        $transaction->amount       = $jobProof->job->rate;
        $transaction->post_balance = $freelancer->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Payment By ' . $user->username;
        $transaction->trx          = $jobProof->job->job_code;
        $transaction->save();

        // Job holder
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $jobProof->job->rate;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Job approved charge';
        $transaction->trx          = $jobProof->job->job_code;
        $transaction->save();

        $general = GeneralSetting::first();
        notify($freelancer, 'JOB_APPROVE_SUCCESSFULLY', [
            'payment_by'   => $user->username,
            'currency'     => $general->cur_text,
            'job_code'       => $jobProof->job->job_code,
            'amount'       => showAmount($job->rate),
            'post_balance' => showAmount($freelancer->balance),
        ]);

        $notify[] = ['success', 'Job request approved successfully'];
        return redirect()->route('user.job.detail', $job->id)->withNotify($notify);
    }

    public function reject(Request $request) {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $user      = auth()->user();
        $submitJob = JobProve::where('id', $request->id)->with('job','user')->first();
        $job       = JobPost::where('user_id', $user->id)->where('id', $submitJob->job_id)->first();

        if (!$job) {
            $notify[] = ['error', 'Job not found!'];
            return back()->withNotify($notify);
        }

        $submitJob->status = 3;
        $submitJob->save();
        $job->increment('vacancy_available', 1);
        $job->status = 1;
        $job->save();

        $general = GeneralSetting::first();
        notify($submitJob->user, 'JOB_REJECTED', [
            'posted_by'   => $user->username,
            'amount'      => showAmount($job->rate),
            'currency'    => $general->cur_text,
            'job_code'       => $job->job_code,
        ]);


        $notify[] = ['success', 'Job rejected successfully'];
        return back()->withNotify($notify);
    }

    public function finishedJob() {
        $pageTitle    = 'Earning Job History';
        $emptyMessage = 'No job found';
        $jobs         = JobProve::where('user_id', Auth::id())->where('status', 1)->with('job')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.job.finished', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function status(Request $request, $id, $status) {
        $user = auth()->user();

        if ($status == 2 || $status == 9) {
            $notify[] = ['success', 'Job status wrong'];
            return back()->withNotify($notify);
        }

        $job         = JobPost::where('user_id', $user->id)->where('id', $id)->first();
        $job->status = ($status == 1 || $status == 0) ? 3 : 0;
        $job->save();
        $notify[] = ['success', 'Job status updated successfully'];
        return back()->withNotify($notify);
    }

}
