/**
 * Filename: process.js
 * Description: Mengelola logika frontend untuk formulir pendaftaran beasiswa.
 * Author: Bunga
 * Version: 1.0
 * Date: 2-10-2024
 */

/**
 * Fungsi untuk menghasilkan IPK secara acak dan mengatur status form.
 */

function generateIPK() {
    var input = document.getElementById("randomIPK");
    var hiddenInput = document.getElementById("randomIPKInput");
    var jenisBeasiswa = document.getElementById("jenisBeasiswa");
    var inputFile = document.getElementById("inputFile");
    var submitForm = document.getElementById("submitForm");

    // Generate a random IPK
    var randomIPK = (Math.random() * (4.00 - 2.50) + 2.50).toFixed(2);
    input.value = randomIPK;
    hiddenInput.value = randomIPK;
    input.disabled = true; 

    if (parseFloat(randomIPK) < 3.0) {
        jenisBeasiswa.disabled = true;
        inputFile.disabled = true;
        submitForm.disabled = true;
        alert('IPK Anda di bawah 3.0, Anda tidak dapat melanjutkan pendaftaran.');
    } else {
        jenisBeasiswa.disabled = false;
        inputFile.disabled = false;
        submitForm.disabled = false;
    }
}

// Form validation
document.getElementById('formDaftar').addEventListener('submit', function(event) {
    var isValid = true;
    var inputs = this.querySelectorAll('input, select');

    inputs.forEach(function(input) {
        if (input.required && !input.value) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        event.preventDefault(); 
        alert('Harap lengkapi semua kolom yang diperlukan.');
    }
});
