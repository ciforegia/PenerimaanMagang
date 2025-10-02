# Diagram Proses Bisnis Sistem Penerimaan Magang PT Pos Indonesia

## 1. Diagram BPMN Utama - Alur Lengkap Sistem

```mermaid
graph TD
    Start([Mulai]) --> A[Peserta Mengakses Website]
    A --> B{Status Pengguna}
    
    B -->|Belum Terdaftar| C[Registrasi Akun]
    B -->|Sudah Terdaftar| D[Login]
    
    C --> C1[Isi Form Registrasi]
    C1 --> C2[Upload KTM]
    C2 --> C3[Pilih Divisi]
    C3 --> C4[Set Tanggal Magang]
    C4 --> C5[Submit Registrasi]
    C5 --> C6[Auto Login]
    C6 --> E[Dashboard Peserta]
    
    D --> D1{Validasi Login}
    D1 -->|Berhasil| D2{Peran User}
    D1 -->|Gagal| A
    
    D2 -->|Peserta| E
    D2 -->|Pembimbing| F[Dashboard Pembimbing]
    D2 -->|Admin| G[Dashboard Admin]
    
    E --> E1{Status Pengajuan}
    E1 -->|Belum Ada| E2[Lihat Program Magang]
    E1 -->|Pending| E3[Lihat Status Pengajuan]
    E1 -->|Diterima| E4[Upload Dokumen Tambahan]
    E1 -->|Selesai| E5[Download Sertifikat]
    
    E2 --> E2A[Pilih Divisi]
    E2A --> E2B[Upload Surat Pengantar]
    E2B --> E2C[Submit Pengajuan]
    E2C --> E3
    
    E3 --> E3A{Status Pengajuan}
    E3A -->|Pending| E3B[Menunggu Review Pembimbing]
    E3A -->|Diterima| E4
    E3A -->|Ditolak| E3C[Lihat Alasan Penolakan]
    E3A -->|Ditunda| E3D[Lihat Alasan Penundaan]
    
    E4 --> E4A[Download Surat Penerimaan]
    E4A --> E4B[Upload Dokumen Tambahan]
    E4B --> E4C[Menunggu Mulai Magang]
    E4C --> E5A[Periode Magang Aktif]
    
    E5A --> E5B[Terima Penugasan]
    E5B --> E5C[Submit Tugas]
    E5C --> E5D{Status Tugas}
    E5D -->|Dinilai| E5E[Lihat Nilai & Feedback]
    E5D -->|Revisi| E5F[Revisi Tugas]
    E5F --> E5C
    E5E --> E5G{Periode Selesai?}
    E5G -->|Belum| E5B
    E5G -->|Ya| E5H[Status Finished]
    E5H --> E5[Download Sertifikat]
    
    F --> F1[Lihat Pengajuan Baru]
    F1 --> F2{Ada Pengajuan?}
    F2 -->|Ya| F3[Review Pengajuan]
    F2 -->|Tidak| F4[Lihat Peserta Aktif]
    
    F3 --> F3A{Decision}
    F3A -->|Terima| F3B[Update Status: Accepted]
    F3A -->|Tolak| F3C[Update Status: Rejected + Alasan]
    F3A -->|Tunda| F3D[Update Status: Postponed + Alasan]
    
    F3B --> F3E[Generate Surat Penerimaan]
    F3E --> F3F[Kirim ke Peserta]
    F3F --> F4
    
    F4 --> F4A[Lihat Peserta Magang]
    F4A --> F4B[Berikan Penugasan]
    F4B --> F4C[Monitor Progress]
    F4C --> F4D[Nilai Tugas]
    F4D --> F4E{Perlu Revisi?}
    F4E -->|Ya| F4F[Set Status Revisi]
    F4E -->|Tidak| F4G[Finalisasi Nilai]
    F4F --> F4C
    F4G --> F4H{Periode Selesai?}
    F4H -->|Belum| F4B
    F4H -->|Ya| F4I[Generate Sertifikat]
    F4I --> F4J[Upload Sertifikat]
    
    G --> G1[Lihat Dashboard Admin]
    G1 --> G2[Kelola Divisi/Direktorat]
    G2 --> G3[Kelola Pembimbing]
    G3 --> G4[Lihat Laporan]
    G4 --> G5[Export Report]
    G5 --> G6[Kelola Peraturan]
    
    E5 --> End([Selesai])
    F4J --> End
    G6 --> End
    E3C --> E2
    E3D --> E2
```

## 2. Diagram Alur Detail - Proses Registrasi

