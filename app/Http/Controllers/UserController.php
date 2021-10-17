<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validData = $request->validate([
            'dark_theme' => 'boolean'
        ]);

        /** @var User $user  */
        $user = auth()->user();

        $user->update($validData);

        return response(status: 204);
    }
}
