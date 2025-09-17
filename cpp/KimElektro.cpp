#include <bits/stdc++.h>  // Mengimpor hampir semua header standar C++ sekaligus
using namespace std;      // Menggunakan namespace std agar tidak perlu menulis std:: sebelum fungsi/kelas STL

// Kelas KimElektro untuk merepresentasikan produk elektronik
class KimElektro {
private:
    string id;        // ID unik setiap produk
    string nama;      // Nama produk
    string JenisAlat;  // JenisAlat produk
    int harga;        // Harga produk dalam bentuk integer

public:
    // Constructor: digunakan untuk membuat objek KimElektro baru
    KimElektro(string _id, string _nama, string _JenisAlat, int _harga)
        : id(_id), nama(_nama), JenisAlat(_JenisAlat), harga(_harga) {}

    // Getter: mengambil nilai atribut
    string getID() { return id; }
    string getNama() { return nama; }
    string getJenisAlat() { return JenisAlat; }
    int getHarga() { return harga; }

    // Setter: mengubah nilai atribut
    void setID(string _id) { id = _id; }
    void setNama(string _nama) { nama = _nama; }
    void setJenisAlat(string _JenisAlat) { JenisAlat = _JenisAlat; }
    void setHarga(int _harga) { harga = _harga; }

    // Method untuk mencetak info barang ke console
    void printElektro() {
        cout << "ID      : " << id << endl;
        cout << "Nama    : " << nama << endl;
        cout << "JenisAlat: " << JenisAlat << endl;
        cout << "Harga   : " << harga << endl;
    }

    // Destructor: dipanggil saat objek dihapus (tidak melakukan aksi khusus di sini)
    ~KimElektro(){}
};