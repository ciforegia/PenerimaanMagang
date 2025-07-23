<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Penerimaan Magang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; }
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
    <div class="kop">
        <img src="{{ asset('image/PosInd_Logo.png') }}" alt="Logo Pos Indonesia" style="float: left; height: 40px;">
        <img src="{{ asset('image/Header_Kanan_SuratPengantar.png') }}" class="logo-kanan" alt="Header Kanan" style="float: right; height: 30px;">
        <div style="clear: both;"></div>
    </div>
    <div style="text-align: right; margin-bottom: 16px;">
        Bandung, {{ $tanggal_surat }}
    </div>
    <table style="width: 60%; margin-bottom: 16px;">
        <tr><td style="width: 120px;">Nomor</td><td>: {{ $nomor_surat_penerimaan }}</td></tr>
        <tr><td>Lampiran</td><td>: -</td></tr>
        <tr><td>Perihal</td><td>: Persetujuan Permohonan Izin Magang</td></tr>
    </table>
    <div style="margin-bottom: 16px;">Kepada Yth.</div>
    <div style="margin-bottom: 16px;">Dengan hormat,</div>
    <div style="margin-bottom: 16px;">
        Merujuk pada surat permohonan izin magang dari {{ $asal_surat }} dengan nomor: {{ $nomor_surat_pengantar }} yang tertanggal {{ $tanggal_surat_pengantar }}, perihal permohonan izin magang mahasiswa/i di lingkungan PT. Pos Indonesia (Persero), dengan ini kami sampaikan bahwa permohonan tersebut <b>telah disetujui</b>.
    </div>
    <div style="margin-bottom: 16px;">
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
    <div style="margin-bottom: 16px;">
        Untuk selanjutnya, apabila yang bersangkutan sudah selesai melaksanakan kerja praktik diharuskan melapor kepada kami untuk dibuatkan surat keterangan selesai dan sertifikat. Demikian kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.
    </div>
    <table class="ttd">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: left;">
                Hormat kami,<br>
                {{ $jabatan }}<br><br><br><br><br>
                <b>{{ $nama_pic }}</b><br>
                {{ $nippos }}
            </td>
        </tr>
    </table>
    <div class="footer">
        PT Pos Indonesia (Persero)<br>
        Kantor Pusat PT Pos Indonesia (Persero)<br>
        Jl. Cilaki No. 73 - Bandung 40115
    </div>
</body>
</html> 