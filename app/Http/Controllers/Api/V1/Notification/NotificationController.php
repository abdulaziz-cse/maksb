<?php

namespace App\Http\Controllers\Api\V1\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * @group Notifications
 */
class NotificationController extends Controller
{
    /**
     * Get notifications
     *
     * @queryParam page Page number for pagination Example: 2
     * @queryParam perPage Results to fetch per page Example: 15
     *
     * @responseFile 200 responses/notifications/list.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     * 
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->get('perPage');
        $notifications = $user->notifications()->paginate($perPage ?? 15);
        $notifications->getCollection()->transform(function($notification) {
            $data = $notification->data;
            if (isset($data['summary'])) {
                $notification->summary = $data['summary'];
            } else {
                $notification->summary = '';
            }
            return $notification;
        });

    	return response()->json($notifications);
    }

    /**
     * Unread notifications
     *
     * @queryParam page Page number for pagination Example: 2
     * @queryParam perPage Results to fetch per page Example: 15
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function unread(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->get('perPage');
        $notifications = $user->unreadNotifications()->paginate($perPage ?? 15);
        $notifications->getCollection()->transform(function($notification) {
            $data = $notification->data;
            if (isset($data['summary'])) {
                $notification->summary = $data['summary'];
            } else {
                $notification->summary = '';
            }
            return $notification;
        });

    	return response()->json($notifications);
    }

    /**
     * Unread notifications count
     *
     * @responseFile 200 responses/notifications/unread_count.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount()
    {
        $user = auth()->user();

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
        ]);
    }

    /**
     * Mark all as read
     *
     * @responseFile 200 responses/general/success.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
    	$now = Carbon::now();
        $user = auth()->user();
    	$user->unreadNotifications()->update(['read_at' => $now]);

    	return response()->json(["message" => "Success"], 200);
    }

    /**
     * Mark notification as read
     *
     * @urlParam id required Notification id
     *
     * @responseFile 200 responses/general/success.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     * 
     * @param  integer $notificationId
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function markRead($notificationId)
    {
    	$now = Carbon::now();
        $user = auth()->user();
    	$user->unreadNotifications()->where('id', $notificationId)->update([
            'read_at' => $now,
        ]);
        
    	return response()->json(["message" => "Success"], 200);
    }
}
