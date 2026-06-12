<?php

namespace App\Controllers;

use App\Models\ItemModel;
use CodeIgniter\Controller;

class Item extends Controller
{
    protected $itemModel;

    public function __construct()
    {
        // Inisialisasi model agar bisa dipakai di semua fungsi
        $this->itemModel = new ItemModel();
    }

    // 1. READ: Menampilkan halaman utama berisi list data teks & gambar
    public function index()
    {
        $data['items'] = $this->itemModel->findAll();
        return view('items/index', $data);
    }

    // 2. Tampilan Form Tambah Data
    public function create()
    {
        return view('items/create');
    }

    // 3. CREATE: Proses validasi ekstensi, upload file fisik, dan simpan data ke Postgres
    public function store()
    {
        // Aturan Validasi (Hanya menerima .jpg atau .png)
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'image_file'  => 'uploaded[image_file]|max_size[image_file,2048]|ext_in[image_file,jpg,jpeg,png]',
        ];

        // Jika form atau gambar tidak sesuai aturan, kembalikan ke form beserta pesan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image_file');
        
        if ($image->isValid() && !$image->hasMoved()) {
            // Berikan nama acak agar nama file tidak bentrok/terganti di folder lokal
            $newName = $image->getRandomName();
            
            // Pindahkan file ke direktori lokal sesuai spesifikasi: public/assets/img/upload/
            $image->move(FCPATH . 'assets/img/upload/', $newName);

            // Simpan record data teks dan nama file ke PostgreSQL
            $this->itemModel->save([
                'title'       => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'image_name'  => $newName
            ]);

            return redirect()->to('/item')->with('success', 'Data dan gambar sukses diunggah ke PostgreSQL!');
        }

        return redirect()->back()->with('error', 'Gagal memproses unggahan gambar.');
    }

    // 4. Tampilan Form Edit Data
    public function edit($id)
    {
        $data['item'] = $this->itemModel->find($id);
        if (!$data['item']) {
            return redirect()->to('/item')->with('error', 'Data tidak ditemukan.');
        }
        return view('items/edit', $data);
    }

    // 5. UPDATE: Proses validasi dan update data beserta gambar (opsional)
    public function update($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to('/item')->with('error', 'Data tidak ditemukan.');
        }

        // Aturan Validasi (Gambar bersifat opsional saat update)
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'image_file'  => 'if_exist|max_size[image_file,2048]|ext_in[image_file,jpg,jpeg,png]',
        ];

        // Jika form tidak sesuai aturan, kembalikan ke form beserta pesan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image_file');
        $imageName = $item['image_name'];

        // Jika ada file gambar baru yang di-upload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Hapus gambar lama terlebih dahulu
            $oldFilePath = FCPATH . 'assets/img/upload/' . $item['image_name'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Upload gambar baru
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'assets/img/upload/', $newName);
            $imageName = $newName;
        }

        // Update data ke database
        $this->itemModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image_name'  => $imageName
        ]);

        return redirect()->to('/item')->with('success', 'Data berhasil diperbarui!');
    }

    // 6. DELETE: Menghapus data di DB sekaligus menghapus file fisik di folder lokal agar tidak jadi sampah
    public function delete($id)
    {
        $item = $this->itemModel->find($id);
        if ($item) {
            $filePath = FCPATH . 'assets/img/upload/' . $item['image_name'];
            if (file_exists($filePath)) {
                unlink($filePath); // Fungsi hapus file fisik di server Ubuntu kamu
            }
            $this->itemModel->delete($id);
        }
        return redirect()->to('/item')->with('success', 'Data berhasil dihapus.');
    }
}