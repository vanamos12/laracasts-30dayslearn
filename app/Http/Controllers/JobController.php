<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    //

    public function index(){
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view("jobs.index", [
            'jobs' => $jobs
        ]);
    }

    public function create(){
        return view('jobs.create');
    }

    public function show(Job $job){
        return view("jobs.show", ['job' => $job]);
    }

    public function store(){
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
         ]);
    
         $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1 
         ]);

         Mail::to($job->employer->user)->queue(new JobPosted($job));
    
         return redirect('/jobs');
    }

    public function edit(Job $job){

        //if (Auth::guest()){
        //    return redirect('/login');
        //}

        //if ($job->employer->user->isNot(Auth::user())){
        //    abort(403);
        //}

        //Gate::authorize('edit-job', $job);

        return view("jobs.edit", [
            'job' => $job
        ]);
    }

    public function update(Job $job){

        // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);


    // authorize (On hold...)
    Gate::authorize('edit-job', $job);
    // update the job
    //$job = Job::findOrFail($id);

    //$job->title = request('title');
    //$job->salary = request('salary');
    //$job->save();

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);

    // and persist

    // redirect to the job page
    return redirect("/jobs/". $job->id);
    }

    public function destroy(Job $job){
        // authorize the request On hold ...
        Gate::authorize('edit-job', $job);
        // delete the job

        //$job = Job::findOrFail($id);
        $job->delete();

        // redirect
        return redirect('/jobs');
    }
}