```mermaid
graph TD
    A[Peserta Akses Halaman Registrasi] --> B[Isi Data Pribadi]
    B --> B1[Nama Lengkap]
    B1 --> B2[Username]
    B2 --> B3[Email]
    B3 --> B4[Password]
    B4 --> B5[NIM]
    B5 --> B6[Universitas]
    B6 --> B7[Jurusan]
    B7 --> B8[No. Telepon]
    B8 --> B9[No. KTP]
    
    B9 --> C[Upload Dokumen]
    C --> C1[Upload KTM]
    C1 --> C2{Validasi File}
    C2 -->|Valid| C3[Simpan File]
    C2 -->|Invalid| C4[Error: Format File Salah]
    C4 --> C1
    
    C3 --> D[Pilih Divisi]
    D --> D1[Lihat Daftar Divisi]
    D1 --> D2[Pilih Divisi Tujuan]
    D2 --> D3[Lihat Detail Divisi]
    
    D3 --> E[Set Periode Magang]
    E --> E1[Tanggal Mulai]
    E1 --> E2[Tanggal Selesai]
    E2 --> E3{Validasi Tanggal}
    E3 -->|Valid| E4[Submit Form]
    E3 -->|Invalid| E5[Error: Tanggal Tidak Valid]
    E5 --> E1
    
    E4 --> F[Validasi Data]
    F --> F1{Username Unique?}
    F1 -->|Tidak| F2[Error: Username Sudah Ada]
    F1 -->|Ya| F3{Email Unique?}
    F3 -->|Tidak| F4[Error: Email Sudah Ada]
    F3 -->|Ya| F5{Password Valid?}
    F5 -->|Tidak| F6[Error: Password Tidak Memenuhi Kriteria]
    F5 -->|Ya| F7[Simpan Data User]
    
    F2 --> B2
    F4 --> B3
    F6 --> B4
    
    F7 --> G[Buat Pengajuan Magang]
    G --> G1[Status: Pending]
    G1 --> G2[Auto Login User]
    G2 --> H[Redirect ke Dashboard]
    H --> I[Notifikasi: Registrasi Berhasil]
```

## 3. Diagram Alur Detail - Proses Review Pengajuan

```mermaid
graph TD
    A[Pembimbing Login] --> B[Dashboard Pembimbing]
    B --> C[Menu Pengajuan]
    C --> D[Lihat Daftar Pengajuan]
    D --> E{Ada Pengajuan Baru?}
    
    E -->|Tidak| F[Lihat Pengajuan Lama]
    E -->|Ya| G[Pilih Pengajuan]
    
    G --> H[Lihat Detail Pengajuan]
    H --> H1[Data Peserta]
    H1 --> H2[Dokumen KTM]
    H2 --> H3[Divisi Tujuan]
    H3 --> H4[Periode Magang]
    H4 --> H5[Surat Pengantar]
    
    H5 --> I{Decision Review}
    I -->|Terima| J[Update Status: Accepted]
    I -->|Tolak| K[Update Status: Rejected]
    I -->|Tunda| L[Update Status: Postponed]
    
    J --> J1[Set Divisi User]
    J1 --> J2[Generate Surat Penerimaan]
    J2 --> J3[Upload Surat Penerimaan]
    J3 --> J4[Notifikasi ke Peserta]
    J4 --> M[Update Dashboard]
    
    K --> K1[Input Alasan Penolakan]
    K1 --> K2[Notifikasi ke Peserta]
    K2 --> M
    
    L --> L1[Input Alasan Penundaan]
    L1 --> L2[Notifikasi ke Peserta]
    L2 --> M
    
    M --> N[Lihat Status Update]
    N --> O[Kembali ke Daftar Pengajuan]
    O --> P{Ada Pengajuan Lain?}
    P -->|Ya| G
    P -->|Tidak| Q[Selesai]
    
    F --> R[Lihat Riwayat Pengajuan]
    R --> S[Filter Berdasarkan Status]
    S --> T[Export Data]
    T --> Q
```

## 4. Diagram Alur Detail - Proses Penugasan dan Penilaian

