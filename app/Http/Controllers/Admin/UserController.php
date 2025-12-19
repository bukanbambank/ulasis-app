<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('restaurant'); // Eager load restaurant details
        return view('admin.users.show', compact('user'));
    }

    public function suspend(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot suspend yourself.');
        }

        if ($user->is_admin) {
            return back()->with('error', 'You cannot suspend another admin.');
        }

        $user->update(['status' => 'suspended']);

        // Log Action
        AuditLog::create([
            'admin_id' => Auth::id(),
            'action' => 'suspend_user',
            'target_id' => $user->id,
            'details' => 'Suspended user: ' . $user->email,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'User suspended successfully.');
    }

    public function activate(Request $request, User $user)
    {
        $user->update(['status' => 'active']);

        // Log Action
        AuditLog::create([
            'admin_id' => Auth::id(),
            'action' => 'activate_user',
            'target_id' => $user->id,
            'details' => 'Activated user: ' . $user->email,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'User activated successfully.');
    }
}
