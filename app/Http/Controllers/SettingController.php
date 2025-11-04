<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Setting;
use App\Models\User;

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
            // Update user data
            $user->fill([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'] ?? null,
            ])->save();

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
            \Log::error('Profile update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        try {
            // Update password
            $user->fill([
                'password' => Hash::make($validated['new_password'])
            ])->save();

            return redirect()->route('setting.index')->with('success', 'Password updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Password update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update password: ' . $e->getMessage());
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
            \Log::error('Notification settings update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update notification settings: ' . $e->getMessage());
        }
    }

    public function updateProfilePhoto(Request $request)
    {
        \Log::info('Profile photo upload started');
        
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $user = Auth::user();
        \Log::info('User: ' . $user->id);

        try {
            // Check if file was uploaded
            if (!$request->hasFile('profile_photo')) {
                throw new \Exception('No file uploaded');
            }

            $file = $request->file('profile_photo');
            \Log::info('File received: ' . $file->getClientOriginalName() . ' | Size: ' . $file->getSize());

            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
                \Log::info('Old photo deleted: ' . $user->profile_photo);
            }

            // Generate unique filename
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store image
            $path = $file->storeAs('public/profile-photos', $imageName);
            
            \Log::info('File stored at: ' . $path);
            \Log::info('Storage exists: ' . (Storage::exists($path) ? 'YES' : 'NO'));

            // Update database
            $user->update(['profile_photo' => $imageName]);
            \Log::info('Database updated with: ' . $imageName);

            return redirect()->route('setting.index')->with('success', 'Profile photo updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Profile photo upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile photo: ' . $e->getMessage());
        }
    }

    public function removeProfilePhoto(Request $request)
    {
        $user = Auth::user();

        try {
            // Hapus file foto
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
                \Log::info('Profile photo deleted from storage: ' . $user->profile_photo);
            }

            // Update database
            $user->update(['profile_photo' => null]);
            \Log::info('Profile photo removed from database for user: ' . $user->id);

            return redirect()->route('setting.index')->with('success', 'Profile photo removed successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Profile photo remove error: ' . $e->getMessage());
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
}