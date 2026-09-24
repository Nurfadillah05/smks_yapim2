/* =====================================================================
   PANEL ADMIN — script pendukung
   ===================================================================== */
(function () {
  'use strict';

  var $  = function (s) { return document.querySelector(s); };
  var $$ = function (s) { return Array.prototype.slice.call(document.querySelectorAll(s)); };

  /* ---------- 1. Menu samping untuk layar kecil ---------- */
  var samping = $('#samping');
  var buka    = $('#bukaSamping');
  var tirai   = null;

  function tutupSamping() {
    if (samping) samping.classList.remove('terbuka');
    if (tirai) { tirai.remove(); tirai = null; }
  }

  if (buka && samping) {
    buka.addEventListener('click', function () {
      samping.classList.add('terbuka');
      tirai = document.createElement('div');
      tirai.className = 'tirai';
      tirai.addEventListener('click', tutupSamping);
      document.body.appendChild(tirai);
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') tutupSamping();
  });

  /* ---------- 2. Konfirmasi sebelum menghapus ---------- */
  $$('form[data-konfirmasi]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      if (!window.confirm(f.getAttribute('data-konfirmasi'))) {
        e.preventDefault();
      }
    });
  });

  /* ---------- 3. Pratinjau + validasi ukuran ---------- */
  $$('input[type=file][data-pratinjau]').forEach(function (input) {
    input.addEventListener('change', function () {
      var kotak = document.getElementById(input.getAttribute('data-pratinjau'));
      var berkas = input.files && input.files[0];
      if (!berkas) return;

      var maksMb = parseFloat(input.getAttribute('data-maks-mb') || '4');
      var maksByte = maksMb * 1024 * 1024;

      if (berkas.size > maksByte) {
        window.alert('Upload gagal. Ukuran foto maksimal ' + maksMb + ' MB.');
        input.value = '';
        if (kotak) {
          kotak.innerHTML = '<span class="pratinjau__kosong">Belum ada gambar dipilih</span>';
        }
        return;
      }

      if (berkas.type && berkas.type.indexOf('image/') !== 0) {
        window.alert('Upload gagal. File yang dipilih harus berupa foto.');
        input.value = '';
        if (kotak) {
          kotak.innerHTML = '<span class="pratinjau__kosong">Belum ada gambar dipilih</span>';
        }
        return;
      }

      if (!kotak) return;
      var pembaca = new FileReader();
      pembaca.onload = function (ev) {
        kotak.innerHTML = '';
        var img = document.createElement('img');
        img.src = ev.target.result;
        img.alt = 'Pratinjau gambar';
        kotak.appendChild(img);
      };
      pembaca.readAsDataURL(berkas);
    });
  });

  /* Validasi ulang sebelum form dikirim. File asli tidak diubah/di-kompresi di browser. */
  $$('form[enctype="multipart/form-data"]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      var inputs = $$('input[type=file]', form);
      for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        if (!input.files || !input.files[0]) continue;
        var file = input.files[0];
        var maksMb = parseFloat(input.getAttribute('data-maks-mb') || '4');
        if (file.size > maksMb * 1024 * 1024) {
          e.preventDefault();
          window.alert('Upload gagal. Ukuran foto maksimal ' + maksMb + ' MB.');
          return;
        }
        if (file.type && file.type.indexOf('image/') !== 0) {
          e.preventDefault();
          window.alert('Upload gagal. File yang dipilih harus berupa foto.');
          return;
        }
      }
    });
  });

  /* ---------- 4. Pesan notifikasi hilang sendiri ---------- */
  var notif = document.querySelector('.notif');
  if (notif && !notif.classList.contains('notif--gagal')) {
    setTimeout(function () {
      notif.style.transition = 'opacity .5s ease';
      notif.style.opacity = '0';
      setTimeout(function () { notif.remove(); }, 520);
    }, 4500);
  }

})();
