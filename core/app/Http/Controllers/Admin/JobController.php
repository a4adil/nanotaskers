<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller {
    public function index(Request $request) {
        $pageTitle    = 'All Jobs';
        $emptyMessage = 'No job found';
        $jobs         = $this->getJobs();
        return view('admin.jobs.index', compact('pageTitle', 'emptyMessage', 'jobs'));

    }

    public function pendingJobs(Request $request) {
        $pageTitle    = 'All Pending Jobs';
        $emptyMessage = 'No job found';
        $jobs         = $this->getJobs('pending');
        return view('admin.jobs.index', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function approveJobs(Request $request) {
        $pageTitle    = 'All Approve Jobs';
        $emptyMessage = 'No job found';
        $jobs         = $this->getJobs('approved');
        return view('admin.jobs.index', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function completeJobs(Request $request) {
        $pageTitle    = 'All Complete Jobs';
        $emptyMessage = 'No job found';
        $jobs         = $this->getJobs('completed');
        return view('admin.jobs.index', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function rejectedJobs(Request $request) {
        $pageTitle    = 'All Rejected Jobs';
        $emptyMessage = 'No job found';
        $jobs         = $this->getJobs('rejected');
        return view('admin.jobs.index', compact('pageTitle', 'emptyMessage', 'jobs'));
    }

    public function requestJobs(Request $request) {
        $request->validate([
            'id'      => 'required',
            'status'  => 'required|in:1,9',
            'user_id' => 'required|integer',
        ]);
        $job         = JobPost::where('id', $request->id)->where('user_id', $request->user_id)->with('user')->first();
        $job->status = $request->status;
        $job->save();

        if ($request->status == 1) {
            $notify[] = ['success', 'Job approved successfully'];
        } else {
            $notify[] = ['success', 'Job rejected successfully'];
        }

        $user    = $job->user;
        $general = GeneralSetting::first();
        if ($request->status == 1) {
            $notify[] = ['success', 'Job approved successfully'];
            notify($user, 'ADMIN_JOB_APPROVE', [
                'posted_by'   => $user->username,
                'currency'    => $general->cur_text,
                'job_code'    => $job->job_code,
                'quantity'    => $job->quantity,
                'amount'      => showAmount($job->rate),
                'total'       => showAmount($job->total),
            ]);
        } else {
            $notify[] = ['success', 'Job rejected successfully'];
            notify($user, 'ADMIN_JOB_REJECT', [
                'posted_by'   => $user->username,
                'currency'    => $general->cur_text,
                'job_code'    => $job->job_code,
                'quantity'    => $job->quantity,
                'amount'      => showAmount($job->rate),
                'total'       => showAmount($job->total),
            ]);
        }

        return back()->withNotify($notify);
    }

    private function getJobs($scope = null) {

        if (!$scope) {
            $jobs = JobPost::query();
        } else {
            $jobs = JobPost::$scope();
        }

        if (request()->search) {
            $jobs->where('job_code', request()->search);
        }

        return $jobs->with('user')->latest()->paginate(getPaginate());
    }

    public function detail($id) {
        $pageTitle    = 'Job Request Detail';
        $emptyMessage = 'No request found';
        $job          = JobPost::where('id', $id)->with('proof.user')->first();
        return view('admin.jobs.detail', compact('pageTitle', 'emptyMessage', 'job'));
    }

    public function view($id) {
        $pageTitle = 'Job Information';
        $job       = JobPost::where('id', $id)->with('user')->first();
        return view('admin.jobs.view', compact('pageTitle', 'job'));
    }

}
