# Diagram Alur Detail Per Menu/Fitur Sistem Penerimaan Magang

## 1. Diagram Alur Menu Dashboard Peserta

```mermaid
graph TD
    A[Peserta Login] --> B[Dashboard Peserta]
    B --> C{Status Pengajuan}
    
    C -->|Belum Ada| D[Menu Program Magang]
    C -->|Pending| E[Menu Status]
    C -->|Accepted| F[Menu Status + Upload Dokumen]
    C -->|Finished| G[Menu Sertifikat]
    
    D --> D1[Lihat Daftar Divisi]
    D1 --> D2[Pilih Divisi]
    D2 --> D3[Form Pengajuan]
    D3 --> D4[Submit Pengajuan]
    D4 --> E
    
    E --> E1[Lihat Status]
    E1 --> E2{Status Saat Ini}
    E2 -->|Pending| E3[Menunggu Review]
    E2 -->|Accepted| F
    E2 -->|Rejected| E4[Lihat Alasan]
    E2 -->|Postponed| E5[Lihat Alasan]
    
    F --> F1[Download Surat Penerimaan]
    F1 --> F2[Upload Dokumen Tambahan]
    F2 --> F3[Menunggu Mulai Magang]
    F3 --> G
    
    G --> G1[Lihat Sertifikat]
    G1 --> G2[Download Sertifikat]
    G2 --> G3[Verifikasi QR Code]
    
    E4 --> H[Pengajuan Ulang]
    E5 --> H
    H --> D
```

## 2. Diagram Alur Menu Penugasan Peserta

```mermaid
graph TD
    A[Menu Penugasan] --> B[Lihat Daftar Tugas]
    B --> C{Tugas Tersedia?}
    
    C -->|Tidak| D[Menunggu Penugasan]
    C -->|Ya| E[Pilih Tugas]
    
    E --> F[Lihat Detail Tugas]
    F --> F1[Judul Tugas]
    F1 --> F2[Deskripsi]
    F2 --> F3[Deadline]
    F3 --> F4[File Tugas]
    F4 --> F5[Text Online]
    
    F5 --> G[Download File Tugas]
    G --> H[Kerjakan Tugas]
    H --> I[Submit Jawaban]
    
    I --> I1[Upload File Jawaban]
    I1 --> I2[Input Keterangan]
    I2 --> I3[Submit]
    
    I3 --> J[Konfirmasi Submit]
    J --> K[Notifikasi ke Pembimbing]
    K --> L[Menunggu Penilaian]
    
    L --> M[Lihat Status Tugas]
    M --> N{Status Tugas}
    N -->|Dinilai| O[Lihat Nilai & Feedback]
    N -->|Revisi| P[Lihat Feedback Revisi]
    N -->|Menunggu| L
    
    P --> Q[Revisi Tugas]
    Q --> I
    
    O --> R{Tugas Lain?}
    R -->|Ya| E
    R -->|Tidak| S[Selesai]
    
    D --> T[Refresh Halaman]
    T --> B
```

## 3. Diagram Alur Menu Dashboard Pembimbing

```mermaid
graph TD
    A[Pembimbing Login] --> B[Dashboard Pembimbing]
    B --> C[Statistik Overview]
    C --> C1[Pengajuan Baru]
    C1 --> C2[Peserta Aktif]
    C2 --> C3[Tugas Perlu Dinilai]
    C3 --> C4[Peserta Selesai]
    
    C4 --> D[Menu Utama]
    D --> E[Menu Pengajuan]
    D --> F[Menu Penugasan]
    D --> G[Menu Sertifikat]
    D --> H[Menu Profil]
    
    E --> E1[Lihat Daftar Pengajuan]
    E1 --> E2[Filter Status]
    E2 --> E3[Review Pengajuan]
    E3 --> E4[Respon Pengajuan]
    
    F --> F1[Lihat Peserta Aktif]
    F1 --> F2[Berikan Penugasan]
    F2 --> F3[Monitor Progress]
    F3 --> F4[Nilai Tugas]
    
    G --> G1[Lihat Peserta Selesai]
    G1 --> G2[Generate Sertifikat]
    G2 --> G3[Upload Sertifikat]
    
    H --> H1[Lihat Profil]
    H1 --> H2[Update Data]
    H2 --> H3[Simpan Perubahan]
```

