<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem CRUD CI4 + PostgreSQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 900px;">
        <h2 class="mb-4 text-primary">Daftar Item (CRUD PostgreSQL & File Upload)</h2>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <a href="<?= base_url('item/create') ?>" class="btn btn-success mb-3">Tambah Item Baru</a>

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Item</th>
                    <th>Deskripsi</th>
                    <th>Preview Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($items)): ?>
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data di database PostgreSQL.</td></tr>
                <?php else: ?>
                    <?php $no=1; foreach($items as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= esc($row['title']) ?></strong></td>
                        <td><?= esc($row['description']) ?></td>
                        <td>
                            <img src="<?= base_url('assets/img/upload/' . $row['image_name']) ?>" width="100" class="img-thumbnail" alt="Uploaded Image">
                        </td>
                        <td>
                            <a href="<?= base_url('item/edit/'.$row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('item/delete/'.$row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data beserta gambar fisik di Ubuntu?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>