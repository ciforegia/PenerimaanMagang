<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penerimaan Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin-top: 1.02cm;
            margin-bottom: 2.68cm;
            margin-left: 1.5cm;
            margin-right: 0.75cm;
        }
        .kop-logo-kiri {
            position: absolute;
            top: 20px;
            left: 30px;
            height: 80px;
        }
        .kop-logo-kanan {
            position: absolute;
            top: 20px;
            right: 30px;
            height: 30px;
        }
        .kop-space { height: 110px; }
        .kop { margin-bottom: 20px; }
        .kop img { height: 40px; }
        .kop .logo-kanan { float: right; height: 30px; }
        .judul { font-weight: bold; text-align: center; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 16px; }
        th, td { border: 1px solid #000; padding: 4px 8px; text-align: center; }
        .ttd { margin-top: 40px; width: 100%; }
        .ttd .jabatan { margin-bottom: 60px; }
        .footer { font-size: 10pt; color: #888; margin-top: 40px; }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('image/PosInd_Logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoData;
        $headerKananPath = public_path('image/Header_Kanan_SuratPengantar.png');
        $headerKananData = base64_encode(file_get_contents($headerKananPath));
        $headerKananSrc = 'data:image/png;base64,' . $headerKananData;
    @endphp
    <img src="{{ $logoSrc }}" alt="Logo Pos Indonesia" class="kop-logo-kiri">
    <img src="{{ $headerKananSrc }}" alt="Header Kanan" class="kop-logo-kanan">
    <div class="kop-space"></div>
    <div style="text-align: right; margin-bottom: 16px;">
        Bandung, {{ $tanggal_surat }}
    </div>
    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; width: 100%; max-width: 600px;">
        <div style="min-width: 180px;">Nomor    : {{ $nomor_surat_penerimaan }}</div>
    </div>
    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; width: 100%; max-width: 600px;">
        <div style="min-width: 180px;">Lampiran : -</div>
    </div>
    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; width: 100%; max-width: 600px;">
        <div style="min-width: 180px;">Perihal  : Persetujuan Permohonan Izin Magang</div>
    </div>
    <div style="text-align: right; margin-bottom: 16px;">
        Kepada Yth.<br>
        {{ $tujuan_surat }}
    </div>
    <div style="margin-bottom: 16px;">Dengan hormat,</div>
    <div style="margin-bottom: 16px; text-align: justify;">
        Merujuk pada surat permohonan izin magang dari {{ $asal_surat }} dengan nomor: {{ $nomor_surat_pengantar }} yang tertanggal {{ $tanggal_surat_pengantar }}, perihal permohonan izin magang mahasiswa/i di lingkungan PT. Pos Indonesia (Persero), dengan ini kami sampaikan bahwa permohonan tersebut <b>telah disetujui</b>.
    </div>
    <div style="margin-bottom: 16px; text-align: justify;">
        Persetujuan ini diberikan oleh divisi <b>{{ $divisi_mengeluarkan_surat }}</b> PT. Pos Indonesia (Persero), untuk pelaksanaan kegiatan magang oleh mahasiswa/i berikut:
    </div>
    <table>
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIM/NISN</th>
            <th>JURUSAN</th>
            <th>ASAL</th>
        </tr>
        <tr>
            <td>1.</td>
            <td>{{ $nama_peserta }}</td>
            <td>{{ $nim }}</td>
            <td>{{ $jurusan }}</td>
            <td>{{ $asal_surat }}</td>
        </tr>
    </table>
    <div style="margin-bottom: 16px; text-align: justify;">
        Untuk selanjutnya, apabila yang bersangkutan sudah selesai melaksanakan kerja praktik diharuskan melapor kepada kami untuk dibuatkan surat keterangan selesai dan sertifikat. Demikian kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.
    </div>
    <div style="width: 100px; margin-left: auto; margin-right: 60px; margin-top: 40px; text-align: left;">
        Hormat kami,<br>
        {{ $jabatan }}<br><br><br><br>
        <b>{{ $nama_pic }}</b><br>
        {{ $nippos }}
    </div>
    <div class="footer" style="position: absolute; bottom: 30px; left: 40px; font-size: 10pt; color: #888;">
        PT Pos Indonesia (Persero)<br>
        Kantor Pusat PT Pos Indonesia (Persero)<br>
        Jl. Cilaki No. 73 - Bandung 40115
    </div>
</body>
</html> 