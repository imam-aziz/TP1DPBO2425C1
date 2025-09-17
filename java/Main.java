import java.util.*;

// Kelas Main untuk menjalankan menu interaktif KimElektro
public class Main {
    private static Scanner sc = new Scanner(System.in); // Scanner global untuk input user

    // =============================
    // Fungsi inputHarga: validasi input harga agar hanya angka
    // =============================
    public static int inputHarga(){
        int harga = 0;
        while(true){
            System.out.print("Masukkan Harga: ");
            String input = sc.nextLine();
            // Pastikan semua karakter adalah digit
            if(input.chars().allMatch(Character::isDigit)){
                harga = Integer.parseInt(input);
                break;
            } else System.out.println("Input salah! Harga harus berupa angka.");
        }
        return harga;
    }

    // =============================
    // Fungsi pressEnter: pause program hingga user menekan Enter
    // =============================
    public static void pressEnter(){
        System.out.print("Tekan Enter untuk lanjut...");
        sc.nextLine();
    }

    // =============================
    // Fungsi utama
    // =============================
    public static void main(String[] args){
        List<KimElektro> data = new ArrayList<>(); // Menyimpan semua data barang
        int choice = 0;                             // Pilihan menu

        while(choice != 6){
            // =============================
            // Tampilkan menu
            // =============================
            System.out.println("\n=== KimElektro, solusi rumah tanggamu! ===");
            System.out.println("1. Tambah Data");
            System.out.println("2. Lihat Data");
            System.out.println("3. Edit Data");
            System.out.println("4. Hapus Data");
            System.out.println("5. Cari Data");
            System.out.println("6. Keluar");
            System.out.print("Pilih menu (1-6): ");

            // Validasi input menu
            String line = sc.nextLine();
            if(!line.chars().allMatch(Character::isDigit)){
                System.out.println("Input tidak valid! Pilihan harus angka 1-6.");
                pressEnter();
                continue;
            }
            choice = Integer.parseInt(line);

            // =============================
            // Menu 1: Tambah Data
            // =============================
            if(choice == 1){
                System.out.print("Masukkan ID: ");
                String id = sc.nextLine();

                // Cek apakah ID sudah ada
                boolean exists = false;
                Iterator<KimElektro> it = data.iterator();
                while(it.hasNext()){
                    if(it.next().getID().equals(id)){ exists = true; break; }
                }
                if(exists){
                    System.out.println("ID sudah ada! Gunakan ID lain.");
                    pressEnter();
                    continue;
                }

                // Input data lain
                System.out.print("Masukkan Nama: ");
                String nama = sc.nextLine();
                System.out.print("Masukkan JenisAlat: ");
                String JenisAlat = sc.nextLine();
                int harga = inputHarga();

                // Tambah data ke list
                data.add(new KimElektro(id,nama,JenisAlat,harga));
                System.out.println("Data berhasil ditambahkan!");
            }

            // =============================
            // Menu 2: Lihat Data
            // =============================
            else if(choice == 2){
                if(data.isEmpty()){ 
                    System.out.println("Belum ada data!"); 
                } else {
                    // Tentukan panjang kolom tabel berdasarkan data
                    int idLen=2, namaLen=4, JenisAlatLen=8, hargaLen=5;
                    for(KimElektro e : data){
                        idLen = Math.max(idLen, e.getID().length());
                        namaLen = Math.max(namaLen, e.getNama().length());
                        JenisAlatLen = Math.max(JenisAlatLen, e.getJenisAlat().length());
                        hargaLen = Math.max(hargaLen, String.valueOf(e.getHarga()).length());
                    }

                    // Buat header tabel
                    String lineTable = "+" + "-".repeat(idLen+2) + "+" + "-".repeat(namaLen+2) + "+" + "-".repeat(JenisAlatLen+2) + "+" + "-".repeat(hargaLen+2) + "+";
                    System.out.println(lineTable);
                    System.out.printf("| %-" + idLen + "s | %-" + namaLen + "s | %-" + JenisAlatLen + "s | %-" + hargaLen + "s |\n","ID","Nama","JenisAlat","Harga");
                    System.out.println(lineTable);

                    // Cetak semua data
                    for(KimElektro e : data){
                        System.out.printf("| %-" + idLen + "s | %-" + namaLen + "s | %-" + JenisAlatLen + "s | %-" + hargaLen + "d |\n",
                            e.getID(), e.getNama(), e.getJenisAlat(), e.getHarga());
                    }
                    System.out.println(lineTable);
                }
            }

            // =============================
            // Menu 3: Edit Data
            // =============================
            else if(choice == 3){
                System.out.print("Masukkan ID data yang ingin diedit: ");
                String id = sc.nextLine();
                KimElektro target = null;
                for(KimElektro e : data){
                    if(e.getID().equals(id)){ target = e; break; }
                }
                if(target == null){ 
                    System.out.println("Data tidak ditemukan!"); 
                    pressEnter(); 
                    continue; 
                }

                target.printElektro();

                // Menu edit atribut
                int editChoice = 0;
                while(editChoice != 5){
                    System.out.print("Edit apa? (1.Nama,2.JenisAlat,3.Harga,4.ID,5.Selesai): ");
                    String ec = sc.nextLine();
                    if(!ec.chars().allMatch(Character::isDigit)){ 
                        System.out.println("Input salah"); 
                        continue; 
                    }
                    editChoice = Integer.parseInt(ec);

                    switch(editChoice){
                        case 1 -> { System.out.print("Nama baru: "); target.setNama(sc.nextLine()); }
                        case 2 -> { System.out.print("JenisAlat baru: "); target.setJenisAlat(sc.nextLine()); }
                        case 3 -> target.setHarga(inputHarga());
                        case 4 -> {
                            System.out.print("ID baru: "); 
                            String newID = sc.nextLine();
                            if(newID.equals(target.getID())) System.out.println("ID tetap sama.");
                            else{
                                boolean exists = false;
                                for(KimElektro e : data){ if(e.getID().equals(newID)){ exists=true; break; } }
                                if(exists) System.out.println("ID sudah digunakan!");
                                else{ target.setID(newID); System.out.println("ID berhasil diubah."); }
                            }
                        }
                    }
                }
                System.out.println("Data berhasil diedit!");
            }

            // =============================
            // Menu 4: Hapus Data
            // =============================
            else if(choice == 4){
                System.out.print("Masukkan ID data yang ingin dihapus: ");
                String id = sc.nextLine();
                int before = data.size();
                Iterator<KimElektro> it = data.iterator();
                while(it.hasNext()){ 
                    if(it.next().getID().equals(id)){ it.remove(); break; } 
                }
                if(data.size() < before) System.out.println("Data berhasil dihapus!");
                else System.out.println("Data tidak ditemukan!");
            }

            // =============================
            // Menu 5: Cari Data
            // =============================
            else if(choice == 5){
                System.out.print("Masukkan ID yang dicari: ");
                String id = sc.nextLine();
                KimElektro target = null;
                for(KimElektro e : data){ if(e.getID().equals(id)){ target = e; break; } }
                if(target != null) target.printElektro();
                else System.out.println("Data tidak ditemukan!");
            }

            // =============================
            // Menu 6: Keluar
            // =============================
            else if(choice == 6){ 
                System.out.println("Terimakasih telah berkunjung di KimElektro!"); 
            }
            else{ 
                System.out.println("Opsi yang tersedia hanya 1-6!"); 
            }

            if(choice!=6) pressEnter(); // Pause sebelum menu muncul lagi
        }
    }
}