## 4. Diagram Alur Menu Review Pengajuan

```mermaid
graph TD
    A[Menu Pengajuan] --> B[Lihat Daftar Pengajuan]
    B --> C[Filter & Sort]
    C --> C1[Filter Status]
    C1 --> C2[Sort Tanggal]
    C2 --> C3[Search Nama]
    
    C3 --> D[Pilih Pengajuan]
    D --> E[Lihat Detail Lengkap]
    E --> E1[Data Peserta]
    E1 --> E2[Dokumen KTM]
    E2 --> E3[Divisi Tujuan]
    E3 --> E4[Periode Magang]
    E4 --> E5[Surat Pengantar]
    
    E5 --> F[Evaluasi Pengajuan]
    F --> F1[Cek Kelengkapan Data]
    F1 --> F2[Cek Kualitas Dokumen]
    F2 --> F3[Cek Kesesuaian Divisi]
    F3 --> F4[Cek Periode Magang]
    
    F4 --> G{Decision}
    G -->|Terima| H[Form Terima]
    G -->|Tolak| I[Form Tolak]
    G -->|Tunda| J[Form Tunda]
    
    H --> H1[Update Status: Accepted]
    H1 --> H2[Set Divisi User]
    H2 --> H3[Generate Surat Penerimaan]
    H3 --> H4[Notifikasi ke Peserta]
    
    I --> I1[Input Alasan Penolakan]
    I1 --> I2[Update Status: Rejected]
    I2 --> I3[Notifikasi ke Peserta]
    
    J --> J1[Input Alasan Penundaan]
    J1 --> J2[Update Status: Postponed]
    J2 --> J3[Notifikasi ke Peserta]
    
    H4 --> K[Update Dashboard]
    I3 --> K
    J3 --> K
    K --> L[Kembali ke Daftar]
```

## 5. Diagram Alur Menu Penugasan Pembimbing

```mermaid
graph TD
    A[Menu Penugasan] --> B[Lihat Peserta Aktif]
    B --> C[Filter Peserta]
    C --> C1[Filter Berdasarkan Status]
    C1 --> C2[Filter Berdasarkan Divisi]
    C2 --> C3[Search Nama]
    
    C3 --> D[Pilih Peserta]
    D --> E[Lihat Detail Peserta]
    E --> E1[Data Pribadi]
    E1 --> E2[Status Magang]
    E2 --> E3[Riwayat Tugas]
    E3 --> E4[Progress Magang]
    
    E4 --> F[Action Menu]
    F --> F1[Tambah Penugasan]
    F --> F2[Lihat Tugas]
    F --> F3[Monitor Progress]
    
    F1 --> F1A[Form Penugasan]
    F1A --> F1B[Judul Tugas]
    F1B --> F1C[Deskripsi]
    F1C --> F1D[Deadline]
    F1D --> F1E[Upload File]
    F1E --> F1F[Text Online]
    F1F --> F1G[Submit]
    
    F2 --> F2A[Daftar Tugas]
    F2A --> F2B[Status Tugas]
    F2B --> F2C[Detail Tugas]
    F2C --> F2D[Download Jawaban]
    F2D --> F2E[Nilai Tugas]
    
    F3 --> F3A[Progress Overview]
    F3A --> F3B[Statistik Tugas]
    F3B --> F3C[Timeline Magang]
    F3C --> F3D[Evaluasi Keseluruhan]
    
    F1G --> G[Notifikasi ke Peserta]
    F2E --> H[Update Nilai]
    F3D --> I[Generate Laporan]
    
    G --> J[Refresh Data]
    H --> J
    I --> J
    J --> B
```

## 6. Diagram Alur Menu Penilaian Tugas

