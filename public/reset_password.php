<?php
// public/reset_password.php
// HAPUS FILE INI SETELAH SELESAI!

$db = new mysqli('localhost', 'root', '', 'sdn56_db');

$users = [
    'operator'    => 'operator56',
    'kepsek'     => 'kepsek56',
    'admin2'   => 'admin22',
];

foreach ($users as $username => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $db->query("UPDATE users SET password='$hash' WHERE username='$username'");
    echo "✅ $username → password: $password<br>";
}

echo "<br>Selesai! Hapus file ini sekarang.";