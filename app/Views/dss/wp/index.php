<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
    <p>
        Weighted Product is a decision-making method commonly used in multi-criteria decision analysis (MCDA) to evaluate and rank alternatives based on multiple criteria. In this method, each criterion is assigned a weight reflecting its relative importance in the decision-making process.
    </p>
    </p>
    <div class="alert alert-light border-info text-dark">I am learning from <a href="http://repository.unmuhjember.ac.id/2589/" target="_blank" class="text-dark">"PENERAPAN METODE WEIGHTED PRODUCT DALAM SISTEM PENDUKUNG KEPUTUSAN UNTUK PEMUTUSAN HUBUNGAN KERJA SALES DIRECT PT. TELKOMSEL AREA JEMBER"</a>, <a href="https://ejournal.bsi.ac.id/ejurnal/index.php/Bianglala/article/view/8806" target="_blank" class="text-dark">"Metode Weighted Product Pada Sistem Pendukung Keputusan Pemberian Bonus Pegawai Pada CV Bejo Perkasa"</a>, and some of Youtube video.</div>
    <hr>
    <p>
        <a href="<?= base_url('projects/saw') ?>" class="btn btn-primary btn-sm text-uppercase col-12"><i class="fa fa-plus"></i> create project</a>
    </p>
<?= $this->endSection() ?>