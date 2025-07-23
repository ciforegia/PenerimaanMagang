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
            font-family: 'Anton';
            src: url('{{ storage_path('fonts/Anton-Regular.ttf') }}') format('truetype');
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
        .judul {
            font-family: 'Anton', Arial, sans-serif;
            font-size: 64px;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            color: #152d5d;
            margin-bottom: 24px;
        }
        .nomor {
            font-family: 'Times New Roman', Times, serif;
            font-size: 28px;
            color: #152d5d;
            text-align: left;
            margin-bottom: 12px;
            margin-top: 390px;
        }
        .subjudul {
            font-family: 'Times New Roman', Times, serif;
            font-size: 32px;
            color: #152d5d;
            margin-bottom: 24px;
        }
        .nama {
            font-family: 'Anton', Arial, sans-serif;
            font-size: 64px;
            color: #152d5d;
            font-weight: bold;
            margin-bottom: 12px;
        }
        .identitas {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 18px;
            color: #152d5d;
            margin-bottom: 16px;
        }
        .deskripsi {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 18px;
            color: #152d5d;
            margin-bottom: 24px;
            
        }
        .footer {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 18px;
            color: #152d5d;
            margin-top: 40px;
        }
        .ttd {
            margin-top: 60px;
            font-family: 'Sora', Arial, sans-serif;
            font-size: 18px;
            color: #152d5d;
        }
        .ttd .nama {
            font-family: 'Sora', Arial, sans-serif;
            font-size: 20px;
            font-weight: bold;
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
            {{ $start_date }} - {{ $end_date }} dengan hasil <b>{{ $predikat }}</b>.
        </div>
        <div class="footer">
            Bandung, {{ $tanggal_sertifikat }}<br>
            {{ $jabatan }}
        </div>
        <div class="ttd">
            <div class="nama">{{ $nama_pic }}</div>
            NIPPOS: {{ $nippos }}
        </div>
    </div>
</body>
</html> 