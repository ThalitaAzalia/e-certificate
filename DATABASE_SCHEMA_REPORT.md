# Laporan Entity Relationship Diagram (ERD) Final
## Aplikasi E-Certificate Management System

**Tanggal**: 09 Februari 2026  
**Proyek**: E-Certificate Management Platform  
**Teknologi**: Laravel 11 + MySQL

---

## 📑 Daftar Isi

1. [Ringkasan Eksekutif](#ringkasan-eksekutif)
2. [Struktur Database](#struktur-database)
3. [Daftar Tabel](#daftar-tabel)
4. [Deskripsi Detail Tabel](#deskripsi-detail-tabel)
5. [Relasi Antar Tabel](#relasi-antar-tabel)
6. [Entity Relationship Diagram](#entity-relationship-diagram)
7. [Spesifikasi Teknis](#spesifikasi-teknis)

---

## 🎯 Ringkasan Eksekutif

Aplikasi E-Certificate Management System adalah platform untuk mengelola webinar, peserta, evaluasi, dan template sertifikat digital. Sistem ini menggunakan 8 tabel utama (tidak termasuk tabel Laravel framework) dengan relasi One-to-Many dan Many-to-One yang kompleks.

### Fitur Utama:
- ✅ Manajemen Webinar dan Peserta
- ✅ Sistem Evaluasi Fleksibel (Rating & Text)
- ✅ Template Sertifikat yang Dapat Dikustomisasi
- ✅ Form Field Dinamis
- ✅ Role-Based Access Control (Admin & User)

---

## 🗂️ Struktur Database

```
e-certificate (Database)
├── Tabel Utama (8 tabel)
│   ├── admins
│   ├── users
│   ├── webinars
│   ├── pesertas
│   ├── evaluasi_questions
│   ├── evaluasi_answers
│   ├── form_fields
│   └── certificate_templates
├── Tabel Sistem Laravel (4 tabel)
│   ├── password_reset_tokens
│   ├── sessions
│   ├── cache
│   └── jobs
```

---

## 📊 Daftar Tabel

| No | Nama Tabel | Tipe | Kolom | Primary Key | Deskripsi |
|----|-----------|------|-------|------------|-----------|
| 1 | **admins** | Utama | 5 | id | Admin pengelola sistem |
| 2 | **users** | Utama | 6 | id | User/Peserta dengan login |
| 3 | **webinars** | Utama | 12 | id | Data event/webinar |
| 4 | **pesertas** | Utama | 6 | id | Peserta mengikuti webinar |
| 5 | **evaluasi_questions** | Utama | 6 | id | Pertanyaan evaluasi |
| 6 | **evaluasi_answers** | Utama | 7 | id | Jawaban evaluasi peserta |
| 7 | **form_fields** | Config | 9 | id | Konfigurasi field dinamis |
| 8 | **certificate_templates** | Config | 20 | id | Template desain sertifikat |

---

## 📋 Deskripsi Detail Tabel

### 1. **admins** - Admin Pengelola Sistem
```sql
CREATE TABLE admins (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas unik admin
- `username`: Username unik untuk login
- `password`: Password terenkripsi
- `photo`: URL foto profil admin

**Fungsi**: Autentikasi dan otorisasi admin untuk mengelola sistem

---

### 2. **users** - User/Peserta dengan Akun
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas unik user
- `name`: Nama lengkap user
- `username`: Username untuk login (override dari email)
- `photo`: URL foto profil user

**Fungsi**: Autentikasi user regular (opsional, bisa terpisah dari peserta)

---

### 3. **webinars** - Data Event/Webinar
```sql
CREATE TABLE webinars (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NULLABLE,
    tanggal DATE NOT NULL,
    waktu TIME NULLABLE,
    narasumber VARCHAR(255) NULLABLE,
    media VARCHAR(255) NULLABLE,
    status ENUM('draft', 'published') DEFAULT 'draft',
    poster VARCHAR(255) NULLABLE,
    link_absensi VARCHAR(255) NULLABLE,
    link_detail VARCHAR(255) NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas webinar
- `judul`: Judul event
- `tanggal`: Tanggal pelaksanaan
- `waktu`: Jam dimulai
- `narasumber`: Nama pembicara
- `status`: Draft atau Published
- `link_*`: Link absensi dan detail

**Relasi**: One-to-Many dengan `pesertas` dan `evaluasi_answers`

---

### 4. **pesertas** - Data Peserta Webinar
```sql
CREATE TABLE pesertas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    webinar_id BIGINT NOT NULL,
    nama_peserta VARCHAR(255) NULLABLE,
    email VARCHAR(255) NULLABLE,
    no_hp VARCHAR(20) NULLABLE,
    waktu_absen TIMESTAMP NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (webinar_id) REFERENCES webinars(id) ON DELETE CASCADE
);
```

**Kolom Utama:**
- `id`: Identitas peserta
- `webinar_id`: FK ke webinars
- `nama_peserta`: Nama lengkap peserta
- `email`: Email peserta
- `no_hp`: Nomor HP peserta
- `waktu_absen`: Waktu check-in

**Relasi**: 
- Many-to-One dengan `webinars`
- One-to-Many dengan `evaluasi_answers`

---

### 5. **evaluasi_questions** - Daftar Pertanyaan Evaluasi
```sql
CREATE TABLE evaluasi_questions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL,
    type ENUM('rating', 'text') DEFAULT 'rating',
    urutan INT DEFAULT 1,
    rating_max TINYINT UNSIGNED DEFAULT 5,
    rating_labels JSON NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas pertanyaan
- `question`: Teks pertanyaan
- `type`: Jenis (rating atau text)
- `rating_max`: Skala maksimal rating
- `rating_labels`: JSON array label rating (misal: ["Sangat Buruk", "Buruk", "Baik", "Sangat Baik", "Sempurna"])

**Contoh data:**
```json
{
  "question": "Bagaimana kualitas materi webinar?",
  "type": "rating",
  "rating_max": 5,
  "rating_labels": ["Sangat Buruk", "Buruk", "Cukup", "Baik", "Sangat Baik"]
}
```

**Relasi**: One-to-Many dengan `evaluasi_answers`

---

### 6. **evaluasi_answers** - Jawaban Evaluasi Peserta
```sql
CREATE TABLE evaluasi_answers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT NOT NULL,
    webinar_id BIGINT NOT NULL,
    evaluasi_question_id BIGINT NOT NULL,
    answer TEXT NULLABLE,
    question_text VARCHAR(255) NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (peserta_id) REFERENCES pesertas(id) ON DELETE CASCADE,
    FOREIGN KEY (webinar_id) REFERENCES webinars(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluasi_question_id) REFERENCES evaluasi_questions(id) ON DELETE CASCADE
);
```

**Kolom Utama:**
- `id`: Identitas jawaban
- `peserta_id`: FK ke peserta
- `webinar_id`: FK ke webinar
- `evaluasi_question_id`: FK ke pertanyaan
- `answer`: Isi jawaban (rating atau text)
- `question_text`: Copy dari pertanyaan (untuk history)

**Relasi**: 
- Many-to-One dengan `pesertas`, `webinars`, `evaluasi_questions`

---

### 7. **form_fields** - Konfigurasi Field Dinamis
```sql
CREATE TABLE form_fields (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    field_key VARCHAR(100) NOT NULL,
    label VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    required BOOLEAN DEFAULT 0,
    active BOOLEAN DEFAULT 1,
    sort_order INT DEFAULT 0,
    placeholder VARCHAR(255) NULLABLE,
    admin_note TEXT NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas field
- `field_key`: Kunci mapping kolom (misal: "nama_peserta")
- `label`: Label untuk UI (misal: "Nama Lengkap")
- `type`: Jenis input (text, email, number, select, textarea, etc)
- `required`: Wajib diisi atau tidak
- `sort_order`: Urutan tampilan di form

**Contoh data:**
```sql
INSERT INTO form_fields VALUES
(1, 'nama_peserta', 'Nama Lengkap', 'text', 1, 1, 1, 'Masukkan nama lengkap', NULL),
(2, 'email', 'Email Aktif', 'email', 1, 1, 2, 'Masukkan email aktif', NULL),
(3, 'no_hp', 'Nomor HP', 'number', 1, 1, 3, 'Contoh: 08123456789', NULL);
```

**Fungsi**: Konfigurasi dinamis untuk membuat form pendaftaran peserta tanpa coding

---

### 8. **certificate_templates** - Template Desain Sertifikat
```sql
CREATE TABLE certificate_templates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT 0,
    
    -- Posisi teks nama peserta
    box_x INT DEFAULT 50,
    box_y INT DEFAULT 55,
    box_width INT NULLABLE,
    box_height INT NULLABLE,
    
    -- Styling font
    font_family VARCHAR(100) DEFAULT 'Arial',
    font_size INT DEFAULT 36,
    font_color VARCHAR(10) DEFAULT '#000000',
    font_weight VARCHAR(20) DEFAULT '700',
    font_style VARCHAR(20) DEFAULT 'normal',
    letter_spacing INT DEFAULT 1,
    line_height DECIMAL(3,2) DEFAULT 1.1,
    text_align VARCHAR(20) DEFAULT 'center',
    
    -- Dimensi template
    width_px INT NULLABLE,
    height_px INT NULLABLE,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom Utama:**
- `id`: Identitas template
- `name`: Nama template
- `file_name`: Nama file background gambar
- `is_active`: Template sedang digunakan atau tidak
- `box_x, box_y`: Koordinat posisi nama peserta
- `font_*`: Styling text (font, size, color, weight, dll)
- `width_px, height_px`: Dimensi sertifikat

**Contoh data:**
```sql
INSERT INTO certificate_templates VALUES
(1, 'Template Standard 2026', 'cert_bg_2026.png', 1, 
 50, 55, 300, 50, 'Arial', 36, '#000000', '700', 'normal', 
 1, 1.1, 'center', 1200, 800, NOW(), NOW());
```

**Fungsi**: Menyimpan template & styling untuk generate sertifikat digital

---

## 🔗 Relasi Antar Tabel

### Diagram Relasi Tekstual:

```
┌─────────────────────────────────────────────────┐
│                   WEBINARS                      │
│  (id, judul, tanggal, waktu, status, dst)      │
└──────────────┬────────────────────────────────┘
               │
        ┌──────┴───────────────┬──────────────────┐
        │ (1 : Many)         │ (1 : Many)       │
        │                    │                  │
   ┌────▼──────────────┐  ┌──▼─────────────────┐
   │   PESERTAS        │  │ EVALUASI_ANSWERS  │
   │ (id, webinar_id,  │  │ (id, peserta_id,  │
   │  nama_peserta,    │  │  webinar_id,      │
   │  email, dst)      │  │  evaluasi_q_id)   │
   └─────┬──────────────┘  └──┬─────────────────┘
         │ (1 : Many)         │ (Many : 1)
         │ ke Evaluasi        │
         │                    │
         └────────────────────┤
                             │
              ┌──────────────▼──────────────┐
              │ EVALUASI_QUESTIONS         │
              │ (id, question, type,       │
              │  rating_max, labels)       │
              └────────────────────────────┘

STANDALONE TABLES:
├── FORM_FIELDS (Konfigurasi field dinamis)
├── CERTIFICATE_TEMPLATES (Template sertifikat)
├── ADMINS (Admin pengelola)
└── USERS (User/Peserta login)
```

### Tabel Relasi Lengkap:

| Relasi | Tipe | Deskripsi | Foreign Key | Cascade |
|--------|------|-----------|------------|---------|
| Webinar → Peserta | 1:M | 1 webinar memiliki banyak peserta | `pesertas.webinar_id` | ON DELETE CASCADE |
| Webinar → Evaluasi Answers | 1:M | 1 webinar memiliki banyak jawaban | `evaluasi_answers.webinar_id` | ON DELETE CASCADE |
| Peserta → Evaluasi Answers | 1:M | 1 peserta memberikan banyak jawaban | `evaluasi_answers.peserta_id` | ON DELETE CASCADE |
| Evaluasi Question → Answers | 1:M | 1 pertanyaan punya banyak jawaban | `evaluasi_answers.evaluasi_question_id` | ON DELETE CASCADE |

---

## 🎨 Entity Relationship Diagram

### Diagram Visual (Text-based):

```
╔═══════════════════════════════════════════════════════════╗
║                    WEBINARS                              ║
║  PK: id                                                  ║
║  ─────────────────────────────────────────────────────  ║
║  - judul                                                 ║
║  - deskripsi                                             ║
║  - tanggal                                               ║
║  - waktu                                                 ║
║  - narasumber                                            ║
║  - status ('draft', 'published')                        ║
║  - created_at, updated_at                              ║
╚═════════╤═════════════════════════╤═══════════════════════╝
          │                         │
    ┌─────┴──────────┐    ┌────────┴──────────┐
    │ (1 : Many)     │    │ (1 : Many)        │
    │                │    │                   │
   ╔▼═══════════════════════════════════════╗ ║
   ║       PESERTAS                        ║ ║
   ║  PK: id                               ║ ║
   ║  FK: webinar_id                       ║ ║
   ║  ─────────────────────────────────────║ ║
   ║  - nama_peserta                       ║ ║
   ║  - email                              ║ ║
   ║  - no_hp                              ║ ║
   ║  - waktu_absen                        ║ ║
   ║  - created_at, updated_at             ║ ║
   ╚════╤═════════════════════════════════╝ ║
        │ (1 : Many)                      │  │
        │                                 │  │
        │  ┌──────────────────────────────┤  │
        │  │                              │  │
        │  │  ┌─────────────────────────┐ │  │
        │  │  │ (Many : 1)              │ │  │
        │  │  │                         │ │  │
        ▼  ▼  ▼                         │ │  │
    ╔═════════════════════════════════╗ │ │  │
    ║   EVALUASI_ANSWERS              ║ │ │  │
    ║  PK: id                         ║ │ │  │
    ║  FK: peserta_id ───────────────────┘ │  │
    ║  FK: webinar_id ────────────────────────┘
    ║  FK: evaluasi_question_id ──┐          
    ║  ────────────────────────────║──────────
    ║  - answer                    ║
    ║  - question_text             ║
    ║  - created_at, updated_at    ║
    ╚════┬════════════════════════╝
         │ (Many : 1)            
         │                       
    ╔════▼════════════════════════════════╗
    ║   EVALUASI_QUESTIONS                ║
    ║  PK: id                             ║
    ║  ────────────────────────────────  ║
    ║  - question                         ║
    ║  - type ('rating', 'text')         ║
    ║  - urutan                           ║
    ║  - rating_max                       ║
    ║  - rating_labels (JSON)             ║
    ║  - created_at, updated_at           ║
    ╚═════════════════════════════════════╝

STANDALONE TABLES:
  ┌─────────────────────────────────┐
  │   FORM_FIELDS                  │
  │  Konfigurasi field dinamis    │
  └─────────────────────────────────┘
  
  ┌─────────────────────────────────┐
  │   CERTIFICATE_TEMPLATES         │
  │  Template desain sertifikat    │
  └─────────────────────────────────┘
  
  ┌─────────────────────────────────┐
  │   ADMINS                        │
  │  Admin pengelola sistem        │
  └─────────────────────────────────┘
  
  ┌─────────────────────────────────┐
  │   USERS                         │
  │  User/Peserta dengan akun      │
  └─────────────────────────────────┘
```

---

## 🔧 Spesifikasi Teknis

### Database Engine
```
Database: MySQL 8.0+
Charset: utf8mb4
Collation: utf8mb4_unicode_ci
```

### Fitur Database
- ✅ Foreign Key Constraints (ON DELETE CASCADE)
- ✅ Timestamps (created_at, updated_at)
- ✅ JSON Data Type (untuk rating_labels)
- ✅ Enum Type (untuk status)
- ✅ Index pada Foreign Keys

### Jumlah Tabel
- **Tabel Utama**: 8 tabel
- **Tabel Sistem Laravel**: 4 tabel (password_reset_tokens, sessions, cache, jobs)
- **Total**: 12 tabel

### Jumlah Kolom per Tabel
| Tabel | Kolom | Keterangan |
|-------|-------|-----------|
| admins | 5 | Minimal, hanya data penting |
| users | 6 | Lengkap dengan foto |
| webinars | 12 | Paling banyak field |
| pesertas | 6 | Data peserta |
| evaluasi_questions | 6 | Support rating & text |
| evaluasi_answers | 7 | Jawaban dari peserta |
| form_fields | 9 | Konfigurasi fleksibel |
| certificate_templates | 20 | Styling & positioning |

### Konvensi Penamaan
- **Tabel**: Plural bahasa Indonesia (pesertas, webinars)
- **Kolom**: Snake_case (nama_peserta, rating_max)
- **Foreign Key**: `[table]_id` (webinar_id, peserta_id)
- **Boolean**: `is_*` atau `*` (is_active, required)
- **Timestamp**: Standard Laravel (created_at, updated_at)

---

## 📈 Skalabilitas & Optimasi

### Index Rekomendasi
```sql
-- Primary & Foreign Keys (Automatic)
ALTER TABLE pesertas ADD INDEX idx_webinar_id (webinar_id);
ALTER TABLE evaluasi_answers ADD INDEX idx_peserta_id (peserta_id);
ALTER TABLE evaluasi_answers ADD INDEX idx_webinar_id (webinar_id);
ALTER TABLE evaluasi_answers ADD INDEX idx_evaluasi_question_id (evaluasi_question_id);

-- Search Performance
ALTER TABLE pesertas ADD INDEX idx_email (email);
ALTER TABLE pesertas ADD INDEX idx_nama_peserta (nama_peserta);
ALTER TABLE webinars ADD INDEX idx_status (status);
ALTER TABLE webinars ADD INDEX idx_tanggal (tanggal);
ALTER TABLE form_fields ADD INDEX idx_field_key (field_key);
ALTER TABLE evaluasi_questions ADD INDEX idx_type (type);
```

### Growth Path
- **Volume Peserta**: Hingga 100,000+ records (scaling)
- **Volume Evaluasi**: Bergantung pada jumlah peserta × pertanyaan
- **Template**: Minimal, typically 5-10 templates

---

## ✅ Integritas Data

### Cascade Delete
Jika webinar dihapus → otomatis hapus peserta & evaluasi answers:
```sql
-- Peserta dihapus
DELETE FROM pesertas WHERE webinar_id = X;

-- Evaluasi answers terhapus (dari peserta)
DELETE FROM evaluasi_answers WHERE peserta_id IN (...)
DELETE FROM evaluasi_answers WHERE webinar_id = X;
```

### Data Validation
- Email: Format valid (tipe data email di form)
- Phone: String 10-15 karakter
- Rating: Integer 1-5 (atau sesuai rating_max)
- URL: Full path file untuk images/templates

---

## 📌 Kesimpulan

Database aplikasi E-Certificate Management System memiliki:

1. **Struktur Terorganisir**: Terbagi menjadi data master (Webinars, Peserta) dan transaksional (Evaluasi)
2. **Relasi Kompleks**: 4 relasi One-to-Many yang saling terintegrasi
3. **Fleksibilitas**: Form fields & template customizable tanpa coding
4. **Integritas Tinggi**: Foreign keys dengan cascade delete
5. **Performance**: Siap untuk skala medium (hingga 100K+ users)

---

## 📚 Referensi

- **Framework**: Laravel 11 Eloquent ORM
- **Database**: MySQL 8.0+
- **Migration Path**: `/database/migrations/`
- **Model Path**: `/app/Models/`
- **Documentation**: https://laravel.com/docs/11.x/eloquent

---

**Dokumen ini dibuat sebagai referensi final ERD untuk project E-Certificate**  
**Versi**: 1.0 | Tanggal: 09 Februari 2026
