<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
    <p>
        AHP (Analytical Hierarchy Process) Decision Support System is a method for making complex decisions with multiple criteria.
        It was developed by Thomas L. Saaty in the 1970s and is used to assist in decision-making when there are several criteria to consider [by ChatGPT].
        Visit <a href="https://en.wikipedia.org/wiki/Analytic_hierarchy_process">wikipedia</a> for more information.
    </p>
    <div class="alert alert-light border-info text-dark">I am learning from <a href="https://youtu.be/dC4B-0rMPLA?si=3zjGAcbcXqfXkWjH" target="_blank" class="text-dark">here</a>.</div>
    <hr>
    <p>
        <a href="<?= base_url('projects/ahp') ?>" class="btn btn-primary btn-sm text-uppercase col-12"><i class="fa fa-plus"></i> create project</a>
    </p>
<?= $this->endSection() ?>