# Quick Reference - Database Schema
## E-Certificate Management System

---

## 📊 Tabel Utama (8 Tabel)

### 1. ADMINS (Admin Pengelola)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas unik |
| username | VARCHAR(50) | UNIQUE | Username login |
| password | VARCHAR(255) | | Password terenkripsi |
| photo | VARCHAR(255) | | URL foto profil |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `Admin.php`  
**Autentikasi:** Username-based auth

---

### 2. USERS (User Peserta Login)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas unik |
| name | VARCHAR(255) | | Nama lengkap |
| username | VARCHAR(255) | UNIQUE | Username login |
| password | VARCHAR(255) | | Password terenkripsi |
| photo | VARCHAR(255) | | URL foto profil |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `User.php`  
**Status:** Optional (terpisah dari pesertas)

---

### 3. WEBINARS (Event/Webinar)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas webinar |
| judul | VARCHAR(255) | | Judul event |
| deskripsi | TEXT | | Deskripsi panjang |
| tanggal | DATE | INDEX | Tanggal pelaksanaan |
| waktu | TIME | | Jam mulai |
| narasumber | VARCHAR(255) | | Nama pembicara |
| media | VARCHAR(255) | | Tipe media (zoom/youtube/etc) |
| status | ENUM | INDEX | 'draft' \| 'published' |
| poster | VARCHAR(255) | | URL gambar poster |
| link_absensi | VARCHAR(255) | | URL link absensi |
| link_detail | VARCHAR(255) | | URL detail event |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `Webinar.php`  
**Relasi:** 1→M: pesertas, evaluasi_answers  
**Index:** status, tanggal

---

### 4. PESERTAS (Data Peserta Webinar)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas peserta |
| webinar_id | BIGINT | FK, INDEX | Reference ke webinars |
| nama_peserta | VARCHAR(255) | INDEX | Nama lengkap |
| email | VARCHAR(255) | INDEX | Email peserta |
| no_hp | VARCHAR(20) | | Nomor HP |
| waktu_absen | TIMESTAMP | | Waktu check-in |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `Peserta.php`  
**Relasi:** M→1: webinars, 1→M: evaluasi_answers  
**Cascade:** ON DELETE CASCADE (dari webinars)  
**Index:** webinar_id, email, nama_peserta

---

### 5. EVALUASI_QUESTIONS (Pertanyaan Evaluasi)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas pertanyaan |
| question | VARCHAR(255) | | Teks pertanyaan |
| type | ENUM | INDEX | 'rating' \| 'text' |
| urutan | INT | | Nomor urut |
| rating_max | TINYINT | | Skala maksimal (1-10) |
| rating_labels | JSON | | Label rating ["Bad", "Good", ...] |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `EvaluasiQuestion.php`  
**Relasi:** 1→M: evaluasi_answers  
**Index:** type

**Contoh Rating Labels:**
```json
["Sangat Buruk", "Buruk", "Cukup", "Baik", "Sangat Baik"]
```

---

### 6. EVALUASI_ANSWERS (Jawaban Evaluasi)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas jawaban |
| peserta_id | BIGINT | FK, INDEX | Reference ke peserta |
| webinar_id | BIGINT | FK, INDEX | Reference ke webinar |
| evaluasi_question_id | BIGINT | FK, INDEX | Reference ke pertanyaan |
| answer | TEXT | | Isi jawaban (rating/text) |
| question_text | VARCHAR(255) | | Copy pertanyaan (history) |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `EvaluasiAnswer.php`  
**Relasi:** M→1: pesertas, webinars, evaluasi_questions  
**Cascade:** ON DELETE CASCADE (dari semua FK)  
**Index:** peserta_id, webinar_id, evaluasi_question_id

**Composite Unique Key (Optional):**
```sql
UNIQUE KEY (peserta_id, webinar_id, evaluasi_question_id)
```

---

