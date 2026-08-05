<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Persetujuan Publikasi - {{ $post->judul }}</title>

    <!-- Font & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        /* BASE & A4 PRINT STYLES */
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000000;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px 0;
        }

        .paper-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            padding: 20mm 20mm;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* FLOATING ACTION BAR (SCREEN ONLY) */
        .print-actions-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            gap: 10px;
            background: rgba(15, 23, 42, 0.9);
            padding: 12px 18px;
            border-radius: 50px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(8px);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 30px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-print {
            background: #0284c7;
            color: #ffffff;
        }

        .btn-print:hover {
            background: #0369a1;
        }

        .btn-close-win {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .btn-close-win:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* OFFICIAL KOP SURAT HEADER */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px double #000000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 75px;
            height: auto;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex: 1;
            padding: 0 10px;
        }

        .kop-prov {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .kop-dinas {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
        }

        .kop-balai {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-alamat {
            font-size: 9.5pt;
            font-weight: normal;
            margin-top: 4px;
            line-height: 1.3;
        }

        /* DOCUMENT TITLE & NUMBER */
        .doc-title-wrap {
            text-align: center;
            margin-bottom: 24px;
        }

        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .doc-num {
            font-size: 10.5pt;
            margin: 0;
        }

        /* METADATA TABLE */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 6px 8px;
            vertical-align: top;
            font-size: 11pt;
            line-height: 1.4;
        }

        .meta-table td.label-col {
            width: 25%;
            font-weight: bold;
        }

        .meta-table td.sep-col {
            width: 2%;
            text-align: center;
        }

        .meta-table td.val-col {
            width: 73%;
        }

        /* CONTENT SUMMARY & THUMBNAIL BOX */
        .section-box {
            border: 1px solid #000000;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .section-box-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .summary-text {
            font-size: 11pt;
            line-height: 1.5;
            text-align: justify;
            margin: 0;
        }

        .thumb-preview-wrap {
            text-align: center;
            margin-top: 10px;
        }

        .thumb-preview-img {
            max-width: 220px;
            max-height: 140px;
            object-fit: cover;
            border: 1px solid #000;
            border-radius: 4px;
        }

        /* SIGNATURE BLOCK */
        .sig-container {
            width: 100%;
            margin-top: 35px;
            page-break-inside: avoid;
        }

        .sig-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sig-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 11pt;
            padding: 0 10px;
        }

        .sig-space {
            height: 75px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .sig-nip {
            margin-top: 2px;
            font-size: 10.5pt;
        }

        /* PRINT MEDIA QUERIES */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .paper-container {
                box-shadow: none;
                padding: 0;
                margin: 0;
                width: 100%;
                min-height: auto;
            }

            .print-actions-bar {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- SCREEN PRINT FLOATING BAR -->
    <div class="print-actions-bar">
        <button type="button" onclick="window.print()" class="btn-action btn-print">
            <i class="ti ti-printer"></i> Cetak / Print Dokumen
        </button>
        <button type="button" onclick="window.close()" class="btn-action btn-close-win">
            <i class="ti ti-x"></i> Tutup
        </button>
    </div>

    <!-- MAIN A4 PAPER CONTENT -->
    <div class="paper-container">

        <!-- KOP SURAT RESMI -->
        @php
            $logoPemprov = $identitas->firstWhere('nama', 'Logo Pemprov') ?? $identitas->firstWhere('nama', 'Logo Website');
            $logoBalatkop = $identitas->firstWhere('nama', 'Logo Balatkop Primary') ?? $identitas->firstWhere('nama', 'Logo Balatkop Sec');
            $alamatItem = $identitas->firstWhere('nama', 'Alamat');
            $teleponItem = $identitas->firstWhere('nama', 'Telepon');
            $emailItem = $identitas->firstWhere('nama', 'Email');
        @endphp

        <div class="kop-surat">
            @if ($logoPemprov)
                <img src="{{ asset('storage/header/' . $logoPemprov->keterangan) }}" alt="Logo Pemprov" class="kop-logo">
            @else
                <div style="width: 75px;"></div>
            @endif

            <div class="kop-text">
                <h3 class="kop-prov">PEMERINTAH PROVINSI KALIMANTAN SELATAN</h3>
                <h2 class="kop-dinas">DINAS KOPERASI DAN USAHA KECIL</h2>
                <h4 class="kop-balatkop">BALAI PELATIHAN KOPERASI DAN USAHA KECIL</h4>
                <div class="kop-alamat">
                    {{ $alamatItem?->keterangan ?? 'Jl. Ahmad Yani KM. 18.200 Banjarbaru, Kalimantan Selatan 70722' }}<br>
                    Telp: {{ $teleponItem?->keterangan ?? '(0511) 4707559' }} | Email: {{ $emailItem?->keterangan ?? 'web.balatkopuk@gmail.com' }}
                </div>
            </div>

            @if ($logoBalatkop)
                <img src="{{ asset('storage/header/' . $logoBalatkop->keterangan) }}" alt="Logo Balatkop" class="kop-logo">
            @else
                <div style="width: 75px;"></div>
            @endif
        </div>

        <!-- DOCUMENT TITLE & NUMBER -->
        <div class="doc-title-wrap">
            <h1 class="doc-title">LEMBAR VERIFIKASI & PERSETUJUAN PUBLIKASI KONTEN</h1>
            <p class="doc-num">Nomor Berkas: B-{{ str_pad($post->id_post, 5, '0', STR_PAD_LEFT) }}/BALATKOP-PUBLIKASI/{{ date('Y') }}</p>
        </div>

        <!-- METADATA TABLE -->
        <table class="meta-table">
            <tr>
                <td class="label-col">Judul Konten</td>
                <td class="sep-col">:</td>
                <td class="val-col"><strong>{{ $post->judul }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Jenis Konten</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ strtoupper($post->jenis ?? 'BERITA') }}</td>
            </tr>
            <tr>
                <td class="label-col">Kategori Sub-Bidang</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $post->kategori?->kategori ?? 'Umum' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Pengajuan</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $post->created_at ? $post->created_at->locale('id')->translatedFormat('l, d F Y - H:i') . ' WITA' : '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Pembuat Konten</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $post->user?->name ?? 'Admin Website' }} ({{ $post->user?->email ?? '-' }})</td>
            </tr>
            <tr>
                <td class="label-col">Status Pengajuan</td>
                <td class="sep-col">:</td>
                <td class="val-col">
                    @if ($post->status == 2)
                        <strong>DISERTAI PERSETUJUAN / PUBLISHED (TAYANG SEMENTARA)</strong>
                    @elseif($post->status == 1)
                        <strong>DIAJUKAN (MENUNGGU PERSETUJUAN KEPALA BALAI)</strong>
                    @else
                        <strong>DRAFT (KONSEP BARU)</strong>
                    @endif
                </td>
            </tr>
        </table>

        <!-- RINGKASAN KONTEN (SINTESIS AI) -->
        <div class="section-box">
            <h3 class="section-box-title">I. Ringkasan Eksekutif Konten (AI Summary):</h3>
            @php
                $rawRingkasan = !empty(trim($post->ringkasan ?? '')) ? $post->ringkasan : $post->isi;
                $cleanRingkasan = trim(html_entity_decode(strip_tags($rawRingkasan ?? '')));
            @endphp
            <p class="summary-text">
                {{ $cleanRingkasan ?: 'Belum ada ringkasan teks untuk publikasi berita ini.' }}
            </p>
        </div>

        <!-- PRATINJAU THUMBNAIL (JIKA ADA) -->
        @if ($post->thumbnail)
            <div class="section-box" style="text-align: center;">
                <h3 class="section-box-title" style="text-align: left;">II. Pratinjau Gambar Utama (Thumbnail):</h3>
                <div class="thumb-preview-wrap">
                    <img src="{{ asset('storage/post/thumbnail/' . $post->thumbnail) }}" alt="Thumbnail Preview" class="thumb-preview-img">
                </div>
            </div>
        @endif

        <!-- SIGNATURE BLOCK FOR KEPALA BALAI & ADMIN -->
        <div class="sig-container">
            <table class="sig-table">
                <tr>
                    <td>
                        Banjarbaru, {{ date('d F Y') }}<br>
                        <strong>Pembuat / Pengusul Konten,</strong>
                        <div class="sig-space"></div>
                        <p class="sig-name">{{ $post->user?->name ?? 'Admin Website' }}</p>
                        <p class="sig-nip">Admin Control Panel Website</p>
                    </td>
                    <td>
                        Menyetujui,<br>
                        <strong>Kepala Balai Pelatihan Koperasi dan Usaha Kecil<br>Provinsi Kalimantan Selatan,</strong>
                        <div class="sig-space"></div>
                        <p class="sig-name">{{ $kepalaBalai->nama ?? 'H. Ahmad Syarif, S.E., M.Si' }}</p>
                        <p class="sig-nip">NIP. {{ $kepalaBalai->nip ?? '19750812 200212 1 003' }}</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>
