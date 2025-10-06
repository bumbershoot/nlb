<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display staff management page
     */
    public function index()
    {
        // Only super admin and managers can view staff
        if (!Auth::user()->canManageStaff()) {
            abort(403, 'Access denied. You do not have permission to manage staff.');
        }

        $staff = User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = User::where('role', 'admin')
            ->where('status', 'pending')
            ->count();

        return view('admin.staff.index', compact('staff', 'pendingCount'));
    }

    /**
     * Show invite staff form
     */
    public function showInviteForm()
    {
        if (!Auth::user()->canManageStaff()) {
            abort(403, 'Access denied.');
        }

        return view('admin.staff.invite');
    }

    /**
     * Send staff invitation
     */
    public function sendInvitation(Request $request)
    {
        if (!Auth::user()->canManageStaff()) {
            abort(403, 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'admin_role' => 'required|in:manager,staff,read_only',
        ]);

        // Generate invitation token
        $token = Str::random(64);

        // Create pending user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(32)), // Temporary password
            'role' => 'admin',
            'admin_role' => $request->admin_role,
            'status' => 'pending',
            'invited_by' => Auth::user()->email,
            'invited_at' => now(),
            'remember_token' => $token, // Use remember_token for invitation
        ]);

        // Send invitation email (placeholder - you'll need to set up mail)
        try {
            // Mail::send('emails.staff-invitation', [
            //     'user' => $user,
            //     'inviter' => Auth::user(),
            //     'token' => $token,
            //     'url' => route('admin.invitation.accept', $token)
            // ], function($message) use ($user) {
            //     $message->to($user->email);
            //     $message->subject('Staff Invitation - Nur Laman Bestari Eco Resort');
            // });
        } catch (\Exception $e) {
            // Handle email error
        }

        return redirect()->route('admin.staff.index')
            ->with('success', "Invitation sent to {$request->name} ({$request->email}). They can use the registration link to complete their account setup.");
    }

    /**
     * Accept staff invitation
     */
    public function acceptInvitation($token)
    {
        $user = User::where('remember_token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['token' => 'Invalid or expired invitation token.']);
        }

        return view('admin.staff.accept-invitation', compact('user', 'token'));
    }

    /**
     * Complete invitation registration
     */
    public function completeInvitation(Request $request, $token)
    {
        $user = User::where('remember_token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['token' => 'Invalid or expired invitation token.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
            'status' => 'active',
            'remember_token' => null,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome to Nur Laman Bestari Eco Resort! Your account has been activated.');
    }

    /**
     * Update staff member
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->canManageStaff()) {
            abort(403, 'Access denied.');
        }

        $request->validate([
            'admin_role' => 'required|in:manager,staff,read_only',
            'status' => 'required|in:active,suspended',
        ]);

        // Prevent changing super admin
        if ($user->admin_role === 'super_admin') {
            return back()->withErrors(['error' => 'Cannot modify super admin account.']);
        }

        $user->update([
            'admin_role' => $request->admin_role,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Staff member updated successfully.');
    }

    /**
     * Delete staff member
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->canManageStaff()) {
            abort(403, 'Access denied.');
        }

        // Prevent deleting super admin
        if ($user->admin_role === 'super_admin') {
            return back()->withErrors(['error' => 'Cannot delete super admin account.']);
        }

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Cannot delete your own account.']);
        }

        $user->delete();

        return back()->with('success', 'Staff member removed successfully.');
    }
}