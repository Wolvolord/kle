<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $action = $request->query('action');
            if ($action === 'auth') {
                $query->whereIn('action', ['login', 'logout', 'register']);
            } elseif ($action !== 'all') {
                $query->where('action', $action);
            }
        }

        if ($request->filled('q')) {
            $keyword = $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('description', 'like', "%{$keyword}%")
                  ->orWhere('entity_name', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($uq) use ($keyword) {
                      $uq->where('name', 'like', "%{$keyword}%")
                         ->orWhere('email', 'like', "%{$keyword}%")
                         ->orWhere('user_code', 'like', "%{$keyword}%");
                  });
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $stats = [
            'total'   => ActivityLog::count(),
            'create'  => ActivityLog::where('action', 'create')->count(),
            'update'  => ActivityLog::where('action', 'update')->count(),
            'delete'  => ActivityLog::where('action', 'delete')->count(),
        ];

        return view('logs.index', compact('logs', 'stats'));
    }
}
