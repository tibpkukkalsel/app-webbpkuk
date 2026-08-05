<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Permohonan Sewa Fasilitas Baru</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            -webkit-text-size-adjust: none;
        }
        .email-card {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .email-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 24px 28px;
            text-align: center;
        }
        .header-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: lowercase;
            padding: 5px 18px;
            border-radius: 30px;
        }
        .header-subtitle {
            font-size: 13px;
            color: #cbd5e1;
            margin: 0;
            font-weight: 500;
        }
        .header-title {
            font-size: 21px;
            font-weight: 900;
            margin: 8px 0 6px 0;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .email-body {
            padding: 28px;
        }
        .alert-badge {
            background-color: #eff6ff;
            border-left: 4px solid #0284c7;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #0369a1;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 8px;
            margin-top: 24px;
            margin-bottom: 12px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .data-label {
            width: 32%;
            color: #64748b;
            font-weight: 600;
        }
        .data-val {
            color: #0f172a;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 8px;
        }
        .items-table th {
            background: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 8px 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .btn-action {
            display: inline-block;
            background: #0284c7;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            margin-top: 24px;
            text-align: center;
        }
        .email-footer {
            background: #f8fafc;
            padding: 16px 28px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

    <div class="email-card">
        <div class="email-header">
            @php
                $identitas = \App\Models\Identitas::all();
                $logoPemprov = $identitas->firstWhere('nama', 'Logo Pemprov') ?? $identitas->firstWhere('nama', 'Logo Website');
                $logoBalatkop = $identitas->firstWhere('nama', 'Logo Balatkop Primary') ?? $identitas->firstWhere('nama', 'Logo Balatkop Sec');

                $logoPemprovPath = ($logoPemprov && file_exists(public_path('storage/header/' . $logoPemprov->keterangan)))
                    ? public_path('storage/header/' . $logoPemprov->keterangan) : null;
                $logoBalatkopPath = ($logoBalatkop && file_exists(public_path('storage/header/' . $logoBalatkop->keterangan)))
                    ? public_path('storage/header/' . $logoBalatkop->keterangan) : null;
            @endphp

            @if(isset($message) && ($logoPemprovPath || $logoBalatkopPath))
                <div style="text-align: center; margin-bottom: 14px;">
                    @if($logoPemprovPath)
                        <img src="{{ $message->embed($logoPemprovPath) }}" alt="Logo Pemprov Kalsel" style="max-height: 52px; width: auto; margin: 0 8px; display: inline-block; vertical-align: middle;">
                    @endif
                    @if($logoBalatkopPath)
                        <img src="{{ $message->embed($logoBalatkopPath) }}" alt="Logo Balatkop-UK" style="max-height: 52px; width: auto; margin: 0 8px; display: inline-block; vertical-align: middle;">
                    @endif
                </div>
            @endif

            <div style="margin-bottom: 4px;">
                <span class="header-tag">balatkopuk.kalselprov.go.id</span>
            </div>

            <h1 class="header-title" style="margin: 0 0 6px 0; font-size: 20px;">PERMOHONAN SEWA FASILITAS BARU</h1>
            <p class="header-subtitle" style="margin: 0;">Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</p>
        </div>

        <div class="email-body">
            <div class="alert-badge">
                🔔 <strong>Notifikasi Admin Fasilitas:</strong> Terdapat pengajuan sewa fasilitas baru melalui website publik yang memerlukan verifikasi Anda.
            </div>

            <div class="section-title">I. INFORMASI PEMOHON</div>
            <table class="data-table">
                <tr>
                    <td class="data-label">Nomor Booking</td>
                    <td class="data-val"><strong>{{ $pemesan->nomor_booking }}</strong></td>
                </tr>
                <tr>
                    <td class="data-label">Nama Pemohon</td>
                    <td class="data-val">{{ $pemesan->nama_pemohon }}</td>
                </tr>
                <tr>
                    <td class="data-label">NIK</td>
                    <td class="data-val">{{ $pemesan->nik }}</td>
                </tr>
                <tr>
                    <td class="data-label">Instansi / Organisasi</td>
                    <td class="data-val">{{ $pemesan->instansi }}</td>
                </tr>
                <tr>
                    <td class="data-label">Alamat Email</td>
                    <td class="data-val">{{ $pemesan->email }}</td>
                </tr>
                <tr>
                    <td class="data-label">No. HP / WhatsApp</td>
                    <td class="data-val">{{ $pemesan->no_hp }}</td>
                </tr>
                <tr>
                    <td class="data-label">Alamat Lengkap</td>
                    <td class="data-val">{{ $pemesan->alamat }}</td>
                </tr>
                <tr>
                    <td class="data-label">Tujuan Keperluan</td>
                    <td class="data-val">{{ $pemesan->keperluan }}</td>
                </tr>
            </table>

            <div class="section-title">II. JADWAL PEMAKAIAN FASILITAS</div>
            <table class="data-table">
                <tr>
                    <td class="data-label">Tanggal Mulai</td>
                    <td class="data-val">{{ $pemesan->tanggal_mulai ? $pemesan->tanggal_mulai->locale('id')->translatedFormat('l, d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="data-label">Tanggal Selesai</td>
                    <td class="data-val">{{ $pemesan->tanggal_selesai ? $pemesan->tanggal_selesai->locale('id')->translatedFormat('l, d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="data-label">Jam Operasional</td>
                    <td class="data-val">{{ $pemesan->jam_mulai ?? '08:00' }} - {{ $pemesan->jam_selesai ?? '16:00' }} WITA</td>
                </tr>
            </table>

            <div class="section-title">III. RINCIAN ITEM FASILITAS</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Fasilitas</th>
                        <th>Jumlah</th>
                        <th>Tarif</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalBiaya = 0; @endphp
                    @forelse($pemesan->details as $det)
                        @php $totalBiaya += $det->subtotal; @endphp
                        <tr>
                            <td><strong>{{ $det->fasilitas?->nama_fasilitas ?? 'Fasilitas' }}</strong></td>
                            <td>{{ $det->jumlah }}</td>
                            <td>Rp {{ number_format($det->tarif, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($det->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada rincian item.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 10px; font-size: 14px; font-weight: bold;">
                Total Estimasi: Rp {{ number_format($totalBiaya, 0, ',', '.') }}
            </div>

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ route('fasilitas.pemesan.view') }}" class="btn-action" target="_blank">
                    <i class="ti ti-check"></i> Buka Admin Control Panel & Verifikasi
                </a>
            </div>
        </div>

        <div class="email-footer">
            Sistem Informasi Resmi Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel<br>
            Jl. Ahmad Yani KM. 18.200 Banjarbaru, Kalimantan Selatan 70722
        </div>
    </div>

</body>
</html>
