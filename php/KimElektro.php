<?php
// =====================
// Class KimElektro
// Representasi barang elektronik di toko
// =====================
class KimElektro {
    private $id;       // ID unik barang
    private $nama;     // Nama barang
    private $JenisAlat; // JenisAlat barang
    private $harga;    // Harga barang (integer)
    private $gambar;   // Path file gambar lokal

    // =====================
    // Konstruktor
    // =====================
    public function __construct($id, $nama, $JenisAlat, $harga, $gambar=""){
        $this->id = $id;
        $this->nama = $nama;
        $this->JenisAlat = $JenisAlat;
        $this->harga = $harga;
        $this->gambar = $gambar;
    }

    // =====================
    // Getter (ambil nilai properti)
    // =====================
    public function getID(){ return $this->id; }
    public function getNama(){ return $this->nama; }
    public function getJenisAlat(){ return $this->JenisAlat; }
    public function getHarga(){ return $this->harga; }
    public function getGambar(){ return $this->gambar; }

    // =====================
    // Setter (ubah nilai properti)
    // =====================
    public function setID($id){ $this->id = $id; }
    public function setNama($nama){ $this->nama = $nama; }
    public function setJenisAlat($JenisAlat){ $this->JenisAlat = $JenisAlat; }
    public function setHarga($harga){ $this->harga = $harga; }
    public function setGambar($gambar){ $this->gambar = $gambar; }
}
?>