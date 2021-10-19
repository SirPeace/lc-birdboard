<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $projects = $user->allProjects();

        return view('projects.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Projects\ProjectStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $project = $user->projects()->create($request->validated());

        if ($request->wantsJson()) {
            return response()->jsonSuccess(['path' => $project->path()]);
        }

        return redirect($project->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project->load(['tasks']);

        return view('projects.show', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Projects\ProjectUpdateRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        if ($request->wantsJson()) {
            return response()->jsonSuccess();
        }

        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/projects');
    }
}
