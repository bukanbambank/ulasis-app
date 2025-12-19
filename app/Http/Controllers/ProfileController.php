<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update Restaurant Details
        if ($user->restaurant) {
            $user->restaurant->update([
                'name' => $request->restaurant_name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($user->restaurant->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->restaurant->logo)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->restaurant->logo);
                }

                $file = $request->file('logo');
                $filename = 'logos/' . time() . '_' . $file->hashName();

                // Intervention Image v3 Resizing
                // Note: Ensure gd extension is enabled. If not, fallback to store()
                try {
                    if (class_exists(\Intervention\Image\ImageManager::class)) {
                        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                        $image = $manager->read($file);
                        $image->scale(width: 300); // Resize to max width 300

                        // Save to public storage
                        $path = storage_path('app/public/' . $filename);
                        // Ensure directory exists
                        if (!file_exists(dirname($path)))
                            mkdir(dirname($path), 0755, true);

                        $image->save($path);
                        $user->restaurant->update(['logo' => $filename]);
                    } else {
                        // Fallback
                        $path = $file->store('logos', 'public');
                        $user->restaurant->update(['logo' => $path]);
                    }
                } catch (\Exception $e) {
                    // Fallback in case of driver error
                    $path = $file->store('logos', 'public');
                    $user->restaurant->update(['logo' => $path]);
                }
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