```mermaid
graph TD
    A[Lihat Tugas] --> B[Pilih Tugas untuk Dinilai]
    B --> C[Download Jawaban]
    C --> D[Evaluasi Kualitas]
    D --> D1[Cek Kelengkapan]
    D1 --> D2[Cek Kualitas Jawaban]
    D2 --> D3[Cek Kesesuaian dengan Soal]
    D3 --> D4[Cek Ketepatan Waktu]
    
    D4 --> E{Decision Penilaian}
    E -->|Nilai Langsung| F[Form Penilaian]
    E -->|Perlu Revisi| G[Form Revisi]
    E -->|Feedback Saja| H[Form Feedback]
    
    F --> F1[Input Nilai 0-100]
    F1 --> F2[Input Feedback]
    F2 --> F3[Simpan Penilaian]
    F3 --> F4[Notifikasi ke Peserta]
    
    G --> G1[Input Feedback Revisi]
    G1 --> G2[Set Status Revisi]
    G2 --> G3[Simpan Status]
    G3 --> G4[Notifikasi ke Peserta]
    
    H --> H1[Input Feedback]
    H1 --> H2[Simpan Feedback]
    H2 --> H3[Notifikasi ke Peserta]
    
    F4 --> I[Update Dashboard]
    G4 --> I
    H3 --> I
    I --> J[Lihat Tugas Lain]
    J --> K{Ada Tugas Lain?}
    K -->|Ya| B
    K -->|Tidak| L[Selesai]
```

## 7. Diagram Alur Menu Sertifikat Pembimbing

```mermaid
graph TD
    A[Menu Sertifikat] --> B[Lihat Peserta Selesai]
    B --> C[Filter Peserta]
    C --> C1[Filter Berdasarkan Status]
    C1 --> C2[Filter Berdasarkan Periode]
    C2 --> C3[Search Nama]
    
    C3 --> D[Pilih Peserta]
    D --> E[Cek Kelayakan Sertifikat]
    E --> E1{Semua Tugas Dinilai?}
    E1 -->|Tidak| E2[Pesan: Masih Ada Tugas Belum Dinilai]
    E1 -->|Ya| E3{Tidak Ada Status Revisi?}
    
    E3 -->|Ada| E4[Pesan: Masih Ada Tugas Perlu Revisi]
    E3 -->|Tidak| F[Form Sertifikat]
    
    F --> F1[Nomor Sertifikat]
    F1 --> F2[Predikat]
    F2 --> F3[Preview Sertifikat]
    F3 --> F4[Generate PDF]
    F4 --> F5[Upload Sertifikat]
    
    F5 --> G[Notifikasi ke Peserta]
    G --> H[Peserta Download Sertifikat]
    H --> I[Verifikasi QR Code]
    I --> J[Sertifikat Valid]
    
    E2 --> K[Lanjutkan Penilaian]
    E4 --> L[Selesaikan Revisi]
    K --> M[Set Status Revisi = 0]
    L --> N[Peserta Submit Final]
    M --> O[Peserta Revisi Tugas]
    N --> P[Pembimbing Finalisasi]
    O --> Q[Submit Revisi]
    P --> E
    Q --> R[Pembimbing Nilai Ulang]
    R --> E
```

## 8. Diagram Alur Menu Dashboard Admin

```mermaid
graph TD
    A[Admin Login] --> B[Dashboard Admin]
    B --> C[Statistik Overview]
    C --> C1[Total Peserta]
    C1 --> C2[Total Pengajuan]
    C2 --> C3[Total Selesai]
    C3 --> C4[Distribusi per Divisi]
    
    C4 --> D[Menu Utama]
    D --> E[Menu Applications]
    D --> F[Menu Participants]
    D --> G[Menu Divisions]
    D --> H[Menu Mentors]
    D --> I[Menu Reports]
    D --> J[Menu Rules]
    
    E --> E1[Lihat Semua Pengajuan]
    E1 --> E2[Filter & Search]
    E2 --> E3[Export Data]
    
    F --> F1[Lihat Semua Peserta]
    F1 --> F2[Filter Berdasarkan Status]
    F2 --> F3[Lihat Detail Peserta]
    F3 --> F4[Export Data Peserta]
    
    G --> G1[Kelola Direktorat]
    G1 --> G2[Kelola Sub Direktorat]
    G2 --> G3[Kelola Divisi]
    G3 --> G4[Auto Generate Pembimbing]
    
    H --> H1[Lihat Daftar Pembimbing]
    H1 --> H2[Reset Password]
    H2 --> H3[Update Data Pembimbing]
    
    I --> I1[Generate Report]
    I1 --> I2[Filter Data]
    I2 --> I3[Export PDF/Excel]
    
    J --> J1[Edit Peraturan]
    J1 --> J2[Update Konten]
    J2 --> J3[Simpan Perubahan]
```

