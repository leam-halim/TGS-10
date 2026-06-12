<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item Baru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 600px;">
        <h3 class="mb-3 text-success">Form Tambah & Upload Gambar</h3>
        
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('item/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Judul Item</label>
                <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required><?= old('description') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Gambar <small class="text-danger">(Hanya .jpg atau .png)</small></label>
                <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan & Upload Berkas</button>
            <a href="<?= base_url('item') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>