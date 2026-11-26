<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Application;
use App\Models\Talent;
use App\Models\Umkm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index(): View
    {
        $this->ensureAdmin();

        return view('admin.dashboard', [
            'umkms' => Umkm::with('user')->latest()->get(),
            'talents' => Talent::with('user')->latest()->get(),
            'announcements' => Announcement::latest()->limit(10)->get(),
            'announcementsForExport' => Announcement::whereHas('applications')
                ->orderBy('title')
                ->get(['id', 'title', 'type']),
            'applications' => Application::with(['user.talent', 'user.umkm', 'announcement'])->latest()->get(),
            'umkmNotInCatalogCount' => Umkm::where('e_catalog_pemko', false)->count(),
            'umkmUnpublishedCount' => Umkm::where('is_published', false)->count(),
            'talentNotCertifiedCount' => Talent::where('disnaker_certified', false)->count(),
            'talentUnpublishedCount' => Talent::where('is_published', false)->count(),
            'openAnnouncementCount' => Announcement::where('status', 'open')->count(),
            'pendingApplicationCount' => Application::where('status', 'pending')->count(),
        ]);
    }

    public function toggleUmkmCatalog(Umkm $umkm): RedirectResponse
    {
        $this->ensureAdmin();
        $umkm->update(['e_catalog_pemko' => ! $umkm->e_catalog_pemko]);

        return back()->with('success', 'Status E-Katalog UMKM berhasil diperbarui.');
    }

    public function toggleUmkmPublication(Umkm $umkm): RedirectResponse
    {
        $this->ensureAdmin();
        $umkm->update(['is_published' => ! $umkm->is_published]);

        return back()->with('success', 'Status publikasi UMKM berhasil diperbarui.');
    }

    public function toggleTalentCertification(Talent $talent): RedirectResponse
    {
        $this->ensureAdmin();
        $talent->update(['disnaker_certified' => ! $talent->disnaker_certified]);

        return back()->with('success', 'Status sertifikasi talenta berhasil diperbarui.');
    }

    public function toggleTalentPublication(Talent $talent): RedirectResponse
    {
        $this->ensureAdmin();
        $talent->update(['is_published' => ! $talent->is_published]);

        return back()->with('success', 'Status publikasi talenta berhasil diperbarui.');
    }

    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'type' => 'required|in:procurement,job_vacancy',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'budget_estimate' => 'required|string|max:100',
            'deadline' => 'required|date|after_or_equal:today',
            'agency' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ], [
            'deadline.after_or_equal' => 'Batas pengajuan harus hari ini atau setelahnya.',
        ]);

        Announcement::create([
            ...$data,
            'user_id' => auth()->id(),
            'status' => 'open',
        ]);

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function toggleAnnouncementStatus(Announcement $announcement): RedirectResponse
    {
        $this->ensureAdmin();
        $announcement->update([
            'status' => $announcement->status === 'open' ? 'closed' : 'open',
        ]);

        return back()->with('success', 'Status pengumuman berhasil diperbarui.');
    }

    public function updateApplicationStatus(Request $request, Application $application): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Status pengajuan pelamar berhasil diperbarui.');
    }

    public function exportApplications(Request $request): Response
    {
        $this->ensureAdmin();
        $filters = $request->validate([
            'announcement_id' => 'nullable|integer|exists:announcements,id',
        ]);
        $announcementId = $filters['announcement_id'] ?? null;
        $announcement = $announcementId === null
            ? null
            : Announcement::findOrFail($announcementId);

        $applicationsQuery = Application::with(['user', 'announcement'])->latest();
        if ($announcementId !== null) {
            $applicationsQuery->where('announcement_id', $announcementId);
        }

        $applications = $applicationsQuery->get();
        $filename = 'data-pelamar-'
            .($announcement ? Str::slug($announcement->title) : 'semua-acara')
            .'-'.now()->format('Ymd-His').'.pdf';

        $response = Pdf::loadView('admin.applications-pdf', [
            'applications' => $applications,
            'announcement' => $announcement,
            'generatedAt' => now(),
        ])
            ->setPaper('a4', 'landscape')
            ->download($filename);

        $response->headers->set('Cache-Control', 'private, no-store');

        return $response;
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin_pemko', 403);
    }
}
