<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
    <p>
        ASimple Additive Weighting (SAW) is a decision-making method that uses an additive approach to determine the best alternative from a set of alternatives based on specified criteria.
        The basic concept of the SAW method is to find the weighted sum of the performance ratings for each alternative on all attributes.
        The SAW method requires a normalization process of the decision matrix (X) to a scale that can be compared with all existing alternative ratings. (Defined by Bard)
    </p>
    <div class="alert alert-light border-info text-dark">I am learning from <a href="https://repository.unikom.ac.id/54644/1/ii-10-ridho-taufiq-subagio-penerapan-metode-saw-simple-additive-weighting.pdf" target="_blank" class="text-dark">here</a>.</div>
    <hr>
    <p>
        <a href="<?= base_url('projects/saw') ?>" class="btn btn-primary btn-sm text-uppercase col-12"><i class="fa fa-plus"></i> create project</a>
    </p>
<?= $this->endSection() ?>