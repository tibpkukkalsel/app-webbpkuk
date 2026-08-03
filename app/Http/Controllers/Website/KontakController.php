<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KontakController extends Controller
{
    public function view()
    {
        $identitas = \App\Models\Identitas::all();
        $footer = \App\Models\Footer::all();
        $tentang = \App\Models\Tentang::all();

        return view('websites.kontak.view', compact('identitas', 'footer', 'tentang'));
    }

    public function store(Request $request)
    {
        // 1. HONEYPOT TRAP (Anti-Bot / Anti-Spam Trap)
        if ($request->filled('fax_hp')) {
            Log::warning('Kontak Form Honeypot Triggered by IP: ' . $request->ip());
            // Silently pretend success to trick malicious bots
            return redirect()->back()->with('success_kontak', 'Terima kasih, pesan Anda telah berhasil terkirim!');
        }

        // 2. STRICT VALIDATION RULES
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\,\'\-]+$/u'],
            'email' => ['required', 'email:rfc,dns', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\s\(\)]+$/'],
            'subjek' => ['required', 'string', 'min:3', 'max:150'],
            'pesan' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan karakter umum nama.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'subjek.min' => 'Subjek minimal 3 karakter.',
            'pesan.required' => 'Isi pesan wajib diisi.',
            'pesan.min' => 'Isi pesan minimal 10 karakter.',
            'pesan.max' => 'Isi pesan maksimal 2000 karakter.',
        ]);

        // 3. INPUT SANITIZATION (XSS & Injection Protection)
        $cleanData = [
            'nama' => strip_tags(trim($validated['nama'])),
            'email' => filter_var(trim($validated['email']), FILTER_SANITIZE_EMAIL),
            'telepon' => isset($validated['telepon']) ? preg_replace('/[^0-9\+\-\s\(\)]/', '', trim($validated['telepon'])) : null,
            'subjek' => strip_tags(trim($validated['subjek'])),
            'pesan' => strip_tags(trim($validated['pesan'])),
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ];

        // 4. SAVE TO DATABASE
        $kontak = Kontak::create($cleanData);

        // 5. DISPATCH EMAIL NOTIFICATION TO ADMIN
        try {
            $adminEmail = config('mail.from.address', 'bpkuk.provkalsel@gmail.com');
            if (!empty($adminEmail)) {
                Mail::to($adminEmail)->send(new \App\Mail\NewKontakNotificationMail($kontak));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi email kontak ke admin: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih, pesan Anda telah berhasil terkirim. Tim kami akan segera merespons via email.'
            ]);
        }

        return redirect()->back()->with('success_kontak', 'Terima kasih, pesan Anda telah berhasil terkirim!');
    }
}
