#include <bits/stdc++.h>        // Mengimpor semua library standar C++ (tidak portable)
#include "KimElektro.cpp"       // Mengimpor kelas KimElektro
using namespace std;           // Mempermudah pemanggilan fungsi STL tanpa std::

// =============================
// Fungsi bantu: input harga
// =============================
int inputHarga() {
    string input;
    int harga;

    // Loop hingga input valid (hanya angka)
    while (true) {
        cout << "Masukkan Harga: ";
        cin >> input;

        // Validasi: semua karakter harus digit
        if (all_of(input.begin(), input.end(), ::isdigit)) {
            harga = stoi(input); // konversi string ke integer
            break;
        } else {
            cout << "Input salah! Harga harus berupa angka." << endl;
        }
    }
    return harga;
}

// =============================
// Fungsi bantu: tekan Enter untuk lanjut
// =============================
void pressEnter() {
    cout << "Tekan Enter untuk lanjut...";
    cin.ignore();
    cin.get();
}

// =============================
// Fungsi utama
// =============================
int main() {
    list<KimElektro> data; // Menyimpan semua data barang
    int choice;             // Menyimpan pilihan menu

    do {
        system("cls"); // Bersihkan layar (Windows)
        cout << "=== KimElektro, solusi rumah tanggamu! ===" << endl;
        cout << "1. Tambah Data" << endl;
        cout << "2. Lihat Data" << endl;
        cout << "3. Edit Data" << endl;
        cout << "4. Hapus Data" << endl;
        cout << "5. Cari Data" << endl;
        cout << "6. Keluar" << endl;
        cout << "Pilih menu (1-6): ";
        cin >> choice;

        // Validasi input menu
        if(cin.fail()) {
            cin.clear();
            cin.ignore(numeric_limits<streamsize>::max(), '\n');
            cout << "Input tidak valid! Pilihan harus angka 1-6." << endl;
            pressEnter();
            continue;
        }

        // =============================
        // Menu 1: Tambah Data
        // =============================
        if (choice == 1) {
            string id, nama, JenisAlat;
            int harga;

            cout << "Masukkan ID: ";
            cin >> id;

            // Cek ID unik
            if (any_of(data.begin(), data.end(), [&](KimElektro &e){ return e.getID() == id; })) {
                cout << "ID sudah ada! Gunakan ID lain." << endl;
                pressEnter();
                continue;
            }

            cout << "Masukkan Nama: ";
            cin.ignore();
            getline(cin, nama);

            cout << "Masukkan JenisAlat: ";
            getline(cin, JenisAlat);

            harga = inputHarga(); // Input harga dengan validasi

            // Simpan data baru
            data.push_back(KimElektro(id, nama, JenisAlat, harga));
            cout << "Data berhasil ditambahkan!" << endl;
        }

        // =============================
        // Menu 2: Lihat Data
        // =============================
        else if (choice == 2) {
            if (data.empty()) {
                cout << "Belum ada data!" << endl;
            } else {
                // Tentukan lebar kolom untuk tabel
                int idLen=2, namaLen=4, JenisAlatLen=8, hargaLen=5;
                for (auto &e : data) {
                    idLen = max(idLen, (int)e.getID().length());
                    namaLen = max(namaLen, (int)e.getNama().length());
                    JenisAlatLen = max(JenisAlatLen, (int)e.getJenisAlat().length());
                    hargaLen = max(hargaLen, (int)to_string(e.getHarga()).length());
                }

                // Cetak header tabel
                cout << "+" << string(idLen+2,'-') << "+" << string(namaLen+2,'-')
                     << "+" << string(JenisAlatLen+2,'-') << "+" << string(hargaLen+2,'-') << "+" << endl;

                cout << "| " << setw(idLen) << left << "ID"
                     << " | " << setw(namaLen) << left << "Nama"
                     << " | " << setw(JenisAlatLen) << left << "JenisAlat"
                     << " | " << setw(hargaLen) << left << "Harga"
                     << " |" << endl;

                cout << "+" << string(idLen+2,'-') << "+" << string(namaLen+2,'-')
                     << "+" << string(JenisAlatLen+2,'-') << "+" << string(hargaLen+2,'-') << "+" << endl;

                // Cetak isi data
                for (auto &e : data) {
                    cout << "| " << setw(idLen) << left << e.getID()
                         << " | " << setw(namaLen) << left << e.getNama()
                         << " | " << setw(JenisAlatLen) << left << e.getJenisAlat()
                         << " | " << setw(hargaLen) << left << e.getHarga()
                         << " |" << endl;
                }

                cout << "+" << string(idLen+2,'-') << "+" << string(namaLen+2,'-')
                     << "+" << string(JenisAlatLen+2,'-') << "+" << string(hargaLen+2,'-') << "+" << endl;
            }
        }

        // =============================
        // Menu 3: Edit Data
        // =============================
        else if (choice == 3) {
            string id;
            cout << "Masukkan ID data yang ingin diedit: ";
            cin >> id;

            // Cari data berdasarkan ID
            auto it = find_if(data.begin(), data.end(), [&](KimElektro &e){ return e.getID() == id; });
            if (it != data.end()) {
                cout << "Data ditemukan:" << endl;
                it->printElektro();

                int pilihanEdit;
                do {
                    cout << "Edit apa? (1.Nama, 2.JenisAlat, 3.Harga, 4.ID, 5.Selesai): ";
                    cin >> pilihanEdit;

                    // Edit atribut sesuai pilihan
                    if (pilihanEdit == 1) {
                        string nama;
                        cout << "Nama baru: ";
                        cin.ignore();
                        getline(cin, nama);
                        it->setNama(nama);
                    } 
                    else if (pilihanEdit == 2) {
                        string JenisAlat;
                        cout << "JenisAlat baru: ";
                        cin.ignore();
                        getline(cin, JenisAlat);
                        it->setJenisAlat(JenisAlat);
                    } 
                    else if (pilihanEdit == 3) {
                        int harga = inputHarga();
                        it->setHarga(harga);
                    } 
                    else if (pilihanEdit == 4) {
                        string newID;
                        cout << "ID baru: ";
                        cin >> newID;

                        // Validasi ID baru
                        if (newID == it->getID()) {
                            cout << "ID tetap sama, tidak ada perubahan." << endl;
                        } 
                        else if (any_of(data.begin(), data.end(), [&](KimElektro &e){ return e.getID() == newID; })) {
                            cout << "ID sudah digunakan oleh data lain!" << endl;
                        } 
                        else {
                            it->setID(newID);
                            cout << "ID berhasil diubah." << endl;
                        }
                    }
                } while (pilihanEdit != 5);

                cout << "Data berhasil diedit!" << endl;
            } 
            else {
                cout << "Data tidak ditemukan!" << endl;
            }
        }

        // =============================
        // Menu 4: Hapus Data
        // =============================
        else if (choice == 4) {
            string id;
            cout << "Masukkan ID data yang ingin dihapus: ";
            cin >> id;

            size_t before = data.size();
            data.remove_if([&](KimElektro &e){ return e.getID() == id; });

            if (data.size() < before) {
                cout << "Data berhasil dihapus!" << endl;
            } else {
                cout << "Data tidak ditemukan!" << endl;
            }
        }

        // =============================
        // Menu 5: Cari Data
        // =============================
        else if (choice == 5) {
            string id;
            cout << "Masukkan ID yang dicari: ";
            cin >> id;

            auto it = find_if(data.begin(), data.end(), [&](KimElektro &e){ return e.getID() == id; });
            if (it != data.end()) {
                it->printElektro();
            } else {
                cout << "Data tidak ditemukan!" << endl;
            }
        }

        // Menu 6: Keluar
        else if (choice == 6) {
            cout << "Terimakasih telah berkunjung di KimElektro!" << endl;
        }

        // Pilihan invalid
        else {
            cout << "Opsi yang tersedia hanya 1-6!" << endl;
        }

        if (choice != 6) pressEnter();

    } while (choice != 6);

    return 0;
}