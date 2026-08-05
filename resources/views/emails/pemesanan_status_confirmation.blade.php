<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Status Permohonan Sewa Fasilitas</title>
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
        .status-box {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
        }
        .status-disetujui {
            background-color: #f0fdf4;
            border: 2px solid #22c55e;
            color: #15803d;
        }
        .status-ditolak, .status-dibatalkan {
            background-color: #fef2f2;
            border: 2px solid #ef4444;
            color: #b91c1c;
        }
        .status-menunggu {
            background-color: #fffbeb;
            border: 2px solid #f59e0b;
            color: #b45309;
        }
        .status-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px 0;
            text-transform: uppercase;
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
        .catatan-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 14px 18px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .email-footer {
            background: #f8fafc;
            padding: 20px 28px;
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

            <h1 class="header-title" style="margin: 0 0 6px 0; font-size: 20px;">KONFIRMASI SEWA FASILITAS</h1>
            <p class="header-subtitle" style="margin: 0;">Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</p>
        </div>

        <div class="email-body">
            <p>Kepada Yth. <strong>{{ $pemesan->nama_pemohon }}</strong> ({{ $pemesan->instansi }}),</p>
            <p style="font-size: 14px; line-height: 1.5;">
                Terima kasih telah mengajukan permohonan pemanfaatan fasilitas pada Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan.
            </p>

            <!-- STATUS BOX -->
            @php
                $st = strtolower($pemesan->status ?? 'menunggu');
            @endphp

            @if(in_array($st, ['disetujui', 'dikonfirmasi', 'publish', 'selesai']))
                <div class="status-box status-disetujui">
                    <div class="status-title">✅ PERMOHONAN DISETUJUI / DIKONFIRMASI</div>
                    <div>Permohonan sewa fasilitas Anda telah diverifikasi dan <strong>disetujui</strong> oleh Admin Fasilitas.</div>
                </div>
            @elseif(in_array($st, ['ditolak', 'dibatalkan']))
                <div class="status-box status-ditolak">
                    <div class="status-title">❌ PERMOHONAN {{ strtoupper($st) }}</div>
                    <div>Mohon maaf, permohonan sewa fasilitas Anda dengan nomor booking <strong>{{ $pemesan->nomor_booking }}</strong> belum dapat disetujui.</div>
                </div>
            @else
                <div class="status-box status-menunggu">
                    <div class="status-title">⏳ MENUNGGU VERIFIKASI</div>
                    <div>Permohonan sewa fasilitas Anda sedang dalam proses peninjauan oleh tim admin kami.</div>
                </div>
            @endif

            <div class="section-title">I. RINGKASAN PERMOHONAN</div>
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
                    <td class="data-label">Instansi / Organisasi</td>
                    <td class="data-val">{{ $pemesan->instansi }}</td>
                </tr>
                <tr>
                    <td class="data-label">Tanggal Pemakaian</td>
                    <td class="data-val">
                        {{ $pemesan->tanggal_mulai ? $pemesan->tanggal_mulai->locale('id')->translatedFormat('d F Y') : '-' }}
                        s/d
                        {{ $pemesan->tanggal_selesai ? $pemesan->tanggal_selesai->locale('id')->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="data-label">Jam Operasional</td>
                    <td class="data-val">{{ $pemesan->jam_mulai ?? '08:00' }} - {{ $pemesan->jam_selesai ?? '16:00' }} WITA</td>
                </tr>
                <tr>
                    <td class="data-label">Keperluan</td>
                    <td class="data-val">{{ $pemesan->keperluan }}</td>
                </tr>
            </table>

            <div class="section-title">II. RINCIAN ITEM FASILITAS</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Fasilitas</th>
                        <th>Jumlah</th>
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
                            <td>Rp {{ number_format($det->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Tidak ada item fasilitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 10px; font-size: 14px; font-weight: bold;">
                Total Estimasi Tarif: Rp {{ number_format($totalBiaya, 0, ',', '.') }}
            </div>

            <!-- CATATAN PETUNJUK DARI ADMIN -->
            @if(!empty($pemesan->catatan))
                <div class="catatan-box">
                    <strong>📌 Catatan & Petunjuk Lanjutan dari Admin Balatkop-UK:</strong><br>
                    {{ $pemesan->catatan }}
                </div>
            @endif

            <p style="font-size: 13px; color: #475569; margin-top: 24px; line-height: 1.5;">
                Jika Anda memiliki pertanyaan mengenai permohonan ini, silakan hubungi Kantor Balatkop-UK Prov. Kalsel di <strong>(0511) 4707559</strong> atau kirim email balasan ke <strong>web.balatkopuk@gmail.com</strong>.
            </p>
        </div>

        <div class="email-footer">
            <strong>Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</strong><br>
            Jl. Ahmad Yani KM. 18.200 Banjarbaru, Kalimantan Selatan 70722<br>
            Website: <a href="https://web-balatkopuk.test" style="color: #0284c7;">web-balatkopuk.test</a> | Email: web.balatkopuk@gmail.com
        </div>
    </div>

</body>
</html>
