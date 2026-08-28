# Soal SQL - Database db_hr

## LEVEL BASIC (20 Soal)

### Soal 1
Tampilkan semua data dari tabel employees

**Jawaban:**
```sql
SELECT * FROM employees;
```

---

### Soal 2
Tampilkan first_name, last_name, dan salary dari tabel employees

**Jawaban:**
```sql
SELECT first_name, last_name, salary FROM employees;
```

---

### Soal 3
Tampilkan karyawan dengan gaji di atas 10000

**Jawaban:**
```sql
SELECT first_name, last_name, salary
FROM employees
WHERE salary > 10000;
```

---

### Soal 4
Tampilkan karyawan yang dipekerjakan sebelum tahun 2005

**Jawaban:**
```sql
SELECT first_name, last_name, hire_date
FROM employees
WHERE hire_date < '2005-01-01';
```

---

### Soal 5
Tampilkan semua nama departemen dari tabel departments

**Jawaban:**
```sql
SELECT department_name FROM departments;
```

---

### Soal 6
Tampilkan nama karyawan yang nama depannya berawalan huruf 'J'

**Jawaban:**
```sql
SELECT first_name, last_name
FROM employees
WHERE first_name LIKE 'J%';
```

---

### Soal 7
Tampilkan karyawan yang tidak memiliki komisi (NULL)

**Jawaban:**
```sql
SELECT first_name, last_name, commission_pct
FROM employees
WHERE commission_pct IS NULL;
```

---

### Soal 8
Tampilkan nama karyawan yang bekerja di departemen 50 (Shipping)

**Jawaban:**
```sql
SELECT first_name, last_name, department_id
FROM employees
WHERE department_id = 50;
```

---

### Soal 9
Tampilkan semua nama job dari tabel jobs

**Jawaban:**
```sql
SELECT job_title FROM jobs;
```

---

### Soal 10
Tampilkan karyawan berdasarkan gaji dari yang terendah

**Jawaban:**
```sql
SELECT first_name, last_name, salary
FROM employees
ORDER BY salary ASC;
```

---

### Soal 11
Tampilkan 5 karyawan dengan gaji tertinggi

**Jawaban:**
```sql
SELECT first_name, last_name, salary
FROM employees
ORDER BY salary DESC
LIMIT 5;
```

---

### Soal 12
Tampilkan nama karyawan beserta nama departemennya

**Jawaban:**
```sql
SELECT e.first_name, e.last_name, d.department_name
FROM employees e
JOIN departments d ON e.department_id = d.department_id;
```

---

### Soal 13
Tampilkan semua negara beserta nama wilayahnya

**Jawaban:**
```sql
SELECT c.country_name, r.region_name
FROM countries c
JOIN regions r ON c.region_id = r.region_id;
```

---

### Soal 14
Tampilkan nama karyawan beserta nama atasannya (manager)

**Jawaban:**
```sql
SELECT e.first_name AS karyawan, m.first_name AS manager
FROM employees e
LEFT JOIN employees m ON e.manager_id = m.employee_id;
```

---

### Soal 15
Tampilkan nama karyawan, nama departemen, dan kota tempat kantor

**Jawaban:**
```sql
SELECT e.first_name, e.last_name, d.department_name, l.city
FROM employees e
JOIN departments d ON e.department_id = d.department_id
JOIN locations l ON d.location_id = l.location_id;
```

---

### Soal 16
Tampilkan karyawan dengan gaji antara 5000 dan 10000

**Jawaban:**
```sql
SELECT first_name, last_name, salary
FROM employees
WHERE salary BETWEEN 5000 AND 10000;
```

---

### Soal 17
Tampilkan karyawan yang bekerja sebagai job_id 'SA_MAN' atau 'SA_REP'

**Jawaban:**
```sql
SELECT first_name, last_name, job_id
FROM employees
WHERE job_id IN ('SA_MAN', 'SA_REP');
```

---

### Soal 18
Tampilkan nama karyawan yang memiliki kata 'son' di nama belakang

**Jawaban:**
```sql
SELECT first_name, last_name
FROM employees
WHERE last_name LIKE '%son%';
```

---

### Soal 19
Tampilkan lokasi kota (city) dari tabel locations

**Jawaban:**
```sql
SELECT city FROM locations;
```

---

### Soal 20
Tampilkan nama departemen beserta nama lokasi kota kantornya

**Jawaban:**
```sql
SELECT d.department_name, l.city
FROM departments d
JOIN locations l ON d.location_id = l.location_id;
```

---

## LEVEL MENENGAH - GROUP BY (10 Soal)

### Soal 21
Hitung jumlah karyawan di setiap departemen

**Jawaban:**
```sql
SELECT department_id, COUNT(*) AS jumlah_karyawan
FROM employees
GROUP BY department_id;
```

---

### Soal 22
Hitung rata-rata gaji di setiap departemen

**Jawaban:**
```sql
SELECT department_id, ROUND(AVG(salary), 2) AS rata_rata_gaji
FROM employees
GROUP BY department_id;
```

---

### Soal 23
Hitung total gaji di setiap departemen

**Jawaban:**
```sql
SELECT department_id, SUM(salary) AS total_gaji
FROM employees
GROUP BY department_id;
```

---

### Soal 24
Tampilkan gaji tertinggi di setiap departemen

**Jawaban:**
```sql
SELECT department_id, MAX(salary) AS gaji_tertinggi
FROM employees
GROUP BY department_id;
```

---

### Soal 25
Tampilkan gaji terendah di setiap departemen

**Jawaban:**
```sql
SELECT department_id, MIN(salary) AS gaji_terendah
FROM employees
GROUP BY department_id;
```

---

### Soal 26
Hitung jumlah karyawan berdasarkan job_id

**Jawaban:**
```sql
SELECT job_id, COUNT(*) AS jumlah_karyawan
FROM employees
GROUP BY job_id;
```

---

### Soal 27
Tampilkan departemen yang jumlah karyawannya lebih dari 5 orang

**Jawaban:**
```sql
SELECT department_id, COUNT(*) AS jumlah_karyawan
FROM employees
GROUP BY department_id
HAVING COUNT(*) > 5;
```

---

### Soal 28
Hitung rata-rata gaji per job_id, tampilkan yang rata-ratanya di atas 8000

**Jawaban:**
```sql
SELECT job_id, ROUND(AVG(salary), 2) AS rata_rata_gaji
FROM employees
GROUP BY job_id
HAVING AVG(salary) > 8000;
```

---

### Soal 29
Hitung jumlah karyawan di setiap wilayah (region)

**Jawaban:**
```sql
SELECT r.region_name, COUNT(e.employee_id) AS jumlah_karyawan
FROM employees e
JOIN departments d ON e.department_id = d.department_id
JOIN locations l ON d.location_id = l.location_id
JOIN countries c ON l.country_id = c.country_id
JOIN regions r ON c.region_id = r.region_id
GROUP BY r.region_name;
```

---

### Soal 30
Tampilkan nama departemen beserta jumlah karyawannya

**Jawaban:**
```sql
SELECT d.department_name, COUNT(e.employee_id) AS jumlah_karyawan
FROM employees e
JOIN departments d ON e.department_id = d.department_id
GROUP BY d.department_name;
```

---

## Ringkasan

| Level | Soal | Topik |
|-------|------|-------|
| Basic | 1-20 | SELECT, WHERE, ORDER BY, LIMIT, LIKE, NULL, IN, BETWEEN, JOIN |
| Menengah | 21-30 | GROUP BY, COUNT, AVG, SUM, MAX, MIN, HAVING |
