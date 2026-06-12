<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 600px;">
        <h3 class="mb-3 text-primary">Form Edit Item & Gambar</h3>
        
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('item/update/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Judul Item</label>
                <input type="text" name="title" class="form-control" value="<?= old('title') ?? esc($item['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required><?= old('description') ?? esc($item['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <div class="mb-2">
                    <img src="<?= base_url('assets/img/upload/' . $item['image_name']) ?>" width="150" class="img-thumbnail" alt="Current Image">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Ganti Gambar <small class="text-muted">(Hanya .jpg atau .png, opsional)</small></label>
                <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="<?= base_url('item') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