```mermaid
graph TD
    A[Pembimbing Login] --> B[Dashboard Pembimbing]
    B --> C[Menu Penugasan]
    C --> D[Lihat Peserta Aktif]
    D --> E{Peserta Mulai Magang?}
    
    E -->|Belum| F[Pesan: Peserta Belum Mulai Magang]
    E -->|Ya| G[Pilih Peserta]
    
    G --> H[Form Penugasan]
    H --> H1[Judul Tugas]
    H1 --> H2[Deskripsi Tugas]
    H2 --> H3[Deadline]
    H3 --> H4[Upload File Tugas]
    H4 --> H5[Text Online]
    H5 --> H6[Submit Penugasan]
    
    H6 --> I[Notifikasi ke Peserta]
    I --> J[Peserta Terima Notifikasi]
    J --> K[Peserta Lihat Tugas]
    K --> L[Peserta Download File]
    L --> M[Peserta Kerjakan Tugas]
    M --> N[Peserta Submit Tugas]
    
    N --> N1[Upload File Jawaban]
    N1 --> N2[Input Keterangan]
    N2 --> N3[Submit Jawaban]
    N3 --> O[Notifikasi ke Pembimbing]
    
    O --> P[Pembimbing Review Tugas]
    P --> P1[Download File Jawaban]
    P1 --> P2[Evaluasi Kualitas]
    P2 --> P3{Decision Penilaian}
    
    P3 -->|Nilai Langsung| Q[Input Nilai & Feedback]
    P3 -->|Perlu Revisi| R[Set Status Revisi]
    P3 -->|Feedback Saja| S[Input Feedback]
    
    Q --> Q1[Simpan Penilaian]
    Q1 --> Q2[Notifikasi ke Peserta]
    Q2 --> T[Peserta Lihat Nilai]
    
    R --> R1[Input Feedback Revisi]
    R1 --> R2[Set is_revision = 1]
    R2 --> R3[Notifikasi ke Peserta]
    R3 --> U[Peserta Lihat Feedback]
    U --> V[Peserta Revisi Tugas]
    V --> N
    
    S --> S1[Simpan Feedback]
    S1 --> S2[Notifikasi ke Peserta]
    S2 --> W[Peserta Lihat Feedback]
    
    T --> X{Ada Tugas Lain?}
    W --> X
    X -->|Ya| Y[Lihat Tugas Berikutnya]
    X -->|Tidak| Z[Menunggu Tugas Baru]
    
    Y --> K
    Z --> AA[Monitor Progress]
    AA --> BB{Periode Selesai?}
    BB -->|Belum| AA
    BB -->|Ya| CC[Proses Sertifikat]
```

## 5. Diagram Alur Detail - Proses Sertifikasi

```mermaid
graph TD
    A[Periode Magang Selesai] --> B[Status: Finished]
    B --> C[Pembimbing Cek Kelayakan]
    C --> D{Semua Tugas Dinilai?}
    
    D -->|Tidak| E[Pesan: Masih Ada Tugas Belum Dinilai]
    D -->|Ya| F{Tidak Ada Status Revisi?}
    
    F -->|Ada| G[Pesan: Masih Ada Tugas Perlu Revisi]
    F -->|Tidak| H[Pembimbing Generate Sertifikat]
    
    H --> H1[Form Sertifikat]
    H1 --> H2[Nomor Sertifikat]
    H2 --> H3[Predikat]
    H3 --> H4[Preview Sertifikat]
    H4 --> H5[Generate PDF]
    H5 --> H6[Upload Sertifikat]
    
    H6 --> I[Notifikasi ke Peserta]
    I --> J[Peserta Download Sertifikat]
    J --> K[Verifikasi QR Code]
    K --> L[Sertifikat Valid]
    
    E --> M[Pembimbing Lanjutkan Penilaian]
    M --> N[Set Status Revisi = 0]
    N --> O[Peserta Revisi Tugas]
    O --> P[Submit Revisi]
    P --> Q[Pembimbing Nilai Ulang]
    Q --> C
    
    G --> R[Pembimbing Set Revisi = 0]
    R --> S[Peserta Selesaikan Revisi]
    S --> T[Submit Final]
    T --> U[Pembimbing Finalisasi]
    U --> C
```

## 6. Diagram Alur Detail - Proses Admin

```mermaid
graph TD
    A[Admin Login] --> B[Dashboard Admin]
    B --> C[Menu Management]
    
    C --> D[Kelola Divisi]
    D --> D1[Tambah Direktorat]
    D1 --> D2[Tambah Sub Direktorat]
    D2 --> D3[Tambah Divisi]
    D3 --> D4[Auto Generate Pembimbing]
    D4 --> D5[Set Password Default]
    
    C --> E[Kelola Pembimbing]
    E --> E1[Lihat Daftar Pembimbing]
    E1 --> E2[Reset Password]
    E2 --> E3[Update Data Pembimbing]
    
    C --> F[Kelola Laporan]
    F --> F1[Filter Berdasarkan Periode]
    F1 --> F2[Filter Berdasarkan Divisi]
    F2 --> F3[Generate Report]
    F3 --> F4[Export PDF/Excel]
    
    C --> G[Kelola Peraturan]
    G --> G1[Edit Konten Peraturan]
    G1 --> G2[Update Peraturan]
    G2 --> G3[Notifikasi Update]
    
    C --> H[Monitor Sistem]
    H --> H1[Lihat Statistik]
    H1 --> H2[Total Peserta]
    H2 --> H3[Total Pengajuan]
    H3 --> H4[Total Selesai]
    H4 --> H5[Distribusi per Divisi]
    
    D5 --> I[Simpan Konfigurasi]
    E3 --> I
    F4 --> I
    G3 --> I
    H5 --> I
    
    I --> J[Update Dashboard]
    J --> K[Selesai]
```