## 9. Diagram Alur Menu Kelola Divisi

```mermaid
graph TD
    A[Menu Divisions] --> B[Lihat Struktur Organisasi]
    B --> C[Tree View]
    C --> C1[Direktorat]
    C1 --> C2[Sub Direktorat]
    C2 --> C3[Divisi]
    
    C3 --> D[Action Menu]
    D --> D1[Tambah Direktorat]
    D --> D2[Tambah Sub Direktorat]
    D --> D3[Tambah Divisi]
    D --> D4[Edit Data]
    D --> D5[Hapus Data]
    
    D1 --> D1A[Form Direktorat]
    D1A --> D1B[Nama Direktorat]
    D1B --> D1C[Simpan]
    
    D2 --> D2A[Form Sub Direktorat]
    D2A --> D2B[Nama Sub Direktorat]
    D2B --> D2C[Pilih Direktorat]
    D2C --> D2D[Simpan]
    
    D3 --> D3A[Form Divisi]
    D3A --> D3B[Nama Divisi]
    D3B --> D3C[Pilih Sub Direktorat]
    D3C --> D3D[VP Name]
    D3D --> D3E[NIPPOS]
    D3E --> D3F[Simpan]
    D3F --> D3G[Auto Generate Pembimbing]
    
    D4 --> D4A[Edit Form]
    D4A --> D4B[Update Data]
    D4B --> D4C[Simpan Perubahan]
    
    D5 --> D5A[Cek Dependencies]
    D5A --> D5B{Ada Data Terkait?}
    D5B -->|Ya| D5C[Error: Tidak Bisa Hapus]
    D5B -->|Tidak| D5D[Konfirmasi Hapus]
    D5D --> D5E[Hapus Data]
    
    D1C --> F[Refresh Tree]
    D2D --> F
    D3G --> F
    D4C --> F
    D5E --> F
    D5C --> G[Kembali ke Menu]
    F --> B
```

## 10. Diagram Alur Menu Reports

```mermaid
graph TD
    A[Menu Reports] --> B[Filter Options]
    B --> B1[Pilih Periode]
    B1 --> B2[Pilih Klasifikasi]
    B2 --> B3[Pilih Status]
    B3 --> B4[Pilih Tahun]
    
    B4 --> C[Generate Query]
    C --> D[Ambil Data]
    D --> D1[Data Peserta]
    D1 --> D2[Data Pengajuan]
    D2 --> D3[Data Penugasan]
    D3 --> D4[Data Sertifikat]
    
    D4 --> E[Proses Data]
    E --> E1[Grouping Data]
    E1 --> E2[Calculations]
    E2 --> E3[Format Output]
    
    E3 --> F[Display Results]
    F --> F1[Tabel Data]
    F1 --> F2[Chart Visualisasi]
    F2 --> F3[Statistik Summary]
    
    F3 --> G[Export Options]
    G --> G1[Export PDF]
    G --> G2[Export Excel]
    G --> G3[Print Report]
    
    G1 --> H1[Generate PDF]
    G2 --> H2[Generate Excel]
    G3 --> H3[Print Preview]
    
    H1 --> I[Download PDF]
    H2 --> J[Download Excel]
    H3 --> K[Print Document]
    
    I --> L[Selesai]
    J --> L
    K --> L
```

## 11. Diagram Alur Menu Upload Dokumen Tambahan

