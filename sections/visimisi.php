<?php /* ============ VISI & MISI ============ */ ?>
<section class="visimisi seksi" id="visi-misi">
  <div class="visimisi__dekor" aria-hidden="true">
    <span class="visimisi__orb visimisi__orb--1"></span>
    <span class="visimisi__orb visimisi__orb--2"></span>
    <span class="visimisi__ring visimisi__ring--1"></span>
    <span class="visimisi__ring visimisi__ring--2"></span>
  </div>

  <div class="wadah">
    <div class="seksi__kepala seksi__kepala--tengah reveal">
      <p class="seksi__label seksi__label--terang">Arah Sekolah</p>
      <h2 class="seksi__judul seksi__judul--terang">Visi &amp; Misi</h2>
      <p class="seksi__ket seksi__ket--terang">Dibuat seperti kartu informasi agar isinya tetap lengkap, tetapi tidak memenuhi layar sekaligus.</p>
    </div>

    <div class="vm-tabs" role="tablist" aria-label="Visi dan Misi Sekolah">
      <button class="vm-tab aktif" type="button" role="tab" aria-selected="true" aria-controls="panel-visi" id="tab-visi" data-vm-tab="visi">
        <span class="vm-tab__icon"><?= ikon('visi', 24) ?></span>
        <span>Visi</span>
      </button>
      <button class="vm-tab" type="button" role="tab" aria-selected="false" aria-controls="panel-misi" id="tab-misi" data-vm-tab="misi">
        <span class="vm-tab__icon"><?= ikon('topi', 24) ?></span>
        <span>Misi</span>
      </button>
    </div>

    <div class="vm-showcase">
      <article class="vm-card vm-card--visi vm-aktif" id="panel-visi" role="tabpanel" aria-labelledby="tab-visi">
        <div class="vm-card__top">
          <span class="vm-card__ikon"><?= ikon('visi', 28) ?></span>
          <div><small>01 · ARAH</small><h3>Visi Sekolah</h3></div>
          <span class="vm-card__count"><?= count($visi_poin) ?> poin</span>
        </div>
        <div class="vm-card__scroll"><ol><?php foreach ($visi_poin as $v): ?><li><?= e($v) ?></li><?php endforeach; ?></ol></div>
      </article>

      <article class="vm-card vm-card--misi" id="panel-misi" role="tabpanel" aria-labelledby="tab-misi" hidden>
        <div class="vm-card__top">
          <span class="vm-card__ikon"><?= ikon('topi', 28) ?></span>
          <div><small>02 · LANGKAH</small><h3>Misi Sekolah</h3></div>
          <span class="vm-card__count"><?= count($misi_poin) ?> poin</span>
        </div>
        <div class="vm-card__scroll"><ol><?php foreach ($misi_poin as $m): ?><li><?= e($m) ?></li><?php endforeach; ?></ol></div>
      </article>
    </div>
  </div>
</section>
