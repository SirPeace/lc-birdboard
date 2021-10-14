<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectInvitationsRequest;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectInvitationsController extends Controller
{
    /**
     * Add a member to the project
     *
     * @param Project $project
     * @param StoreProjectInvitationsRequest $request
     * @return Response
     */
    public function store(Project $project, StoreProjectInvitationsRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
