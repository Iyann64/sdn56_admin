<?php
$success = session()->getFlashdata('success');
$error   = session()->getFlashdata('error');
?>
<?php if ($success): ?>
<div style="background:#E8F5E9;border:1px solid #C8E6C9;border-left:4px solid #43A047;border-radius:12px;
            padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;
            font-size:14px;color:#2E7D32;font-weight:600">
    ✅ <?= $success ?>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div style="background:#FFEBEE;border:1px solid #FFCDD2;border-left:4px solid #EF5350;border-radius:12px;
            padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;
            font-size:14px;color:#C62828;font-weight:600">
    ⚠️ <?= $error ?>
</div>
<?php endif; ?>