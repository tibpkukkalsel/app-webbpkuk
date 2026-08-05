<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk Baru</title>
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
            padding: 4px 16px;
            border-radius: 20px;
            margin-bottom: 0;
        }

        .header-title {
            margin: 0 0 6px 0;
            font-size: 19px;
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

        .lead-text {
            font-size: 14px;
            color: #334155;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 0;
            font-size: 13px;
            vertical-align: top;
        }

        .info-table td.lbl {
            width: 130px;
            color: #64748b;
            font-weight: 600;
        }

        .info-table td.val {
            color: #0f172a;
            font-weight: 600;
        }

        .msg-box {
            background-color: #f0fdf4;
            border-left: 4px solid #0d9488;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .msg-title {
            font-size: 13px;
            font-weight: 800;
            color: #0d9488;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .msg-content {
            font-size: 14px;
            color: #0f172a;
            white-space: pre-line;
            line-height: 1.6;
        }

        .email-footer {
            background-color: #f8fafc;
            padding: 20px 28px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>

<body>
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

            <h1 class="header-title" style="margin: 0 0 6px 0; font-size: 20px;">NOTIFIKASI PESAN MASUK BARU</h1>
            <p class="header-subtitle" style="margin: 0;">Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</p>
        </div>

        <div class="email-body">
            <p class="lead-text">
                Halo Admin, ada pesan kontak baru yang dikirimkan oleh pengunjung melalui formulir website:
            </p>

            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td class="lbl">Nama Pengirim</td>
                        <td class="val">: {{ $kontak->nama }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Email Pengirim</td>
                        <td class="val">: <a href="mailto:{{ $kontak->email }}"
                                style="color: #0284c7; text-decoration: none;">{{ $kontak->email }}</a></td>
                    </tr>
                    <tr>
                        <td class="lbl">No. Telepon / WA</td>
                        <td class="val">: {{ $kontak->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Subjek Pesan</td>
                        <td class="val">: <strong>{{ $kontak->subjek }}</strong></td>
                    </tr>
                    <tr>
                        <td class="lbl">Waktu Kirim</td>
                        <td class="val">: {{ $kontak->created_at ? $kontak->created_at->format('d M Y, H:i') : '-' }}
                            WITA</td>
                    </tr>
                </table>
            </div>

            <div class="msg-box">
                <div class="msg-title">Isi Pesan / Pertanyaan:</div>
                <div class="msg-content">{{ $kontak->pesan }}</div>
            </div>
        </div>

        <div class="email-footer">
            <p style="margin:0;">Silakan login ke Dashboard Admin Helpdesk untuk memberikan respon resmi.</p>
        </div>
    </div>
</body>

</html>
