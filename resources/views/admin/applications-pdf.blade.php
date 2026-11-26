<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Data Pelamar KITAME</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 24px 26px 34px;
        }

        body {
            color: #2B2118;
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        .header {
            border-bottom: 2px solid #0D9488;
            margin-bottom: 14px;
            padding-bottom: 10px;
        }

        .brand {
            color: #0F766E;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        h1 {
            font-size: 17px;
            margin: 5px 0;
        }

        .subtitle,
        .meta {
            color: #706960;
            font-size: 8px;
            line-height: 1.5;
        }

        .meta {
            margin-top: 6px;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        thead {
            display: table-header-group;
        }

        th {
            background: #2B2118;
            color: #FFFFFF;
            font-size: 7px;
            padding: 7px 6px;
            text-align: left;
            text-transform: uppercase;
        }

        td {
            border-bottom: 1px solid #E5DED3;
            font-size: 7px;
            line-height: 1.45;
            overflow-wrap: break-word;
            padding: 7px 6px;
            vertical-align: top;
        }

        tr {
            page-break-inside: avoid;
        }

        .name {
            font-size: 8px;
            font-weight: bold;
        }

        .muted {
            color: #706960;
        }

        .status {
            color: #0F766E;
            font-weight: bold;
        }

        .empty {
            color: #706960;
            padding: 24px;
            text-align: center;
        }

        .footer {
            bottom: -20px;
            color: #706960;
            font-size: 7px;
            position: fixed;
            right: 0;
        }

        .footer:after {
            content: " • Halaman " counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">KITAME • Pemerintah Kota Medan</div>
        <h1>Rekap Data Pelamar</h1>
        <div class="subtitle">
            @if($announcement)
                {{ $announcement->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Talenta' }}:
                {{ $announcement->title }} — {{ $announcement->agency }}
            @else
                Seluruh acara dan pengumuman
            @endif
        </div>
        <div class="meta">
            Total {{ $applications->count() }} pengajuan
            <span> • </span>
            Dibuat {{ $generatedAt->format('d/m/Y H:i') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No.</th>
                <th style="width: 18%;">Pelamar</th>
                <th style="width: 23%;">Acara / Pengumuman</th>
                <th style="width: 14%;">Identitas & Kontak</th>
                <th style="width: 27%;">Catatan / Kualifikasi</th>
                <th style="width: 15%;">Status / Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="name">{{ $application->applicant_name ?: $application->user->name }}</div>
                        <div class="muted">
                            {{ $application->user->role === 'talent' ? 'Talenta' : ($application->user->role === 'umkm' ? 'UMKM' : $application->user->role) }}
                            <br>{{ $application->user->email }}
                        </div>
                    </td>
                    <td>
                        <strong>{{ $application->announcement->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Talenta' }}</strong>
                        <br>{{ $application->announcement->title }}
                        <div class="muted">
                            {{ $application->announcement->agency }} • {{ $application->announcement->location }}
                            <br>Batas: {{ $application->announcement->deadline?->format('d/m/Y') ?: '—' }}
                        </div>
                    </td>
                    <td>
                        {{ $application->identifier ?: '—' }}
                        <br>{{ $application->contact_phone }}
                    </td>
                    <td>
                        {{ $application->proposal_note }}
                        @if($application->portfolio_url)
                            <div class="muted">Portofolio: {{ $application->portfolio_url }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="status">
                            {{ match ($application->status) {
                                'pending' => 'Menunggu',
                                'reviewed' => 'Ditinjau',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                                default => $application->status,
                            } }}
                        </div>
                        <div class="muted">{{ $application->created_at?->format('d/m/Y H:i') }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">Belum ada data pelamar untuk pilihan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dokumen internal KITAME</div>
</body>
</html>
