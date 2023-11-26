<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
    <p>
    TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution) is a decision-making method used to select the best alternative from a set of options.
    The process involves identifying criteria, normalizing decision matrices, assigning weights to criteria, calculating positive and negative ideal solutions, computing the distances between alternatives and these solutions, and determining the relative proximity scores.
    The alternative with the highest proximity score is considered the most favorable. TOPSIS is suitable for multi-criteria decision-making contexts where decisions are based on the closeness of alternatives to ideal solutions.
    It's important to note that the choice of criteria weights and ideal solutions may introduce subjectivity into the decision-making process. (Defined by ChatGPT)
    </p>
    <div class="alert alert-light border-info text-dark">I am learning from <a href="https://youtu.be/ejv4KSuyFpg?si=qt0AIEVK47sscNiI" target="_blank" class="text-dark">here</a>.</div>
    <hr>
    <p>
        <a href="<?= base_url('projects/topsis') ?>" class="btn btn-primary btn-sm text-uppercase col-12"><i class="fa fa-plus"></i> create project</a>
    </p>
<?= $this->endSection() ?>