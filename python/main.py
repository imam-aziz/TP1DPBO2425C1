from KimElektro import KimElektro

# =============================
# Fungsi inputHarga: validasi input harga agar hanya angka
# =============================
def inputHarga():
    while True:
        val = input("Masukkan Harga: ")
        if val.isdigit():
            return int(val)
        else:
            print("Input salah! Harga harus berupa angka.")

# =============================
# Fungsi pressEnter: pause program hingga user menekan Enter
# =============================
def pressEnter():
    input("Tekan Enter untuk lanjut...")

# =============================
# List untuk menyimpan semua data KimElektro
# =============================
data = []

choice = 0
while choice != 6:
    # =============================
    # Tampilkan menu
    # =============================
    print("\n=== KimElektro, solusi rumah tanggamu! ===")
    print("1. Tambah Data")
    print("2. Lihat Data")
    print("3. Edit Data")
    print("4. Hapus Data")
    print("5. Cari Data")
    print("6. Keluar")
    
    line = input("Pilih menu (1-6): ")
    if not line.isdigit():
        print("Input tidak valid! Pilihan harus angka 1-6.")
        pressEnter()
        continue
    choice = int(line)

    # =============================
    # Menu 1: Tambah Data
    # =============================
    if choice == 1:
        id = input("Masukkan ID: ")

        # Cek apakah ID sudah ada
        exists = any(e.getID() == id for e in data)
        if exists:
            print("ID sudah ada! Gunakan ID lain.")
            pressEnter()
            continue

        # Input data lain
        nama = input("Masukkan Nama: ")
        JenisAlat = input("Masukkan JenisAlat: ")
        harga = inputHarga()

        # Tambah data ke list
        data.append(KimElektro(id, nama, JenisAlat, harga))
        print("Data berhasil ditambahkan!")

    # =============================
    # Menu 2: Lihat Data
    # =============================
    elif choice == 2:
        if not data:
            print("Belum ada data!")
        else:
            # Tentukan lebar kolom otomatis berdasarkan data
            idLen = max(2, *(len(e.getID()) for e in data))
            namaLen = max(4, *(len(e.getNama()) for e in data))
            JenisAlatLen = max(8, *(len(e.getJenisAlat()) for e in data))
            hargaLen = max(5, *(len(str(e.getHarga())) for e in data))

            # Buat header tabel
            line_table = "+" + "-"*(idLen+2) + "+" + "-"*(namaLen+2) + "+" + "-"*(JenisAlatLen+2) + "+" + "-"*(hargaLen+2) + "+"
            print(line_table)
            print(f"| {'ID':<{idLen}} | {'Nama':<{namaLen}} | {'JenisAlat':<{JenisAlatLen}} | {'Harga':<{hargaLen}} |")
            print(line_table)

            # Cetak semua data
            for e in data:
                print(f"| {e.getID():<{idLen}} | {e.getNama():<{namaLen}} | {e.getJenisAlat():<{JenisAlatLen}} | {e.getHarga():<{hargaLen}} |")
            print(line_table)

    # =============================
    # Menu 3: Edit Data
    # =============================
    elif choice == 3:
        id = input("Masukkan ID data yang ingin diedit: ")
        target = next((e for e in data if e.getID() == id), None)
        if not target:
            print("Data tidak ditemukan!")
            pressEnter()
            continue

        target.printElektro()

        editChoice = 0
        while editChoice != 5:
            ec = input("Edit apa? (1.Nama,2.JenisAlat,3.Harga,4.ID,5.Selesai): ")
            if not ec.isdigit():
                print("Input salah!")
                continue
            editChoice = int(ec)

            if editChoice == 1:
                target.setNama(input("Nama baru: "))
            elif editChoice == 2:
                target.setJenisAlat(input("JenisAlat baru: "))
            elif editChoice == 3:
                target.setHarga(inputHarga())
            elif editChoice == 4:
                newID = input("ID baru: ")
                if newID == target.getID():
                    print("ID tetap sama, tidak ada perubahan.")
                else:
                    exists = any(e.getID() == newID for e in data)
                    if exists:
                        print("ID sudah digunakan oleh data lain!")
                    else:
                        target.setID(newID)
                        print("ID berhasil diubah.")
        print("Data berhasil diedit!")

    # =============================
    # Menu 4: Hapus Data
    # =============================
    elif choice == 4:
        id = input("Masukkan ID data yang ingin dihapus: ")
        before = len(data)
        data = [e for e in data if e.getID() != id]
        if len(data) < before:
            print("Data berhasil dihapus!")
        else:
            print("Data tidak ditemukan!")

    # =============================
    # Menu 5: Cari Data
    # =============================
    elif choice == 5:
        id = input("Masukkan ID yang dicari: ")
        target = next((e for e in data if e.getID() == id), None)
        if target:
            target.printElektro()
        else:
            print("Data tidak ditemukan!")

    # =============================
    # Menu 6: Keluar
    # =============================
    elif choice == 6:
        print("Terimakasih telah berkunjung di KimElektro!")

    else:
        print("Opsi yang tersedia hanya 1-6!")

    if choice != 6:
        pressEnter()