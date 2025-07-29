<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang</title>
    <style>
        @page {
            size: 2000px 1414px;
            margin: 0;
        }
        html, body {
            width: 2000px;
            height: 1414px;
            margin: 0;
            padding: 0;
        }
        @font-face {
            font-family: 'Sora';
            src: url('{{ storage_path('fonts/Sora-VariableFont_wght.ttf') }}') format('truetype');
        }
        body {
            font-family: 'Sora', 'Times New Roman', Times, serif;
            color: #152d5d;
            position: relative;
            width: 2000px;
            height: 1414px;
        }
        .bg {
            position: absolute;
            left: 0; top: 0; width: 2000px; height: 1414px;
            z-index: 0;
        }
        .content {
            position: relative;
            z-index: 1;
            width: 1800px;
            margin: 0 auto;
            padding-top: 60px;
        }
        .nomor {
            font-family: 'Times New Roman', Times, serif;
            font-size: 50px;
            color: #152d5d;
            text-align: left;
            margin-bottom: 12px;
            margin-top: 390px;
            margin-left: 134px;
        }
        .subjudul {
            font-family: 'Times New Roman', Times, serif;
            font-size: 40px;
            color: #152d5d;
            text-align: left;
            margin-bottom: 24px;
            margin-top: 0px;
            margin-left: 134px;
        }
        .nama {
            font-family: 'anton_normal';
            font-size: 80px;
            color: #152d5d;
            font-weight: bold;
            margin-bottom: 12px;
            margin-left: 134px;
            text-transform: uppercase;
        }
        .identitas {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            color: #152d5d;
            margin-bottom: 16px;
            margin-left: 134px;
            text-transform: uppercase;
        }
        .deskripsi {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            color: #152d5d;
            margin-bottom: 24px;
            margin-left: 134px;
            margin-right: 150px;
        }
        .footer {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            color: #152d5d;
            margin-top: 20px;
            margin-left: 134px;
        }
        .footer .jabatan{
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            color: #152d5d;
            margin-top: 20px;
        }
        .ttd {
            margin-top: 5px;
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            color: #152d5d;
            margin-left: 134px;
        }
        .ttd .nama {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 28px;
            font-weight: bold;
            margin-top: 0px;
            margin-left: 0px;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('image/background_sertifikat.png') }}" class="bg">
    <div class="content">
        <div class="nomor">{{ $nomor_sertifikat }}</div>
        <div class="subjudul">Sertifikat ini diberikan kepada :</div>
        <div class="nama">{{ $nama }}</div>
        <div class="identitas">{{ $universitas }}, {{ $jurusan }}, {{ $nim }}</div>
        <div class="deskripsi">
            Sebagai ucapan terima kasih atas kegiatan Praktik Kerja Lapangan di PT Pos Indonesia (Persero) pada tanggal
            {{ $start_date }} hingga {{ $end_date }} dengan hasil <b>{{ $predikat }}</b>.
        </div>
        <div class="footer">
            Bandung, {{ $tanggal_sertifikat }}
            <div class="jabatan">{{ $jabatan }}</div>
            <img src="{{ $qr_base64 }}" alt="QR Code" width="250" height="250" style="margin-top: 5px;" />
        </div>
        <div class="ttd">
            <div class="nama">{{ $nama_pic }}</div>
            NIPPOS: {{ $nippos }}
        </div>
    </div>
</body>
</html> 