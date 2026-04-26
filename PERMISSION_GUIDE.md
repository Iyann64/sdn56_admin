# 🔐 PERMISSION & ROLE-BASED ACCESS CONTROL

Sistem permission untuk pembatasan akses berdasarkan role user di admin panel SDN 56 Prabumulih.

---

## 📋 PERMISSION MATRIX

| Feature | Super Admin | Kepala Sekolah | Operator |
|---------|:-----------:|:--------------:|:--------:|
| **Dashboard** | ✅ View | ✅ View | ✅ View |
| **Berita** | ✅ Full | ✅ Create, View, Edit | ✅ Full |
| **PPDB** | ✅ Full | ⚠️ View Only | ✅ Full |
| **Agenda** | ✅ Full | ✅ Create, View, Edit | ✅ Full |
| **Galeri** | ✅ Full | ✅ Create, View | ✅ Full |
| **Guru** | ✅ Full | ✅ View Only | ✅ Full |
| **Settings** | ✅ Full | ❌ No Access | ❌ No Access |

---

## 🛠️ FILE YANG DIMODIFIKASI/DIBUAT

### 1. **Filters**
- **File**: `app/Filters/RoleFilter.php` (BARU)
  - Mengecek role user untuk setiap route
  - Melindungi route dari akses unauthorized

### 2. **Config**
- **File**: `app/Config/Filters.php`
  - Menambah alias `'role' => RoleFilter::class`
  - Mengaktifkan role filtering

- **File**: `app/Config/Routes.php`
  - Menambahkan filter ke route yang membutuhkan permission
  - Contoh: `['filter' => 'role:Super Admin,Operator']`

### 3. **Helpers**
- **File**: `app/Helpers/PermissionHelper.php` (BARU)
  - Helper function untuk checking permission di controller & view
  - Function tersedia:
    - `hasPermission($resource, $action)` - Check permission detail
    - `canAccess($resource)` - Check akses view resource
    - `getUserRole()` - Get role user
    - `isSuperAdmin()` - Check if Super Admin
    - `isKepalaSekolah()` - Check if Kepala Sekolah
    - `isOperator()` - Check if Operator

### 4. **Controllers**
- **File**: `app/Controllers/BaseController.php`
  - Menambahkan `'permission'` ke `$helpers`
  - Otomatis load PermissionHelper di semua controller

### 5. **Views**
- **File**: `app/Views/partials/sidebar.php`
  - Menampilkan menu hanya untuk role yang punya akses
  - Menggunakan `canAccess()` function

---

## 💻 CARA MENGGUNAKAN

### Di Controller
```php
// Check permission untuk resource tertentu
if (!hasPermission('berita', 'delete')) {
    return redirect()->back()->with('error', 'Anda tidak punya akses');
}

// Atau lebih sederhana
if (!canAccess('ppdb')) {
    // User tidak punya akses
}

// Check specific role
if (!isSuperAdmin()) {
    // Hanya Super Admin bisa akses
}
```

### Di View (Blade/PHP)
```php
<!-- Tampilkan tombol hanya untuk role tertentu -->
<?php if (hasPermission('berita', 'delete')): ?>
    <a href="<?= base_url('berita/hapus/' . $id) ?>" class="btn btn-danger">Hapus</a>
<?php endif; ?>

<!-- Atau gunakan function shortcut -->
<?php if (isSuperAdmin()): ?>
    <div>Ini hanya untuk Super Admin</div>
<?php endif; ?>
```

### Di Route
```php
// Hanya Super Admin yang bisa akses
$routes->get('/settings', 'Settings::index', ['filter' => 'role:Super Admin']);

// Super Admin dan Operator bisa akses
$routes->get('/berita', 'BeritaAdmin::index', ['filter' => 'role:Super Admin,Operator']);

// Semua role yang sudah login bisa akses
$routes->get('/dashboard', 'Dashboard::index');
```

---

## 🔒 TESTING PERMISSION

### Login dengan berbagai role:

**Super Admin**
- Username: `admin`
- Password: `admin123`
- Akses: Semua fitur tanpa batasan

**Kepala Sekolah**
- Username: `kepala`
- Password: `sdn56pbm`
- Akses: Berita (C/R/U), Agenda (C/R/U), Galeri (C/U), PPDB (R only), Guru (R only)

**Operator**
- Username: `operator`
- Password: `operator56`
- Akses: Semua fitur kecuali Settings

---

## ⚠️ PENTING

1. **Route Protection**: Semua route protected di level URL (RoleFilter)
2. **UI Hiding**: Menu di sidebar juga di-hide dengan `canAccess()`
3. **Double Protection**: User tidak bisa akses via URL & tidak ada tombol/link yang tampil

---

## 📝 MODIFYING PERMISSIONS

Untuk mengubah permission, edit file: `app/Helpers/PermissionHelper.php`

Di dalam function `hasPermission()`, ubah array `$permissions`:

```php
$permissions = [
    'Kepala Sekolah' => [
        'berita' => ['view', 'create', 'edit'],     // ← ubah di sini
        'agenda' => ['view', 'create', 'edit'],
        // ...
    ],
];
```

**Action yang tersedia**: `view`, `create`, `edit`, `delete`

---

## 🚀 NEXT STEPS

1. Test semua route dengan user yang berbeda
2. Monitor logs untuk unauthorized access attempts
3. Tambahkan activity logging jika diperlukan

---

**Last Updated**: April 22, 2026
