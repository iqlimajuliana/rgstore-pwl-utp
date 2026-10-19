<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Auth::user()->complaints()
            ->with('transaction')
            ->latest()
            ->paginate(10);

        return view('complaints.index', [
            'title' => 'Pengaduan Saya',
            'complaints' => $complaints,
        ]);
    }

    public function create()
    {
        return view('complaints.create', [
            'title' => 'Buat Pengaduan',
            'transactions' => Auth::user()->transactions()->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        $complaint = $request->user()->complaints()->create([
            ...$validated,
            'status' => 'open',
        ]);

        return redirect()->route('complaints.show', $complaint)
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function show(Complaint $complaint)
    {
        $complaint = $this->ownedComplaint($complaint);
        $complaint->load('transaction');

        return view('complaints.show', [
            'title' => 'Detail Pengaduan',
            'complaint' => $complaint,
        ]);
    }

    public function edit(Complaint $complaint)
    {
        $complaint = $this->ownedComplaint($complaint);

        return view('complaints.edit', [
            'title' => 'Edit Pengaduan',
            'complaint' => $complaint,
            'transactions' => Auth::user()->transactions()->latest()->get(),
        ]);
    }

    public function update(Request $request, Complaint $complaint)
    {
        $complaint = $this->ownedComplaint($complaint);
        $complaint->update($request->validate($this->rules($request)));

        return redirect()->route('complaints.show', $complaint)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint = $this->ownedComplaint($complaint);
        $complaint->delete();

        return redirect()->route('complaints.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    private function ownedComplaint(Complaint $complaint): Complaint
    {
        return Auth::user()->complaints()->findOrFail($complaint->getKey());
    }

    private function rules(Request $request): array
    {
        return [
            'transaction_id' => [
                'nullable',
                'integer',
                Rule::exists('transactions', 'id')->where('user_id', $request->user()->id),
            ],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:10000'],
        ];
    }
}
