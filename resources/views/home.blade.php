@extends('layouts.app')

@section('content')

    <div class="home">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="banner">
                        <h1>Construction and Cost Estimator</h1>
                        <p>Get a detailed cost breakdown tailored to your budget and let us simplify your construction planning!</p>
                        <button class="btn-start">Estimate Now <i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body pt-5 pb-3">
                                    <div class="icon">
                                        <img src="{{asset('img/1.png')}}" alt="" srcset="">
                                    </div>
                                    <div class="description">
                                        <h5>User-Friendly Interface</h5>
                                        <p>The system provides an intuitive and easy-to-use interface that allows users to input the necessary information and view the results.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body pt-5 pb-3">
                                    <div class="icon">
                                        <img src="{{asset('img/2.png')}}" alt="" srcset="">
                                    </div>
                                    <div class="description">
                                        <h5>Budget Breakdown</h5>
                                    <p>The system breaks down the estimated budget into different categories, such as materials, labor, equipment, and overhead costs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body pt-5 pb-3">
                                    <div class="icon">
                                        <img src="{{asset('img/3.png')}}" alt="" srcset="">
                                    </div>
                                    <div class="description">
                                        <h5>Expenses Estimation</h5>
                                        <p>The system estimates the overall budget for the construction project based on the user's input of square meters, budget, and construction date.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body pt-5 pb-3">
                                    <div class="icon">
                                        <img src="{{asset('img/4.png')}}" alt="" srcset="">
                                    </div>
                                    <div class="description">
                                        <h5>Cost Forecasting</h5>
                                        <p>The system uses ARIMA forecasting to predict potential cost increases in the future, allowing users to plan accordingly.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body pt-5 pb-3">
                                    <div class="icon">
                                        <img src="{{asset('img/5.png')}}" alt="" srcset="">
                                    </div>
                                    <div class="description">
                                        <h5>Historical Data Analysis</h5>
                                        <p>The system can analyze historical data to identify trends and patterns that can be used to improve cost estimation accuracy.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-us py-5">
        <div class="container">
            <div class="banner">
                <h2>About Us</h2>
                <h1>Meet the team</h1>
                <p>
                    buildIT is a practical and reliable tool for estimating construction costs and material requirements. Designed to assist both homeowners and contractors, it helps users quickly calculate material quantities, labor costs, and total project expenses based on specific project details and requirements. With its straightforward and user-friendly interface, buildIT allows users to customize inputs such as project size, material types, and labor rates, making budgeting easier and more precise. Whether planning a small renovation or a large construction project, buildIT provides the insights needed to manage costs effectively and keep projects within budget.
                </p>
            </div>
            <div class="swiper mySwiper mt-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="card-header">
                                <div class="profile">
                                    <div class="avatar">
                                        <img src="{{asset('img/krystein.jpg')}}" alt="" srcset="">
                                    </div>
                                    <div class="content">
                                        <h3>Krystein Cabrera</h3>
                                        <small>Project Manager | UI/UX Designer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    Making this website captivating and user-friendly is my priority. I ensure each project is completed on time, with the highest quality standards, blending creativity with strategy. Through teamwork and open communication, I strive to turn projects into exceptional digital experiences.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="card-header">
                                <div class="profile">
                                    <div class="avatar">
                                        <img src="{{asset('img/josh.jpg')}}" alt="" srcset="">
                                    </div>
                                    <div class="content">
                                        <h3>Josh Daniel Velasco</h3>
                                        <small>Full-Stack Developer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    Known for my strong work ethic and leadership, I focus on detail in coding and UI design. With expertise in full-stack development, I create seamless digital experiences, inspiring others and fostering collaboration in every project.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="card-header">
                                <div class="profile">
                                    <div class="avatar">
                                        <img src="{{asset('img/carline.jpg')}}" alt="" srcset="">
                                    </div>
                                    <div class="content">
                                        <h3>Carline Deyn Sta.Isabel</h3>
                                        <small>Full-Stack Developer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    As a respected full-stack developer, I manage complex projects with technical skill and creativity, crafting user-friendly applications. My communication and problem-solving skills make me a valuable team asset.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <div class="card-header">
                                <div class="profile">
                                    <div class="avatar">
                                        <img src="{{asset('img/rain.jpg')}}" alt="" srcset="">
                                    </div>
                                    <div class="content">
                                        <h3>Rainiel Ferrer</h3>
                                        <small>UI/UX designer | Quality assurance</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    As a dedicated QA specialist, I ensure flawless functionality and seamless user experiences. Proactive and collaborative, I bridge the gap between design and function, bringing a passion for quality that makes me a valuable team asset.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <div class="footer py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 cool-md-6">
                    <div class="text-center">
                        <h1>Contact Us</h1>
                        <p>Our friendly customer support team is ready to assist you with any questions.</p>
                    </div>
                    <div class="ul list-unstyled">
                        <li class="list-unstyled-item">
                            Pag-asa street, pasig, 1606, Metro Manila
                        </li>
                        <li class="list-unstyled-item">
                            Buildit.info
                        </li>
                        <li class="list-unstyled-item">
                            (123) 456-78990
                        </li>
                        <li class="list-unstyled-item">
                            www.sample.com
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
