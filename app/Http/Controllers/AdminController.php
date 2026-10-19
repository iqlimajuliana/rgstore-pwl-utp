<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private const COMPLAINT_STATUSES = [
        'open',
        'in_progress',
        'resolved',
        'rejected',
    ];

    public function dashboard()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'transactionSummary' => [
                'total' => Transaction::count(),
                'pending' => Transaction::where('status', 'pending')->count(),
                'success' => Transaction::where('status', 'success')->count(),
            ],
            'complaintSummary' => [
                'total' => Complaint::count(),
                'open' => Complaint::where('status', 'open')->count(),
                'inProgress' => Complaint::where('status', 'in_progress')->count(),
                'resolved' => Complaint::where('status', 'resolved')->count(),
            ],
            'recentComplaints' => Complaint::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function complaints()
    {
        return view('admin.complaints.index', [
            'title' => 'Semua Pengaduan',
            'complaints' => Complaint::with(['user', 'transaction'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function showComplaint(Complaint $complaint)
    {
        $complaint->load(['user', 'transaction']);

        return view('admin.complaints.show', [
            'title' => 'Penanganan Pengaduan',
            'complaint' => $complaint,
            'statuses' => self::COMPLAINT_STATUSES,
        ]);
    }

    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(self::COMPLAINT_STATUSES)],
        ]);

        $complaint->update($validated);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