```mermaid
graph TD
    A[Status: Accepted] --> B[Notifikasi Upload Dokumen]
    B --> C[Peserta Akses Menu Status]
    C --> D[Lihat Persyaratan]
    D --> D1[Surat Pengantar]
    D1 --> D2[Foto Nametag]
    D2 --> D3[Screenshot PosPay]
    D3 --> D4[Foto Prangko Prisma]
    D4 --> D5[Screenshot Follow IG Museum]
    D5 --> D6[Screenshot Follow IG Pos Indonesia]
    D6 --> D7[Screenshot Subscribe YouTube]
    
    D7 --> E[Form Upload]
    E --> E1[Upload Surat Pengantar]
    E1 --> E2[Upload Foto Nametag]
    E2 --> E3[Upload Screenshot PosPay]
    E3 --> E4[Upload Foto Prangko Prisma]
    E4 --> E5[Upload Screenshot Follow IG Museum]
    E5 --> E6[Upload Screenshot Follow IG Pos Indonesia]
    E6 --> E7[Upload Screenshot Subscribe YouTube]
    
    E7 --> F[Validasi File]
    F --> F1{Cek Format File}
    F1 -->|Valid| F2{Cek Ukuran File}
    F1 -->|Invalid| F3[Error: Format Salah]
    
    F2 -->|Valid| F4[Simpan File]
    F2 -->|Invalid| F5[Error: File Terlalu Besar]
    
    F3 --> G[Kembali ke Form]
    F5 --> G
    G --> E1
    
    F4 --> H[Update Database]
    H --> I[Notifikasi ke Pembimbing]
    I --> J[Pembimbing Verifikasi]
    J --> K[Dokumen Lengkap]
    K --> L[Proses Lanjutan]
```

## 12. Diagram Alur Menu Re-application

```mermaid
graph TD
    A[Peserta dengan Riwayat] --> B[Login Dashboard]
    B --> C[Menu Program Magang]
    C --> D{Cek Status Terakhir}
    
    D -->|Selesai| E[Form Re-application]
    D -->|Masih Aktif| F[Pesan: Masih Ada Magang Aktif]
    D -->|Ditolak| E
    D -->|Ditunda| E
    
    E --> E1[Pilih Divisi Baru]
    E1 --> E2[Set Periode Baru]
    E2 --> E3[Validasi Periode]
    E3 --> E4{Periode Valid?}
    
    E4 -->|Tidak| E5[Error: Periode Tidak Valid]
    E4 -->|Ya| E6[Submit Re-application]
    
    E5 --> E2
    E6 --> E7[Status: Pending]
    E7 --> G[Notifikasi ke Pembimbing]
    
    G --> H[Pembimbing Review]
    H --> I{Decision}
    I -->|Terima| J[Status: Accepted]
    I -->|Tolak| K[Status: Rejected]
    
    J --> L[Proses Magang Baru]
    K --> M[Notifikasi Penolakan]
    
    F --> N[Kembali ke Dashboard]
    M --> N
    L --> O[Periode Magang Aktif]
    O --> P[Proses Normal Magang]
```

## 13. Diagram Alur Menu Surat Penerimaan

```mermaid
graph TD
    A[Pengajuan Diterima] --> B[Pembimbing Generate Surat]
    B --> C[Form Surat Penerimaan]
    C --> C1[Nomor Surat Penerimaan]
    C1 --> C2[Nomor Surat Pengantar]
    C2 --> C3[Tanggal Surat Pengantar]
    C3 --> C4[Tujuan Surat]
    C4 --> C5[Preview Surat]
    
    C5 --> D[Generate PDF]
    D --> D1[QR Code Generation]
    D1 --> D2[Data QR Code]
    D2 --> D3[Generate QR Image]
    D3 --> D4[Embed QR ke PDF]
    
    D4 --> E[Upload ke Storage]
    E --> E1[Simpan ke Database]
    E1 --> E2[Update Status]
    
    E2 --> F[Notifikasi ke Peserta]
    F --> G[Peserta Download Surat]
    G --> H[Verifikasi QR Code]
    H --> I[Surat Valid]
    
    I --> J[Update Status Download]
    J --> K[Proses Lanjutan]
```

## 14. Diagram Alur Menu Monitoring Sistem

