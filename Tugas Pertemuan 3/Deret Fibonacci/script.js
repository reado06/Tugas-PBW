const jumlahDeret = 6;

if (jumlahDeret <= 0) {
  console.log("Input yang anda masukkan salah!");
} else if (jumlahDeret === 1) {
  console.log("Deret Fibonacci hingga deret ke-" + jumlahDeret + ": 0");
} else {
  let fibArray = [0, 1];

  for (let i = 2; i < jumlahDeret; i++) {
    fibArray[i] = fibArray[i - 1] + fibArray[i - 2];
  }

  console.log("Deret Fibonacci hingga deret ke-" + jumlahDeret + ": " + fibArray.join(", "));
}
