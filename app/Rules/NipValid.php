<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NipValid implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Cek apakah panjangnya 18 digit dan hanya angka
        if (!preg_match('/^[0-9]{18}$/', $value)) {
            $fail('NIP harus terdiri dari 18 digit angka.');
            return;
        }

        // --- Parsing Struktur NIP ---
        $tgl_lahir_str = substr($value, 0, 8);
        $tmt_str       = substr($value, 8, 6);
        $gender        = substr($value, 14, 1);

        // 2. Cek Validitas Tanggal Lahir
        $y_lahir = (int) substr($tgl_lahir_str, 0, 4);
        $m_lahir = (int) substr($tgl_lahir_str, 4, 2);
        $d_lahir = (int) substr($tgl_lahir_str, 6, 2);

        if (!checkdate($m_lahir, $d_lahir, $y_lahir)) {
            $fail('Format tanggal lahir pada NIP tidak valid.');
            return;
        }

        // 3. Cek Validitas Bulan Pengangkatan (TMT)
        $m_tmt = (int) substr($tmt_str, 4, 2);
        if ($m_tmt < 1 || $m_tmt > 12) {
            $fail('Format bulan pengangkatan pada NIP tidak valid.');
            return;
        }

        // 4. Cek Logika Tahun (Tahun lahir harus lebih kecil dari tahun angkat)
        $y_tmt = (int) substr($tmt_str, 0, 4);
        if (($y_tmt - $y_lahir) < 17) { // Asumsi minimal masuk kerja umur 17 tahun
            $fail('Tahun pengangkatan tidak logis berdasarkan tahun lahir.');
            return;
        }

        // 5. Cek Kode Jenis Kelamin (Hanya boleh 1 atau 2)
        if (!in_array($gender, ['1', '2'])) {
            $fail('Kode jenis kelamin pada NIP salah (harus 1 atau 2).');
            return;
        }
    }
}