## 7. Diagram Alur Detail - Proses Upload Dokumen Tambahan

```mermaid
graph TD
    A[Peserta Diterima] --> B[Status: Accepted]
    B --> C[Notifikasi: Upload Dokumen Tambahan]
    C --> D[Peserta Akses Menu Status]
    D --> E[Lihat Persyaratan Tambahan]
    
    E --> F[Upload Dokumen]
    F --> F1[Surat Pengantar]
    F1 --> F2[Foto Nametag]
    F2 --> F3[Screenshot PosPay]
    F3 --> F4[Foto Prangko Prisma]
    F4 --> F5[Screenshot Follow IG Museum]
    F5 --> F6[Screenshot Follow IG Pos Indonesia]
    F6 --> F7[Screenshot Subscribe YouTube]
    
    F7 --> G[Validasi File]
    G --> G1{Format Valid?}
    G1 -->|Tidak| G2[Error: Format File Salah]
    G1 -->|Ya| G3{Ukuran Valid?}
    G3 -->|Tidak| G4[Error: File Terlalu Besar]
    G3 -->|Ya| H[Simpan Dokumen]
    
    G2 --> F1
    G4 --> F1
    
    H --> I[Update Status Upload]
    I --> J[Notifikasi ke Pembimbing]
    J --> K[Pembimbing Verifikasi]
    K --> L[Dokumen Lengkap]
    L --> M[Proses Lanjutan]
```

## 8. Diagram Alur Detail - Proses Re-application

```mermaid
graph TD
    A[Peserta dengan Riwayat Magang] --> B[Login ke Dashboard]
    B --> C[Menu Program Magang]
    C --> D{Cek Status Magang Terakhir}
    
    D -->|Selesai| E[Form Re-application]
    D -->|Masih Aktif| F[Pesan: Masih Ada Magang Aktif]
    D -->|Ditolak| E
    
    E --> E1[Pilih Divisi Baru]
    E1 --> E2[Set Periode Baru]
    E2 --> E3[Submit Re-application]
    E3 --> E4[Status: Pending]
    
    E4 --> G[Notifikasi ke Pembimbing]
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

## 9. Diagram Alur Detail - Proses Surat Penerimaan

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
    D --> D1[QR Code Verification]
    D1 --> D2[Upload ke Storage]
    D2 --> D3[Update Database]
    
    D3 --> E[Notifikasi ke Peserta]
    E --> F[Peserta Download Surat]
    F --> G[Verifikasi QR Code]
    G --> H[Surat Valid]
    
    H --> I[Update Status Download]
    I --> J[Proses Lanjutan]
```

## 10. Diagram Alur Detail - Proses Monitoring dan Reporting

```mermaid
graph TD
    A[Admin Dashboard] --> B[Menu Reports]
    B --> C[Filter Data]
    C --> C1[Pilih Periode]
    C1 --> C2[Pilih Klasifikasi]
    C2 --> C3[Pilih Status]
    
    C3 --> D[Generate Query]
    D --> E[Ambil Data]
    E --> E1[Data Peserta]
    E1 --> E2[Data Pengajuan]
    E2 --> E3[Data Penugasan]
    E3 --> E4[Data Sertifikat]
    
    E4 --> F[Proses Data]
    F --> F1[Grouping Data]
    F1 --> F2[Calculations]
    F2 --> F3[Format Output]
    
    F3 --> G[Display Results]
    G --> H{Export?}
    H -->|PDF| I[Generate PDF Report]
    H -->|Excel| J[Generate Excel Report]
    H -->|Tidak| K[Display di Browser]
    
    I --> L[Download PDF]
    J --> M[Download Excel]
    K --> N[Lihat di Dashboard]
    
    L --> O[Selesai]
    M --> O
    N --> O
```

## Kesimpulan

Diagram BPMN ini menunjukkan alur proses bisnis yang lengkap untuk sistem penerimaan magang PT Pos Indonesia, mencakup:

1. **Proses Registrasi dan Login** - Mulai dari pendaftaran hingga akses sistem
2. **Proses Review Pengajuan** - Evaluasi pengajuan oleh pembimbing
3. **Proses Penugasan dan Penilaian** - Pemberian tugas dan evaluasi
4. **Proses Sertifikasi** - Penerbitan sertifikat setelah magang selesai
5. **Proses Admin** - Manajemen sistem dan laporan
6. **Proses Dokumen Tambahan** - Upload persyaratan tambahan
7. **Proses Re-application** - Pengajuan ulang untuk peserta lama
8. **Proses Surat Penerimaan** - Generate surat resmi
9. **Proses Monitoring** - Pelacakan dan pelaporan

Setiap proses memiliki validasi, error handling, dan notifikasi yang memastikan alur berjalan lancar dan transparan.