### 7. FORM_FIELDS (Konfigurasi Field Dinamis)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas field |
| field_key | VARCHAR(100) | INDEX | Mapping kolom (nama_peserta) |
| label | VARCHAR(255) | | Label UI ("Nama Lengkap") |
| type | VARCHAR(50) | | "text", "email", "number", "select", etc |
| required | BOOLEAN | | Wajib diisi (0/1) |
| active | BOOLEAN | | Field aktif (0/1) |
| sort_order | INT | | Urutan tampilan |
| placeholder | VARCHAR(255) | | Placeholder text |
| admin_note | TEXT | | Catatan admin |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `FormField.php`  
**Relasi:** Standalone (no FK)  
**Index:** field_key

**Default Data:**
```sql
INSERT INTO form_fields VALUES
(1, 'nama_peserta', 'Nama Lengkap', 'text', 1, 1, 1, 'Masukkan nama lengkap', NULL, NOW(), NOW()),
(2, 'email', 'Email Aktif', 'email', 1, 1, 2, 'Masukkan email aktif', NULL, NOW(), NOW()),
(3, 'no_hp', 'Nomor HP', 'number', 1, 1, 3, 'Contoh: 08123456789', NULL, NOW(), NOW());
```

---

### 8. CERTIFICATE_TEMPLATES (Template Sertifikat)
| Kolom | Tipe | Key | Fungsi |
|-------|------|-----|--------|
| id | BIGINT | PK | Identitas template |
| name | VARCHAR(255) | | Nama template |
| file_name | VARCHAR(255) | | Nama file background |
| is_active | BOOLEAN | | Template aktif (0/1) |
| box_x | INT | | Koordinat X nama |
| box_y | INT | | Koordinat Y nama |
| box_width | INT | | Lebar box teks |
| box_height | INT | | Tinggi box teks |
| font_family | VARCHAR(100) | | Font: Arial, Calibri, etc |
| font_size | INT | | Ukuran font (px) |
| font_color | VARCHAR(10) | | Hex color (#000000) |
| font_weight | VARCHAR(20) | | '400', '700' (bold) |
| font_style | VARCHAR(20) | | 'normal', 'italic' |
| letter_spacing | INT | | Jarak antar huruf (px) |
| line_height | DECIMAL(3,2) | | 1.1 (110%) |
| text_align | VARCHAR(20) | | 'left', 'center', 'right' |
| width_px | INT | | Lebar sertifikat (px) |
| height_px | INT | | Tinggi sertifikat (px) |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diubah |

**Model:** `CertificateTemplate.php`  
**Relasi:** Standalone (no FK)

**Contoh Data:**
```sql
INSERT INTO certificate_templates VALUES
(1, 'Template Standard 2026', 'cert_bg.png', 1, 
 50, 250, 300, 60, 'Arial', 36, '#000000', '700', 'normal',
 1, 1.1, 'center', 1200, 800, NOW(), NOW());
```

---

## 🔗 Relasi Summary

```
WEBINARS
  ├── 1:M → PESERTAS
  │         ├── 1:M → EVALUASI_ANSWERS
  │         │         └── M:1 → EVALUASI_QUESTIONS
  │         └── (Cascade Delete)
  │
  └── 1:M → EVALUASI_ANSWERS
            └── (Cascade Delete)

STANDALONE:
  ├── ADMINS
  ├── USERS
  ├── FORM_FIELDS
  └── CERTIFICATE_TEMPLATES
```

---

## 📈 Statistik Database

| Metrik | Nilai |
|--------|-------|
| Total Tabel Utama | 8 |
| Total Tabel (incl. Laravel) | 12 |
| Total Kolom | 71+ |
| Primary Keys | 8 |
| Foreign Keys | 4 |
| Index Recommendations | 10+ |
| Max Cascade Level | 2 |

---

## 💾 SQL Queries Penting

### Create Foreign Keys:
```sql
ALTER TABLE pesertas 
  ADD CONSTRAINT fk_peserta_webinar 
  FOREIGN KEY (webinar_id) 
  REFERENCES webinars(id) 
  ON DELETE CASCADE;

ALTER TABLE evaluasi_answers 
  ADD CONSTRAINT fk_answer_peserta 
  FOREIGN KEY (peserta_id) 
  REFERENCES pesertas(id) 
  ON DELETE CASCADE;

ALTER TABLE evaluasi_answers 
  ADD CONSTRAINT fk_answer_webinar 
  FOREIGN KEY (webinar_id) 
  REFERENCES webinars(id) 
  ON DELETE CASCADE;

ALTER TABLE evaluasi_answers 
  ADD CONSTRAINT fk_answer_question 
  FOREIGN KEY (evaluasi_question_id) 
  REFERENCES evaluasi_questions(id) 
  ON DELETE CASCADE;
```

### Create Indexes:
```sql
CREATE INDEX idx_peserta_email ON pesertas(email);
CREATE INDEX idx_peserta_webinar ON pesertas(webinar_id);
CREATE INDEX idx_answer_peserta ON evaluasi_answers(peserta_id);
CREATE INDEX idx_answer_webinar ON evaluasi_answers(webinar_id);
CREATE INDEX idx_answer_question ON evaluasi_answers(evaluasi_question_id);
CREATE INDEX idx_webinar_status ON webinars(status);
CREATE INDEX idx_webinar_tanggal ON webinars(tanggal);
CREATE INDEX idx_question_type ON evaluasi_questions(type);
```

### Sample Queries:

**Peserta per Webinar:**
```sql
SELECT w.judul, COUNT(p.id) AS total_peserta
FROM webinars w
LEFT JOIN pesertas p ON w.id = p.webinar_id
GROUP BY w.id;
```

**Rata-rata Rating Webinar:**
```sql
SELECT w.judul, AVG(CAST(ea.answer AS DECIMAL)) AS avg_rating
FROM webinars w
JOIN evaluasi_answers ea ON w.id = ea.webinar_id
WHERE ea.evaluasi_question_id = 1
GROUP BY w.id;
```

**Jawaban Peserta:**
```sql
SELECT p.nama_peserta, eq.question, ea.answer
FROM evaluasi_answers ea
JOIN pesertas p ON ea.peserta_id = p.id
JOIN evaluasi_questions eq ON ea.evaluasi_question_id = eq.id
WHERE ea.webinar_id = ? 
ORDER BY p.nama_peserta;
```

---

## 🛠️ Laravel Eloquent Relationships

### Webinar Model:
```php
public function pesertas() {
    return $this->hasMany(Peserta::class);
}

public function evaluasiAnswers() {
    return $this->hasMany(EvaluasiAnswer::class);
}
```

### Peserta Model:
```php
public function webinar() {
    return $this->belongsTo(Webinar::class);
}

public function evaluasiAnswers() {
    return $this->hasMany(EvaluasiAnswer::class);
}
```

### EvaluasiAnswer Model:
```php
public function peserta() {
    return $this->belongsTo(Peserta::class);
}

public function webinar() {
    return $this->belongsTo(Webinar::class);
}

public function question() {
    return $this->belongsTo(EvaluasiQuestion::class, 'evaluasi_question_id');
}
```

### EvaluasiQuestion Model:
```php
public function answers() {
    return $this->hasMany(EvaluasiAnswer::class, 'evaluasi_question_id');
}
```

---

## 🚀 Performance Tips

1. **Always use indexes** pada Foreign Keys dan frequently searched columns
2. **Eager load relationships** dengan `with()` untuk menghindari N+1 queries
3. **Caching** untuk form_fields dan certificate_templates (jarang berubah)
4. **Composite index** untuk (peserta_id, webinar_id) di evaluasi_answers
5. **Pagination** pada queries yang return banyak data

---

## 📝 Notes

- **Peserta ≠ Users**: Peserta adalah data peserta webinar (banyak), Users adalah akun login (minimal)
- **Cascade Delete**: Menghapus webinar akan menghapus semua peserta dan evaluasi terkait
- **Form Fields**: Digunakan untuk membuat form registrasi dinamis tanpa modifikasi kode
- **Templates**: Customizable tanpa perlu ubah code, hanya ubah HTML/CSS via admin panel

---

**Last Updated:** 09 Februari 2026  
**Database Version:** Final v1.0  
**Framework:** Laravel 11 + MySQL 8.0+
