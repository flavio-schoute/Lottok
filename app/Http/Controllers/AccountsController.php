<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        //Retrieves users from database
        $users = User::query()
            ->select()
            ->orderBy('is_admin', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
        //Teruns to page with users data
        return view('admin.accounts.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        //Finds user id from person you want to edit
        $user = User::findOrFail($id);
        //Returns to view with data
        return view('admin.accounts.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, int $id): RedirectResponse
    {
        // Finds the id from that user that you want to delete
        $user = User::findOrFail($id);
        //Validates the data that comes from view
        $userValidation = $request->safe()->only('first_name', 'last_name', 'email', 'birth_date', 'is_admin');
        //Updates the user
        $user->update($userValidation);
        //Redirects to page with message
        return redirect()->route('admin.accounts.index')->with('success', 'Account gewijzigd!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Finds the id from that user that you want to delete
        $user = User::whereId($id)->delete();

        // Redirects the user with message the user is deleted
        return redirect()->back()->with('success','De gebruiker is verwijderd');
    }
}
