# Kelas KimElektro untuk merepresentasikan produk elektronik
class KimElektro:
    # =============================
    # Constructor: inisialisasi atribut
    # =============================
    def __init__(self, _id, _nama, _JenisAlat, _harga):
        self.id = _id          # ID unik produk
        self.nama = _nama      # Nama produk
        self.JenisAlat = _JenisAlat  # JenisAlat produk
        self.harga = _harga    # Harga produk (integer)

    # =============================
    # Getter: mengambil nilai atribut
    # =============================
    def getID(self):
        return self.id
    def getNama(self):
        return self.nama
    def getJenisAlat(self):
        return self.JenisAlat
    def getHarga(self):
        return self.harga

    # =============================
    # Setter: mengubah nilai atribut
    # =============================
    def setID(self, _id):
        self.id = _id
    def setNama(self, _nama):
        self.nama = _nama
    def setJenisAlat(self, _JenisAlat):
        self.JenisAlat = _JenisAlat
    def setHarga(self, _harga):
        self.harga = _harga

    # =============================
    # Method untuk menampilkan info barang
    # =============================
    def printElektro(self):
        print(f"ID      : {self.id}")
        print(f"Nama    : {self.nama}")
        print(f"JenisAlat: {self.JenisAlat}")
        print(f"Harga   : {self.harga}")