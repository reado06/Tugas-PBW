const kalkulator = {
  tambah: (...angka) => {
    let hasil = 0;
    for (let i = 0; i < angka.length; i++) {
      hasil += angka[i];
    }
    return hasil;
  },

  kurang: (...angka) => {
    let hasil = angka[0];
    for (let i = 1; i < angka.length; i++) {
      hasil -= angka[i];
    }
    return hasil;
  },

  kali: (...angka) => {
    let hasil = 1;
    for (let i = 0; i < angka.length; i++) {
      hasil *= angka[i];
    }
    return hasil;
  },

  bagi: (...angka) => {
    let hasil = angka[0];
    for (let i = 1; i < angka.length; i++) {
      hasil /= angka[i];
    }
    return hasil;
  },

  modulus: (...angka) => {
    let hasil = angka[0];
    for (let i = 1; i < angka.length; i++) {
      hasil %= angka[i];
    }
    return hasil;
  },
};

console.log("Penjumlahan: " + kalkulator.tambah(10, 5, 2));
console.log("Pengurangan: " + kalkulator.kurang(10, 5, 2));
console.log("Perkalian  : " + kalkulator.kali(10, 5, 2));
console.log("Pembagian  : " + kalkulator.bagi(10, 5));
console.log("Modulo     : " + kalkulator.modulus(10, 3));