```mermaid
graph TD
    A[Admin Dashboard] --> B[Menu Monitoring]
    B --> C[Real-time Statistics]
    C --> C1[Active Users]
    C1 --> C2[Pending Applications]
    C2 --> C3[Active Internships]
    C3 --> C4[Completed Internships]
    
    C4 --> D[System Health]
    D --> D1[Database Status]
    D1 --> D2[Storage Usage]
    D2 --> D3[Performance Metrics]
    D3 --> D4[Error Logs]
    
    D4 --> E[User Activity]
    E --> E1[Login Activity]
    E1 --> E2[Action Logs]
    E2 --> E3[File Uploads]
    E3 --> E4[Download Activity]
    
    E4 --> F[Alerts & Notifications]
    F --> F1[System Alerts]
    F1 --> F2[User Notifications]
    F2 --> F3[Error Notifications]
    F3 --> F4[Performance Alerts]
    
    F4 --> G[Reports & Analytics]
    G --> G1[Usage Reports]
    G1 --> G2[Performance Reports]
    G2 --> G3[User Behavior Analytics]
    G3 --> G4[System Utilization]
    
    G4 --> H[Export & Archive]
    H --> H1[Export Logs]
    H1 --> H2[Archive Data]
    H2 --> H3[Backup Status]
    H3 --> H4[Cleanup Tasks]
    
    H4 --> I[Update Dashboard]
    I --> J[Refresh Data]
    J --> B
```

## 15. Diagram Alur Menu Profil Pembimbing

```mermaid
graph TD
    A[Menu Profil] --> B[Lihat Data Profil]
    B --> B1[Nama Lengkap]
    B1 --> B2[Username]
    B2 --> B3[Email]
    B3 --> B4[Divisi]
    B4 --> B5[Sub Direktorat]
    B5 --> B6[Direktorat]
    
    B6 --> C[Action Menu]
    C --> C1[Edit Profil]
    C --> C2[Ubah Password]
    C --> C3[Lihat Statistik]
    
    C1 --> C1A[Form Edit]
    C1A --> C1B[Update Nama]
    C1B --> C1C[Update Email]
    C1C --> C1D[Simpan Perubahan]
    
    C2 --> C2A[Form Ubah Password]
    C2A --> C2B[Password Lama]
    C2B --> C2C[Password Baru]
    C2C --> C2D[Konfirmasi Password]
    C2D --> C2E[Simpan Password]
    
    C3 --> C3A[Statistik Pengajuan]
    C3A --> C3B[Statistik Peserta]
    C3B --> C3C[Statistik Tugas]
    C3C --> C3D[Statistik Sertifikat]
    
    C1D --> D[Notifikasi: Profil Diperbarui]
    C2E --> E[Notifikasi: Password Diperbarui]
    C3D --> F[Lihat Detail Statistik]
    
    D --> G[Refresh Profil]
    E --> G
    F --> G
    G --> B
```

## Kesimpulan

Diagram alur detail per menu ini memberikan panduan lengkap untuk setiap fitur dalam sistem penerimaan magang, mencakup:

1. **Dashboard Peserta** - Navigasi utama untuk peserta magang
2. **Menu Penugasan** - Alur pengerjaan tugas oleh peserta
3. **Dashboard Pembimbing** - Interface utama pembimbing
4. **Review Pengajuan** - Proses evaluasi pengajuan
5. **Penugasan Pembimbing** - Pemberian dan monitoring tugas
6. **Penilaian Tugas** - Evaluasi dan feedback tugas
7. **Sertifikat Pembimbing** - Penerbitan sertifikat
8. **Dashboard Admin** - Interface administrasi
9. **Kelola Divisi** - Manajemen struktur organisasi
10. **Reports** - Pelaporan dan analisis
11. **Upload Dokumen** - Proses dokumen tambahan
12. **Re-application** - Pengajuan ulang
13. **Surat Penerimaan** - Generate surat resmi
14. **Monitoring Sistem** - Pemantauan sistem
15. **Profil Pembimbing** - Manajemen profil

Setiap diagram menunjukkan alur yang detail dengan validasi, error handling, dan feedback yang memastikan pengalaman pengguna yang optimal.
