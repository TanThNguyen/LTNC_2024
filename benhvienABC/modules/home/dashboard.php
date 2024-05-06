<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle'=>'Dash Board'
];
layouts('header_page',$data);

$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}
?>


<style>
        .home {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url(https://img.freepik.com/premium-photo/asian-male-doctor-examining-patient-clinic_296537-5175.jpg?w=1380) no-repeat;
        background-size: cover;
        background-attachment: fixed;
        }
        .home .lead {
        padding: 0px;
        font-weight: 300;
        width: 48%;
        color: var(--light-black);
        line-height: 2.8rem;
        margin-bottom: 3%;
        }

        .home .btn {
        margin: 0px 0.5rem;
        }

        .about .heading {
        padding-bottom: 12px;
        }
        .about .col-12 h3 {
        font-size: 3.5rem;
        color: var(--black);
        text-transform: uppercase;
        }
        .pictures {
        padding: 0%;
        }
        .about .contents {
        padding: 30px 30px;
        }

        .about .lead {
        font-weight: 300;
        }

        .heading {
        text-align: center;
        color: var(--main-color);
        text-transform: capitalize;
        margin-bottom: 4rem;
        margin-top: 2rem;
        font-size: 4rem;
        padding: 0px 0px;
        }

        .lead {
        font-size: 1.6rem;
        color: var(--light-black);
        padding: 2rem 0;
        line-height: 2;
        }
        .btn {
        color: var(--main-color);
        border: 0.1rem solid var(--main-color);
        border-radius: 0.5rem;
        margin-top: 1rem;
        font-size: 2.2rem;
        padding: 1rem 3rem;
        }

        .btn:hover {
        background-color: var(--main-color);
        color: var(--white);
        }

    </style>



<section class="home border" id="home">
      <div class="content">
        <h3 class="heading text-center ">Introducing 6 nguoi ngheo MedManage Pro</h3>

        <div class="lead mx-auto text-center">
          Revolutionize hospital management with our all-in-one app designed to streamline processes and enhance patient care. Discover the future of healthcare efficiency today.
        </div>
        <h1 class="text-center d-flex justify-content-center">
          <a class="btn" href="?module=users&action=index" role="button">Start Your Journey Now</a>
        </h1>
      </div>
    </section>



<?php
layouts('footer_page');
?>