# Diagram Entitas dan Relasi Sistem Penerimaan Magang

## 1. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS {
        int id PK
        string username UK
        string name
        string email UK
        string password
        string nim
        string university
        string major
        string phone
        string ktp_number
        string ktm
        string role
        int divisi_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    DIREKTORATS {
        int id PK
        string name
        timestamp created_at
        timestamp updated_at
    }
    
    SUB_DIREKTORATS {
        int id PK
        string name
        int direktorat_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    DIVISIS {
        int id PK
        string name
        int sub_direktorat_id FK
        string vp
        string nippos
        timestamp created_at
        timestamp updated_at
    }
    
    INTERNSHIP_APPLICATIONS {
        int id PK
        int user_id FK
        int divisi_id FK
        string status
        string cover_letter_path
        string notes
        date start_date
        date end_date
        string foto_nametag_path
        string screenshot_pospay_path
        string foto_prangko_prisma_path
        string ss_follow_ig_museum_path
        string ss_follow_ig_posindonesia_path
        string ss_subscribe_youtube_path
        string acceptance_letter_path
        timestamp acceptance_letter_downloaded_at
        boolean acknowledged_additional_requirements
        timestamp created_at
        timestamp updated_at
    }
    
    ASSIGNMENTS {
        int id PK
        int user_id FK
        string title
        text description
        date deadline
        string file_path
        string submission_file_path
        string online_text
        int grade
        text feedback
        boolean is_revision
        timestamp submitted_at
        timestamp created_at
        timestamp updated_at
    }
    
    ASSIGNMENT_SUBMISSIONS {
        int id PK
        int assignment_id FK
        int user_id FK
        string file_path
        timestamp submitted_at
        string keterangan
        timestamp created_at
        timestamp updated_at
    }
    
    CERTIFICATES {
        int id PK
        int user_id FK
        string certificate_path
        timestamp issued_at
        int internship_application_id FK
        string nomor_sertifikat
        string predikat
        timestamp created_at
        timestamp updated_at
    }
    
    RULES {
        int id PK
        text content
        timestamp created_at
        timestamp updated_at
    }
    
    USERS ||--o{ INTERNSHIP_APPLICATIONS : "has"
    USERS ||--o{ ASSIGNMENTS : "receives"
    USERS ||--o{ ASSIGNMENT_SUBMISSIONS : "submits"
    USERS ||--o{ CERTIFICATES : "earns"
    USERS ||--o| DIVISIS : "belongs_to"
    
    DIREKTORATS ||--o{ SUB_DIREKTORATS : "contains"
    SUB_DIREKTORATS ||--o{ DIVISIS : "contains"
    DIVISIS ||--o{ INTERNSHIP_APPLICATIONS : "receives"
    
    INTERNSHIP_APPLICATIONS ||--o| CERTIFICATES : "generates"
    ASSIGNMENTS ||--o{ ASSIGNMENT_SUBMISSIONS : "has"
```

## 2. Diagram Alur Data (Data Flow Diagram)

```mermaid
graph TD
    A[Peserta] --> B[Form Registrasi]
    B --> C[Database Users]
    C --> D[Database Internship Applications]
    
    E[Pembimbing] --> F[Review Pengajuan]
    F --> G[Update Status Application]
    G --> H[Generate Surat Penerimaan]
    H --> I[Database Files]
    
    J[Pembimbing] --> K[Berikan Penugasan]
    K --> L[Database Assignments]
    L --> M[Notifikasi ke Peserta]
    
    N[Peserta] --> O[Submit Tugas]
    O --> P[Database Assignment Submissions]
    P --> Q[Notifikasi ke Pembimbing]
    
    R[Pembimbing] --> S[Nilai Tugas]
    S --> T[Update Grade & Feedback]
    T --> U[Database Assignments]
    
    V[Pembimbing] --> W[Generate Sertifikat]
    W --> X[Database Certificates]
    X --> Y[Notifikasi ke Peserta]
    
    Z[Admin] --> AA[Kelola Divisi]
    AA --> BB[Database Direktorats]
    BB --> CC[Database Sub Direktorats]
    CC --> DD[Database Divisis]
    
    EE[Admin] --> FF[Generate Report]
    FF --> GG[Query Database]
    GG --> HH[Export PDF/Excel]
```

## 3. Diagram Use Case

```mermaid
graph TD
    A[Peserta Magang] --> B[Registrasi Akun]
    A --> C[Login Sistem]
    A --> D[Lihat Program Magang]
    A --> E[Submit Pengajuan]
    A --> F[Lihat Status Pengajuan]
    A --> G[Upload Dokumen Tambahan]
    A --> H[Download Surat Penerimaan]
    A --> I[Lihat Penugasan]
    A --> J[Submit Tugas]
    A --> K[Lihat Nilai & Feedback]
    A --> L[Download Sertifikat]
    A --> M[Pengajuan Ulang]
    
    N[Pembimbing] --> O[Login Sistem]
    N --> P[Lihat Dashboard]
    N --> Q[Review Pengajuan]
    N --> R[Respon Pengajuan]
    N --> S[Generate Surat Penerimaan]
    N --> T[Berikan Penugasan]
    N --> U[Monitor Progress]
    N --> V[Nilai Tugas]
    N --> W[Set Status Revisi]
    N --> X[Generate Sertifikat]
    N --> Y[Upload Sertifikat]
    N --> Z[Lihat Profil]
    
    AA[Admin] --> BB[Login Sistem]
    AA --> CC[Lihat Dashboard Admin]
    AA --> DD[Kelola Divisi]
    AA --> EE[Kelola Sub Direktorat]
    AA --> FF[Kelola Direktorat]
    AA --> GG[Kelola Pembimbing]
    AA --> HH[Reset Password Pembimbing]
    AA --> II[Lihat Laporan]
    AA --> JJ[Export Report]
    AA --> KK[Kelola Peraturan]
    AA --> LL[Monitor Sistem]
```

## 4. Diagram Sequence - Proses Registrasi

```mermaid
sequenceDiagram
    participant P as Peserta
    participant W as Website
    participant C as Controller
    participant D as Database
    participant E as Email
    
    P->>W: Akses halaman registrasi
    W->>P: Tampilkan form registrasi
    P->>W: Isi form & upload KTM
    W->>C: Submit form registrasi
    C->>C: Validasi data
    C->>D: Cek username & email unique
    D-->>C: Konfirmasi unique
    C->>D: Simpan data user
    C->>D: Buat pengajuan magang
    D-->>C: Konfirmasi tersimpan
    C->>E: Auto login user
    C-->>W: Redirect ke dashboard
    W-->>P: Tampilkan dashboard
```

## 5. Diagram Sequence - Proses Review Pengajuan

```mermaid
sequenceDiagram
    participant M as Pembimbing
    participant W as Website
    participant C as Controller
    participant D as Database
    participant P as Peserta
    
    M->>W: Login ke dashboard
    W->>C: Request dashboard
    C->>D: Ambil data pengajuan
    D-->>C: Return data pengajuan
    C-->>W: Tampilkan dashboard
    W-->>M: Dashboard dengan pengajuan
    
    M->>W: Pilih pengajuan untuk review
    W->>C: Request detail pengajuan
    C->>D: Ambil detail pengajuan
    D-->>C: Return detail
    C-->>W: Tampilkan detail
    W-->>M: Form review pengajuan
    
    M->>W: Submit respon (terima/tolak/tunda)
    W->>C: Proses respon
    C->>D: Update status pengajuan
    C->>D: Update divisi user (jika diterima)
    D-->>C: Konfirmasi update
    C->>P: Kirim notifikasi
    C-->>W: Redirect ke daftar pengajuan
    W-->>M: Daftar pengajuan updated
```

## 6. Diagram Sequence - Proses Penugasan

```mermaid
sequenceDiagram
    participant M as Pembimbing
    participant W as Website
    participant C as Controller
    participant D as Database
    participant P as Peserta
    
    M->>W: Akses menu penugasan
    W->>C: Request data peserta aktif
    C->>D: Query peserta dengan status accepted
    D-->>C: Return data peserta
    C-->>W: Tampilkan daftar peserta
    W-->>M: Daftar peserta aktif
    
    M->>W: Pilih peserta & buat penugasan
    W->>C: Submit form penugasan
    C->>C: Validasi data penugasan
    C->>D: Simpan penugasan
    D-->>C: Konfirmasi tersimpan
    C->>P: Kirim notifikasi penugasan
    C-->>W: Redirect ke daftar penugasan
    W-->>M: Penugasan berhasil dibuat
    
    P->>W: Lihat penugasan baru
    W->>C: Request detail penugasan
    C->>D: Ambil data penugasan
    D-->>C: Return data penugasan
    C-->>W: Tampilkan detail penugasan
    W-->>P: Form submit tugas
    
    P->>W: Submit jawaban tugas
    W->>C: Proses submit tugas
    C->>D: Simpan submission
    C->>D: Update assignment
    D-->>C: Konfirmasi tersimpan
    C->>M: Kirim notifikasi submission
    C-->>W: Redirect ke daftar tugas
    W-->>P: Tugas berhasil dikumpulkan
```

## 7. Diagram Sequence - Proses Penilaian

```mermaid
sequenceDiagram
    participant M as Pembimbing
    participant W as Website
    participant C as Controller
    participant D as Database
    participant P as Peserta
    
    M->>W: Lihat tugas yang perlu dinilai
    W->>C: Request data tugas
    C->>D: Query tugas dengan submission
    D-->>C: Return data tugas
    C-->>W: Tampilkan daftar tugas
    W-->>M: Daftar tugas untuk dinilai
    
    M->>W: Pilih tugas untuk dinilai
    W->>C: Request detail tugas
    C->>D: Ambil detail tugas & submission
    D-->>C: Return detail
    C-->>W: Tampilkan form penilaian
    W-->>M: Form input nilai & feedback
    
    M->>W: Submit penilaian
    W->>C: Proses penilaian
    C->>C: Validasi input nilai
    C->>D: Update grade & feedback
    D-->>C: Konfirmasi update
    C->>P: Kirim notifikasi nilai
    C-->>W: Redirect ke daftar tugas
    W-->>M: Penilaian berhasil disimpan
    
    P->>W: Lihat nilai tugas
    W->>C: Request data nilai
    C->>D: Ambil data nilai & feedback
    D-->>C: Return data nilai
    C-->>W: Tampilkan nilai & feedback
    W-->>P: Detail nilai & feedback
```

## 8. Diagram Sequence - Proses Sertifikasi

```mermaid
sequenceDiagram
    participant M as Pembimbing
    participant W as Website
    participant C as Controller
    participant D as Database
    participant P as Peserta
    participant F as File System
    
    M->>W: Akses menu sertifikat
    W->>C: Request data peserta selesai
    C->>D: Query peserta dengan status finished
    D-->>C: Return data peserta
    C->>C: Cek kelayakan sertifikat
    C-->>W: Tampilkan peserta eligible
    W-->>M: Daftar peserta untuk sertifikat
    
    M->>W: Pilih peserta & generate sertifikat
    W->>C: Request form sertifikat
    C->>D: Ambil data peserta & magang
    D-->>C: Return data lengkap
    C-->>W: Tampilkan form sertifikat
    W-->>M: Form input data sertifikat
    
    M->>W: Submit data sertifikat
    W->>C: Proses generate sertifikat
    C->>C: Generate PDF sertifikat
    C->>F: Simpan file sertifikat
    F-->>C: Konfirmasi tersimpan
    C->>D: Simpan data sertifikat
    D-->>C: Konfirmasi tersimpan
    C->>P: Kirim notifikasi sertifikat
    C-->>W: Redirect ke daftar sertifikat
    W-->>M: Sertifikat berhasil dibuat
    
    P->>W: Lihat sertifikat tersedia
    W->>C: Request data sertifikat
    C->>D: Ambil data sertifikat
    D-->>C: Return data sertifikat
    C-->>W: Tampilkan daftar sertifikat
    W-->>P: Daftar sertifikat
    
    P->>W: Download sertifikat
    W->>C: Request download
    C->>F: Ambil file sertifikat
    F-->>C: Return file
    C-->>W: Stream file ke browser
    W-->>P: Download berhasil
```

## 9. Diagram Sequence - Proses Admin

```mermaid
sequenceDiagram
    participant A as Admin
    participant W as Website
    participant C as Controller
    participant D as Database
    participant E as Email
    
    A->>W: Login sebagai admin
    W->>C: Request dashboard admin
    C->>D: Query statistik sistem
    D-->>C: Return statistik
    C-->>W: Tampilkan dashboard
    W-->>A: Dashboard admin dengan statistik
    
    A->>W: Kelola divisi
    W->>C: Request data divisi
    C->>D: Query struktur organisasi
    D-->>C: Return data divisi
    C-->>W: Tampilkan tree divisi
    W-->>A: Interface kelola divisi
    
    A->>W: Tambah divisi baru
    W->>C: Submit form divisi
    C->>C: Validasi data divisi
    C->>D: Simpan divisi
    C->>D: Auto generate pembimbing
    D-->>C: Konfirmasi tersimpan
    C-->>W: Redirect ke daftar divisi
    W-->>A: Divisi berhasil ditambahkan
    
    A->>W: Generate laporan
    W->>C: Request laporan
    C->>D: Query data laporan
    D-->>C: Return data laporan
    C->>C: Proses data laporan
    C-->>W: Tampilkan laporan
    W-->>A: Laporan dengan filter
    
    A->>W: Export laporan PDF
    W->>C: Request export PDF
    C->>C: Generate PDF
    C-->>W: Stream PDF
    W-->>A: Download PDF berhasil
```

## 10. Diagram State Machine - Status Pengajuan

```mermaid
stateDiagram-v2
    [*] --> Pending : Submit Pengajuan
    Pending --> Accepted : Pembimbing Terima
    Pending --> Rejected : Pembimbing Tolak
    Pending --> Postponed : Pembimbing Tunda
    Rejected --> Pending : Pengajuan Ulang
    Postponed --> Pending : Pengajuan Ulang
    Accepted --> Finished : Periode Magang Selesai
    Finished --> [*] : Sertifikat Terbit
    
    note right of Pending : Menunggu review pembimbing
    note right of Accepted : Diterima, mulai magang
    note right of Rejected : Ditolak dengan alasan
    note right of Postponed : Ditunda dengan alasan
    note right of Finished : Magang selesai
```

## 11. Diagram State Machine - Status Tugas

```mermaid
stateDiagram-v2
    [*] --> Assigned : Pembimbing Berikan Tugas
    Assigned --> Submitted : Peserta Submit Tugas
    Submitted --> Graded : Pembimbing Nilai Tugas
    Submitted --> Revision : Pembimbing Set Revisi
    Revision --> Submitted : Peserta Submit Revisi
    Graded --> [*] : Tugas Selesai
    
    note right of Assigned : Tugas diberikan, menunggu submit
    note right of Submitted : Tugas dikumpulkan, menunggu nilai
    note right of Graded : Tugas dinilai, selesai
    note right of Revision : Tugas perlu direvisi
```

## 12. Diagram State Machine - Status Magang

```mermaid
stateDiagram-v2
    [*] --> Pending : Submit Pengajuan
    Pending --> Accepted : Diterima
    Accepted --> Active : Mulai Periode Magang
    Active --> Completed : Selesai Periode Magang
    Completed --> Certified : Sertifikat Terbit
    Certified --> [*] : Magang Selesai
    
    note right of Pending : Menunggu review
    note right of Accepted : Diterima, upload dokumen
    note right of Active : Sedang magang, terima tugas
    note right of Completed : Periode selesai, tunggu sertifikat
    note right of Certified : Sertifikat tersedia
```

## Kesimpulan

Diagram entitas dan relasi ini memberikan gambaran lengkap tentang:

1. **Entity Relationship Diagram** - Struktur database dan relasi antar tabel
2. **Data Flow Diagram** - Alur data dalam sistem
3. **Use Case Diagram** - Interaksi pengguna dengan sistem
4. **Sequence Diagrams** - Alur interaksi detail untuk setiap proses utama
5. **State Machine Diagrams** - Perubahan status dalam sistem

Dokumentasi ini melengkapi diagram BPMN sebelumnya dan memberikan pemahaman yang komprehensif tentang arsitektur dan alur proses sistem penerimaan magang PT Pos Indonesia.
