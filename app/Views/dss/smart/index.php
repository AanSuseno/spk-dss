<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
    <p>
    SMART stands for Specific, Measurable, Achievable, Relevant, and Time-bound. This framework is commonly employed in project management, personal development, and various other contexts to create clear and well-defined objectives. Let's break down what each letter in SMART represents:
        <ul>
            <li>
                Specific: Goals should be clear and specific, leaving no room for ambiguity. They answer the questions of who, what, where, when, and why.
            </li>
            <li>
                Measurable: Goals should include criteria that allow for quantifiable assessment of progress. It helps to track and measure outcomes, providing a clear indication of when the goal is met.
            </li>
            <li>
                Achievable: Goals should be realistic and attainable, considering the resources available. They should stretch you slightly but not be impossible to achieve.
            </li>
            <li>
                Relevant: Goals should be aligned with broader objectives and be relevant to your overall mission or purpose. They need to matter and contribute to the bigger picture.
            </li>
            <li>
                Time-bound: Goals should have a specific timeframe for completion. This creates a sense of urgency and helps in prioritizing efforts. (Defined by ChatGPT)
            </li>
        </ul>
    </p>
    <div class="alert alert-light border-info text-dark">
        I am learning from <a href="https://www.youtube.com/watch?v=tLPZI63S2-o" target="_blank" class="text-dark">here</a> and <a href="https://www.youtube.com/watch?v=po_aDO6OEkE" target="_blank" class="text-dark">here</a>.
        <p>
            Here for more article:
            <ol>
                <li><a class="text-dark" href="https://jurnal.untan.ac.id/index.php/jcskommipa/article/download/19510/16192">https://jurnal.untan.ac.id/index.php/jcskommipa/article/download/19510/16192</a></li>
                <li>
                    <a class="text-dark" href="https://ojs.unsiq.ac.id/index.php/ppkm/article/download/1055/577">https://ojs.unsiq.ac.id/index.php/ppkm/article/download/1055/577</a>
                </li>
                <li>
                    <a class="text-dark" href="http://www.knsi.stikom-bali.ac.id/index.php/eproceedings/article/download/82/78">http://www.knsi.stikom-bali.ac.id/index.php/eproceedings/article/download/82/78</a>
                </li>
            </ol>
        </p>
    </div>
    <hr>
    <p>
        <a href="<?= base_url('projects/smart') ?>" class="btn btn-primary btn-sm text-uppercase col-12"><i class="fa fa-plus"></i> create project</a>
    </p>
<?= $this->endSection() ?>