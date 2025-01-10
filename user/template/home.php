<?php 
    $id = $_SESSION['user']['id_member'];
    $hasil_profil = $lihat -> member_edit($id);
?>
<div class="container my-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Selamat Datang, <span class="text-primary">[Nama Pengguna]</span></h3>
        <div>
            <span class="me-3"><i class="bi bi-wallet2"></i> Saldo: <strong>Rp <?php echo number_format($saldo); ?></strong></span>
            <a href="index.php?page=keranjang" class="btn btn-primary">
                <i class="bi bi-cart4"></i> Keranjang <span class="badge bg-light text-dark"><?php echo $total_item; ?></span>
            </a>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="row g-4">
        <?php foreach ($produk as $item): ?>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <img src="images/<?php echo $item['gambar']; ?>" class="card-img-top" alt="<?php echo $item['nama']; ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $item['nama']; ?></h5>
                    <p class="card-text text-muted">Rp <?php echo number_format($item['harga']); ?></p>
                    <div class="mt-auto">
                        <form action="index.php?page=add_to_cart" method="POST">
                            <input type="hidden" name="id_produk" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-cart-plus"></i> Tambahkan ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
