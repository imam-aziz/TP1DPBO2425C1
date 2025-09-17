// Kelas KimElektro merepresentasikan produk elektronik
public class KimElektro {
    // =============================
    // Atribut kelas (private untuk encapsulation)
    // =============================
    private String id;        // ID unik setiap produk
    private String nama;      // Nama produk
    private String JenisAlat;  // JenisAlat produk (misal: TV, Radio, dll)
    private int harga;        // Harga produk dalam bentuk integer

    // =============================
    // Constructor: digunakan untuk membuat objek KimElektro baru
    // =============================
    public KimElektro(String _id, String _nama, String _JenisAlat, int _harga) {
        id = _id;
        nama = _nama;
        JenisAlat = _JenisAlat;
        harga = _harga;
    }

    // =============================
    // Getter: mengambil nilai atribut
    // =============================
    public String getID() { return id; }
    public String getNama() { return nama; }
    public String getJenisAlat() { return JenisAlat; }
    public int getHarga() { return harga; }

    // =============================
    // Setter: mengubah nilai atribut
    // =============================
    public void setID(String _id) { id = _id; }
    public void setNama(String _nama) { nama = _nama; }
    public void setJenisAlat(String _JenisAlat) { JenisAlat = _JenisAlat; }
    public void setHarga(int _harga) { harga = _harga; }

    // =============================
    // Method untuk menampilkan info barang ke console
    // =============================
    public void printElektro() {
        System.out.println("ID      : " + id);
        System.out.println("Nama    : " + nama);
        System.out.println("JenisAlat: " + JenisAlat);
        System.out.println("Harga   : " + harga);
    }
}