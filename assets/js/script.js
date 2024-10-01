// Menginisialisasi datatable agar dapat dijalankan
const table = new DataTable('#dataTable', {
  columnDefs: [
    {
      searchable: false,
      orderable: false,
      targets: 0
    }
  ],
  order: [[0, 'ASC']]
});

table
  .on('order.dt search.dt', function () {
    let i = 1;

    table
      .cells(null, 0, { search: 'applied', order: 'applied' })
      .every(function (cell) {
        this.data(i++);
      });
  })
  .draw();

// Logika untuk button back to top
document.addEventListener("DOMContentLoaded", function () {
  // Mengambil id button
  var backToTopButton = document.getElementById("backToTopBtn");

  // Logika ketika halaman di scroll, maka akan muncul button
  window.addEventListener("scroll", function () {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      backToTopButton.style.display = "block";
      backToTopButton.style.visibility = "visible";
    } else {
      backToTopButton.style.display = "none";
      backToTopButton.style.visibility = "hidden";
    }
  });

  // Logika ketika button di click maka halaman akan kembali ke atas
  backToTopButton.addEventListener("click", function () {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  });
});

// Fungsi untuk validasi data inputan dari user
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

// Fungsi untuk generate IPK
function generateIPK() {
  // Memanggil objek dengan ID
  var select = document.getElementById("semester");
  var input = document.getElementById("randomIPK");
  var jenisBeasiswa = document.getElementById("jenisBeasiswa");
  var inputFile = document.getElementById("inputFile");
  var submitForm = document.getElementById("submitForm");

  // Membuat Value IPK Random
  var randomIPK = 0;
  var randomIPK = (Math.random() * (4.00 - 2.50) + 2.50).toFixed(2);

  // Display data based on the selected option
  switch (select.value) {
    case "1":
    case "2":
    case "3":
    case "4":
    case "5":
    case "6":
    case "7":
    case "8":
      input.value = randomIPK;
      input.innerHTML = randomIPK;
      document.querySelector('input[name="randomIPK"]').value = randomIPK;
      break;
    default:
      input.textContent = 0.00;
      input.value = 0.00;
  }

  // Kondisi untuk IPK dibawah 3 maka pendaftaran tidak dapat dilanjutkan
  if (parseFloat(randomIPK) < 3) {
    jenisBeasiswa.disabled = true;
    inputFile.disabled = true;
    submitForm.disabled = true;
  }
  else {
    jenisBeasiswa.disabled = false;
    inputFile.disabled = false;
    submitForm.disabled = false;
  }

  return randomIPK;
}

// fungsi untuk mentrigger button cancel
function cancel() {
  // Memanggil objek dengan ID
  var jenisBeasiswa = document.getElementById("jenisBeasiswa");
  var inputFile = document.getElementById("inputFile");
  var submitForm = document.getElementById("submitForm");

  // Mengembalikan form menjadi kosong
  jenisBeasiswa.disabled = false;
  inputFile.disabled = false;
  submitForm.disabled = false;
  document.formDaftar.reset();
}
