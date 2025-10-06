<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'adresse')->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }
    public function show(User $user)
    {
        // return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // si tu veux pouvoir modifier le rôle

        return inertia('Admin/Users/Edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image',
            'role_id' => 'required|integer',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profil_pic', 'public');
            $user->photo = $path;
        }

        $user->update($request->except('photo'));

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }
    public function destroy(User $user)
    {
        // Si tu veux supprimer aussi la photo du profil :
        if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
            \Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

}
