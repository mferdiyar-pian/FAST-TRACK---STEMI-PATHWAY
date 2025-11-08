<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Setting;
use App\Models\User;
use App\Models\CodeStemi;


/**
 * @method \Illuminate\Http\RedirectResponse updateProfile(\Illuminate\Http\Request $request)
 * @method \Illuminate\Http\RedirectResponse updatePassword(\Illuminate\Http\Request $request)
 * @method \Illuminate\Http\RedirectResponse updateNotifications(\Illuminate\Http\Request $request)
 * @method \Illuminate\Http\RedirectResponse updateProfilePhoto(\Illuminate\Http\Request $request)
 * @method \Illuminate\Http\RedirectResponse removeProfilePhoto(\Illuminate\Http\Request $request)
 */

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua settings user
        $settings = $user->settings->pluck('value', 'key')->toArray();
        
        return view('setting.index', compact('user', 'settings'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone_number' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:100',
            'hospital' => 'nullable|string|max:255',
        ]);

        try {
            // Update user data menggunakan save() method
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone_number = $validated['phone_number'] ?? null;
            $user->save();

            // Simpan settings lainnya
            Setting::updateOrCreate(
                ['user_id' => $user->id, 'key' => 'role'],
                ['value' => $validated['role'] ?? '']
            );
            
            Setting::updateOrCreate(
                ['user_id' => $user->id, 'key' => 'hospital'],
                ['value' => $validated['hospital'] ?? '']
            );

            return redirect()->route('setting.index')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        try {
            // Update password menggunakan save() method
            $user->password = Hash::make($validated['new_password']);
            $user->save();

            return redirect()->route('setting.index')->with('success', 'Password updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Password update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update password: ' . $e->getMessage());
        }
    }

    public function updateUsername(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validateWithBag('updateUsername', [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        try {
            $user->username = $validated['username'];
            $user->save();

            return redirect()->route('setting.index')->with('success', 'Username updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Username update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update username: ' . $e->getMessage())->withErrors([], 'updateUsername');
        }
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        try {
            // Simpan notification settings
            Setting::updateOrCreate(
                ['user_id' => $user->id, 'key' => 'email_notifications'],
                ['value' => $request->boolean('email_notifications') ? '1' : '0']
            );
            
            Setting::updateOrCreate(
                ['user_id' => $user->id, 'key' => 'sms_notifications'],
                ['value' => $request->boolean('sms_notifications') ? '1' : '0']
            );
            
            Setting::updateOrCreate(
                ['user_id' => $user->id, 'key' => 'emergency_alerts'],
                ['value' => $request->boolean('emergency_alerts') ? '1' : '0']
            );

            return redirect()->route('setting.index')->with('success', 'Notification settings updated!');
            
        } catch (\Exception $e) {
            Log::error('Notification settings update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update notification settings: ' . $e->getMessage());
        }
    }

    public function updateProfilePhoto(Request $request)
    {
        Log::info('Profile photo upload started');
        
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        /** @var User $user */
        $user = Auth::user();
        Log::info('User: ' . $user->id);

        try {
            // Check if file was uploaded
            if (!$request->hasFile('profile_photo')) {
                throw new \Exception('No file uploaded');
            }

            $file = $request->file('profile_photo');
            Log::info('File received: ' . $file->getClientOriginalName() . ' | Size: ' . $file->getSize());

            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
                Log::info('Old photo deleted: ' . $user->profile_photo);
            }

            // Generate unique filename
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store image
            $path = $file->storeAs('public/profile-photos', $imageName);
            
            Log::info('File stored at: ' . $path);
            Log::info('Storage exists: ' . (Storage::exists($path) ? 'YES' : 'NO'));

            // Update database menggunakan save() method
            $user->profile_photo = $imageName;
            $user->save();

            Log::info('Database updated with: ' . $imageName);

            return redirect()->route('setting.index')->with('success', 'Profile photo updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Profile photo upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile photo: ' . $e->getMessage());
        }
    }

    public function removeProfilePhoto(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            // Hapus file foto
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
                Log::info('Profile photo deleted from storage: ' . $user->profile_photo);
            }

            // Update database menggunakan save() method
            $user->profile_photo = null;
            $user->save();

            Log::info('Profile photo removed from database for user: ' . $user->id);

            return redirect()->route('setting.index')->with('success', 'Profile photo removed successfully!');
            
        } catch (\Exception $e) {
            Log::error('Profile photo remove error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to remove profile photo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deactivateAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Optionally, you can mark the user as deactivated in the database
        // $user->update(['is_active' => false]);

        return redirect('/login')->with('success', 'Your account has been deactivated.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/register')->with('success', 'Your account has been permanently deleted.');
    }

    public function tempUpdateCodeStemi()
    {
        $user = Auth::user();
        CodeStemi::whereNull('user_id')->update(['user_id' => $user->id]);
        return redirect('/setting')->with('success', 'Account stats have been updated.');
    }
}