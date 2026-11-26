<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'procurement');
        if (! in_array($type, ['procurement', 'job_vacancy'])) {
            $type = 'procurement';
        }

        $query = Announcement::where('type', $type)
            ->where('status', 'open')
            ->whereDate('deadline', '>=', today());

        if ($request->filled('keyword')) {
            $kw = strtolower($request->keyword);
            $query->where(function ($q) use ($kw) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(agency) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(location) LIKE ?', ["%{$kw}%"]);
            });
        }

        $announcements = $query->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        $procurementCount = Announcement::where('type', 'procurement')
            ->where('status', 'open')
            ->whereDate('deadline', '>=', today())
            ->count();
        $jobVacancyCount = Announcement::where('type', 'job_vacancy')
            ->where('status', 'open')
            ->whereDate('deadline', '>=', today())
            ->count();

        return view('announcements.index', compact('announcements', 'type', 'procurementCount', 'jobVacancyCount'));
    }

    public function apply(Announcement $announcement)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $roleMatches = ($announcement->type === 'procurement' && $user->role === 'umkm')
            || ($announcement->type === 'job_vacancy' && $user->role === 'talent');
        abort_unless($roleMatches, 403);
        abort_unless(
            $announcement->status === 'open'
                && ($announcement->deadline->isToday() || $announcement->deadline->isFuture()),
            404
        );

        if ($user->applications()->where('announcement_id', $announcement->id)->exists()) {
            return redirect()->route('announcements.index', ['type' => $announcement->type])
                ->with('error', 'Anda sudah mengirim pengajuan untuk pengumuman ini.');
        }

        $identifier = $user->role === 'umkm' ? $user->umkm?->nib : $user->talent?->nik;
        $identifierLabel = $user->role === 'umkm' ? 'NIB Pelaku Usaha' : 'NIK Talenta';

        return view('announcements.apply', compact('announcement', 'user', 'identifier', 'identifierLabel'));
    }

    public function submitApplication(Request $request, Announcement $announcement)
    {
        $user = Auth::user();
        abort_unless($user, 401);
        $roleMatches = ($announcement->type === 'procurement' && $user->role === 'umkm')
            || ($announcement->type === 'job_vacancy' && $user->role === 'talent');
        abort_unless($roleMatches, 403);
        abort_unless(
            $announcement->status === 'open'
                && ($announcement->deadline->isToday() || $announcement->deadline->isFuture()),
            404
        );

        $data = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'identifier' => 'required|string|max:50',
            'proposal_note' => 'required|string|min:20|max:3000',
            'portfolio_url' => 'nullable|url|max:500',
            'contact_phone' => 'required|string|min:9|max:20',
            'terms' => 'accepted',
        ], [
            'applicant_name.required' => 'Nama lengkap atau nama badan usaha wajib diisi.',
            'identifier.required' => 'Nomor NIB atau NIK wajib diisi untuk verifikasi identitas resmi.',
            'proposal_note.required' => 'Catatan kualifikasi atau kapasitas produksi wajib diisi.',
            'proposal_note.min' => 'Catatan kualifikasi minimal 20 karakter.',
            'portfolio_url.url' => 'Format tautan portofolio/dokumen harus berupa URL valid (contoh: https://drive.google.com/...).',
            'contact_phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'terms.accepted' => 'Anda wajib menyetujui Pakta Integritas dan Syarat Layanan Pemko Medan.',
        ]);

        $application = Application::firstOrCreate(
            [
                'announcement_id' => $announcement->id,
                'user_id' => $user->id,
            ],
            [
                'applicant_name' => $data['applicant_name'],
                'identifier' => $data['identifier'],
                'proposal_note' => $data['proposal_note'],
                'portfolio_url' => $data['portfolio_url'] ?? null,
                'contact_phone' => $data['contact_phone'],
                'status' => 'pending',
            ]
        );

        if (! $application->wasRecentlyCreated) {
            return redirect()->route('announcements.index', ['type' => $announcement->type])
                ->with('error', 'Anda sudah mengirim pengajuan untuk pengumuman ini.');
        }

        return redirect()->route('announcements.index', ['type' => $announcement->type])
            ->with('success', 'Pengajuan Minat Anda berhasil dikirimkan ke '.$announcement->agency.'! Tim verifikator dinas akan menghubungi WhatsApp Anda.');
    }

    public function myApplications()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('home')->with('error', 'Silakan masuk terlebih dahulu untuk melihat status pengajuan Anda.');
        }

        $applications = Application::with(['announcement', 'user'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('announcements.my_applications', compact('applications'));
    }

    public function destroyApplication(Application $application)
    {
        $user = Auth::user();

        abort_unless($user && $user->role === 'talent', 403);
        abort_unless($application->user_id === $user->id, 403);
        abort_unless($application->status === 'rejected', 403);

        $application->delete();

        return redirect()->route('announcements.my_applications')
            ->with('success', 'Lamaran yang ditolak berhasil dihapus.');
    }
}
