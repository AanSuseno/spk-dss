<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="<?= base_url('dss-ikon.svg') ?>" type="image/x-icon">
    <title>OnDSS - Online & Simple Decision Support System</title>
    <style>
        * {
            box-sizing: border-box;
        }

        .tron {
            transition: background-image 2s ease-in-out;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .tron::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            z-index: 1;
        }

        .tron>* {
            position: relative;
            z-index: 2;
        }

        .shadow-light {
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.25);
            animation: bounce2 2s ease infinite;
        }

        @keyframes bounce2 {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
                box-shadow: 0 10px 20px rgba(255, 255, 255, 0.25);
            }

            40% {
                transform: translateY(-20px);
                box-shadow: 0 30px 20px rgba(255, 255, 255, 0.15);
            }

            60% {
                transform: translateY(-10px);
                box-shadow: 0 20px 20px rgba(255, 255, 255, 0.2);
            }
        }

        .box-manfaat {
            border-radius: 10px;
            border: 1px solid;
            padding: 10px;
            /* width: 300px;
            max-width: 100%; */
            transition: 1s;
        }

        .box-manfaat:hover {
            color: #fff;
            background-color: #212529;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.55);
        }

        .list-dss {
            font-weight: bold;
        }

        .screenshot {
            width: 300px;
        }

        .box-screenshot {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .box-screenshot ::-webkit-scrollbar {
            display: none;
        }

        .tools {
            height: 30px;
        }
    </style>
</head>

<body class="light">
    <div class="wrapper tron">
        <div class="container text-light" style="padding-top: 100px; padding-bottom: 100px;">
            <h1 class="text-bold"><b><img src="<?= base_url('dss-ikon.svg') ?>" style="height: 2.5rem; position: relative; bottom: .5rem" alt="">nDSS</b></h1>
            <p>Online & Simple Decision Support System</p>
            <div class="d-flex justify-content-center mt-5" style="padding-top: 20%">
                <a href="<?= $authUri ?>" class="btn btn-primary rounded-pill shadow-light">
                    <i class="fa-brands fa-google"></i>
                    <b>LOGIN WITH GOOGLE</b>
                </a>
            </div>
        </div>
    </div>
    <div class="wrapper mt-5">
        <div class="container">
            <h1>
                <center>Welcome to <br>Online & Simple Decision Support System</center>
            </h1>
            <p class="text-center">Online & Simple Decision Support System website is a platform designed to assist users in making decisions using available data and algorithms. Its primary goal is to provide easy online accessibility, allowing users to access it from anywhere with an internet connection. The system is designed with simplicity as its main focus, enabling users from various backgrounds to easily understand and utilize its features. Through the use of available analysis tools, users can process relevant information and make better decisions. Despite aiding in decision-making, the system has limitations, and the final decision still relies on the user's judgment. It is also important to ensure the security of user data and provide adequate technical support for users of the system. Thus, an Online & Simple Decision Support System website is a valuable tool for individuals or organizations in the decision-making process.</p>
        </div>
    </div>
    <div class="wrapper">
        <div class="container pt-5">
            <h2>Here's what you can get from this website:</h2>
            <div class="d-flex justify-content-evenly flex-wrap" style="gap: 10px;">
                <div class="box-manfaat text-center col-lg-3 col-md-5 col-sm-12">
                    <center><b>Facilitates Decision Making</b></center>
                    <hr>
                    <p>The website simplifies the decision-making process by providing users with access to relevant data and analysis tools, enabling them to make more informed choices efficiently.</p>
                </div>
                <div class="box-manfaat text-center col-lg-3 col-md-5 col-sm-12">
                    <center><b>Enhances Accessibility</b></center>
                    <hr>
                    <p>Being online, the website can be accessed from anywhere with an internet connection, ensuring users can utilize its resources whenever and wherever they need to make decisions.</p>
                </div>
                <div class="box-manfaat text-center col-lg-3 col-md-5 col-sm-12">
                    <center><b>Promotes Efficiency</b></center>
                    <hr>
                    <p>With its user-friendly interface and straightforward design, the website streamlines the decision-making process, saving users time and effort in gathering and analyzing information.</p>
                </div>
                <div class="box-manfaat text-center col-lg-3 col-md-5 col-sm-12">
                    <center><b>Improves Decision Quality</b></center>
                    <hr>
                    <p>By leveraging available data and analysis tools, users can make decisions based on evidence and insights, leading to higher-quality outcomes and reducing the likelihood of errors or biases.</p>
                </div>
                <div class="box-manfaat text-center col-lg-3 col-md-5 col-sm-12">
                    <center><b>Empowers Users</b></center>
                    <hr>
                    <p>The website empowers users by providing them with the resources and support they need to make decisions autonomously, fostering confidence and independence in their decision-making abilities.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="container pt-5">
            <h2>Available Methods:</h2>
            <div class="d-flex justify-content-start" style="gap: 10px;">
                <div class="box-manfaat text-center list-dss" data-kepanjangan="Specific, Measurable, Achievable, Relevant, dan Time-bound">
                    SMART
                </div>
                <div class="box-manfaat text-center list-dss" data-kepanjangan="Technique for Order of Preference by Similarity to Ideal Solution">
                    TOPSIS
                </div>
                <div class="box-manfaat text-center list-dss" data-kepanjangan="Weighted Product">
                    WP
                </div>
                <div class="box-manfaat text-center list-dss" data-kepanjangan="Simple Additive Weighting">
                    SAW
                </div>
                <div class="box-manfaat text-center list-dss" data-kepanjangan="Analytical Hierarchy Process">
                    AHP
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="container py-5">
            <h2>Screenshoots:</h2>
            <div class="d-flex justify-content-start col-12 overflow-scroll box-screenshot" style="gap: 10px;">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062227.png') ?>" alt="" class="screenshot">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062603.png') ?>" alt="" class="screenshot">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062549.png') ?>" alt="" class="screenshot">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062442.png') ?>" alt="" class="screenshot">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062355.png') ?>" alt="" class="screenshot">
                <img src="<?= base_url('assets/images/Screenshot 2024-02-27 062242.png') ?>" alt="" class="screenshot">
            </div>
            <div class="d-flex justify-content-center mt-5">
                <a href="<?= $authUri ?>" class="btn btn-primary rounded-pill shadow-dark">
                    <i class="fa-brands fa-google"></i>
                    <b>LOGIN WITH GOOGLE</b>
                </a>
            </div>
        </div>
    </div>
    <div class="wrapper bg-dark text-light">
        <div class="container pt-5 pb-2">
            <div class="d-flex justify-content-center col-12" style="gap: 20px;">
                <img src="<?= base_url('assets/images/codeigniter (1).png') ?>" alt="" class="tools">
                <img src="<?= base_url('assets/images/adminlte.webp') ?>" alt="" class="tools">
            </div>
            <hr>
            <center>
                <a href="https://tele.me/aansuseno" class="text-light text-decoration-none">
                    <i class="fa-brands fa-telegram"></i> telegram
                </a> |
                <a href="https://aansuseno.showwcase.com/" class="text-light text-decoration-none">
                    <img src="<?= base_url('assets/images/showwcase.png') ?>" style="height: 1rem" alt=""> showwcase
                </a> |
                <a href="https://github.com/aansuseno" class="text-light text-decoration-none">
                    <i class="fa-brands fa-github"></i> github
                </a>
            </center>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const backgrounds = [
            'carlos-muza-hpjSkU2UYSU-unsplash.jpg',
            'adeolu-eletu-E7RLgUjjazc-unsplash.jpg',
            'bench-accounting-C3V88BOoRoM-unsplash.jpg',
            'ilya-pavlov-OqtafYT5kTw-unsplash.jpg',
            'stephen-dawson-qwtCeJ5cLYs-unsplash.jpg'
        ];

        const tron = document.querySelector('.tron');
        let currentIndex = 0;

        function changeBackground() {
            tron.style.backgroundImage = `url(<?= base_url('assets/images/') ?>${backgrounds[currentIndex]})`;
            currentIndex = (currentIndex + 1) % backgrounds.length;
        }

        $(document).ready(() => {
            changeBackground();
            setInterval(changeBackground, 5000)

            $('.list-dss').hover(() => {
                var text = $(this).text();
                console.log(text);
            })
        })
    </script>
</body>

</html>