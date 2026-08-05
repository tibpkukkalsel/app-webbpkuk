<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $balasan->subjek_balasan ?? 'Balasan Pesan' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 30px 10px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            max-width: 620px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.07);
        }

        .email-header {
            background: linear-gradient(135deg, #000000 0%, #18181b 50%, #3f3f46 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }

        .header-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: lowercase;
            padding: 5px 18px;
            border-radius: 20px;
        }

        .header-title {
            margin: 0 0 6px 0;
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header-subtitle {
            margin: 0;
            font-size: 13px;
            color: #cbd5e1;
            font-weight: 500;
        }

        .email-body {
            padding: 32px 28px;
        }

        .salutation {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
        }

        .lead-text {
            font-size: 14px;
            color: #334155;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .reply-box {
            background-color: #f8fafc;
            border-left: 4px solid #0d9488;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 28px;
            border-top: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .reply-title {
            font-size: 12px;
            font-weight: 800;
            color: #0d9488;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .reply-content {
            font-size: 15px;
            color: #0f172a;
            white-space: pre-line;
            line-height: 1.65;
        }

        .original-box {
            background-color: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 16px 20px;
            font-size: 13px;
            color: #64748b;
        }

        .original-title {
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }

        .original-text {
            font-style: italic;
            color: #334155;
            margin-bottom: 8px;
        }

        .original-meta {
            font-size: 11px;
            color: #94a3b8;
        }

        .email-footer {
            background-color: #f8fafc;
            padding: 20px 28px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
        }

        .footer-brand {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .footer-address {
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .footer-notice {
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    @php
        $alamatText =
            \App\Models\Identitas::where('nama', 'Alamat')->first()?->keterangan ??
            'Jl. Ahmad Yani KM. 18.200 Kec. Liang Anggang Kota Banjarbaru, Kalimantan Selatan';
    @endphp

    <div class="email-wrapper">
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

            <h1 class="header-title" style="margin: 0 0 6px 0; font-size: 20px;">BALASAN PESAN HELPDESK</h1>
            <p class="header-subtitle" style="margin: 0;">Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</p>
        </div>

        <div class="email-body">
            <div class="salutation">Yth. {{ $kontak->nama }},</div>
            <p class="lead-text">
                Terima kasih telah menghubungi Helpdesk Resmi Balatkop-UK Provinsi Kalimantan Selatan. Berikut adalah
                tanggapan resmi dari pesan/pertanyaan yang Anda sampaikan:
            </p>

            <div class="reply-box">
                <div class="reply-title">Tanggapan Admin Helpdesk</div>
                <div class="reply-content">{!! nl2br(e($balasan->pesan_balasan)) !!}</div>
            </div>

            <div class="original-box">
                <div class="original-title">Pesan Anda Sebelumnya:</div>
                <div class="original-text">"{{ $kontak->pesan }}"</div>
                <div class="original-meta">
                    Subjek: {{ $kontak->subjek }} &bull; Waktu Kirim:
                    {{ $kontak->created_at ? $kontak->created_at->format('d M Y H:i') : '-' }} WITA
                </div>
            </div>
        </div>

        <div class="email-footer">
            <div class="footer-brand">UPTD Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</div>
            <div class="footer-address">{{ $alamatText }}</div>
            <div class="footer-notice">Email ini dikirimkan secara otomatis oleh Sistem Helpdesk Resmi Balatkop-UK
                Kalsel.</div>
        </div>
    </div>
</body>

</html>
