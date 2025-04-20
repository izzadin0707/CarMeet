<?php

namespace App\Http\Controllers;

use App\Models\Banned;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedController extends Controller
{
    public function banUser(Request $request)
    {
        // Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'banned' => 'required|integer|min:1', // Number of days to ban
        ]);

        try {
            // Check if user is already banned
            $existingBan = Banned::where('user_id', $request->user_id)->first();
            
            if ($existingBan) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already banned'
                ]);
            }

            // Calculate ban end date
            $banEndDate = Carbon::now()->addDays($request->banned);

            // Create new ban record
            $ban = new Banned([
                'user_id' => $request->user_id,
                'banned' => $banEndDate
            ]);

            if ($ban->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "User has been banned for {$request->banned} days"
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to ban user'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while banning user',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function unbanUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $ban = Banned::where('user_id', $request->user_id)->first();
            
            if (!$ban) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not banned'
                ]);
            }

            if ($ban->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User has been unbanned successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to unban user'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while unbanning user',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function checkBanStatus($userId)
    {
        $ban = Banned::where('user_id', $userId)->first();

        if (!$ban) {
            return false;
        }

        // If ban has expired, remove it
        if (Carbon::now()->gt($ban->banned)) {
            $ban->delete();
            return false;
        }

        return true;
    }
}