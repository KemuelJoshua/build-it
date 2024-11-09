@extends('layouts.app')

@section('content')

    <div class="home">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner" data-aos="fade-up">
                        <h1>Construction Cost Estimation</h1>
                        <p>Get a detailed cost breakdown tailored to your budget and let us simplify your construction planning!</p>
                        @if(Auth::check())
                            <a href="#estimation" class="btn-start">Estimate Now <i class="fa-solid fa-arrow-right-long"></i></a>
                        @else
                            <a href="{{ route('login') }}" class="btn-start">Estimate Now <i class="fa-solid fa-arrow-right-long"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="features py-5" id="features">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-12 col-xl-10">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-4 mb-4" data-aos="fade-up">
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
                        <div class="col-12 col-md-4 mb-4" data-aos="fade-up">
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
                        <div class="col-12 col-md-4 mb-4" data-aos="fade-up">
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
                        <div class="col-12 col-md-4 mb-4" data-aos="fade-up">
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
                        <div class="col-12 col-md-4 mb-4" data-aos="fade-up">
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

    @if(Auth::check())
        <div class="estimate py-5" id="estimation">
            <div class="container">
                <div class="text-center text-uppercase pb-3">
                    <h2 class="fw-bold">Construction Cost Estimation</h2>
                </div>
                <div class="row d-flex justify-content-center mt-3" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        <div class="card shadow round-lg">
                            <div class="card-body p-5">
                            <form id="submit-estimate">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-4">
                                        <label style="font-size: 12px" class="text-uppercase fw-bold mb-2" for="square">Enter Square Meter: </label>
                                        <input type="text" name="square_meter" id="square_meter" class="form-control py-2" placeholder="Enter square meter">
                                        @error('square_meter')
                                            <small class="text-danger mb-0 text-uppercase fw-bold" style="font-size: 11px;">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label style="font-size: 12px" class="text-uppercase fw-bold mb-2" for="budget">Enter Budget (in Peso):</label>
                                        <input type="text" name="budget" id="budget" class="form-control py-2" placeholder="Enter budget">
                                        @error('budget')
                                            <small class="text-danger mb-0 text-uppercase fw-bold" style="font-size: 11px;">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <button type="button" id="estimate-btn" class="btn btn-primary px-4 py-3 text-uppercase fw-bold float-end">Estimate Project Cost</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="about-us py-5" id="about">
        <div class="container">
            <div class="banner" data-aos="fade-up">
                <h2>About Us</h2>
                <h1 class="mt-3">Meet the team</h1>
                <p>
                    buildIT is a practical and reliable tool for estimating construction costs and material requirements. Designed to assist both homeowners and contractors, it helps users quickly calculate material quantities, labor costs, and total project expenses based on specific project details and requirements. With its straightforward and user-friendly interface, buildIT allows users to customize inputs such as project size, material types, and labor rates, making budgeting easier and more precise. Whether planning a small renovation or a large construction project, buildIT provides the insights needed to manage costs effectively and keep projects within budget.
                </p>
            </div>
            <div class="swiper mySwiper mt-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" data-aos="fade-up">
                        <div class="card">
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
                    <div class="swiper-slide" data-aos="fade-up">
                        <div class="card">
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
                    <div class="swiper-slide" data-aos="fade-up">
                        <div class="card">
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
                    <div class="swiper-slide" data-aos="fade-up">
                        <div class="card">
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

    <div class="footer py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="text-start" data-aos="fade-up">
                        <h1>Contact Us</h1>
                        <p>Our friendly customer support team is ready to assist you with any questions.</p>
                    </div>
                    <div class="my-3">
                        <hr>
                    </div>
                    <div class="ul list-unstyled" data-aos="fade-up">
                        <li class="list-unstyled-item">
                            Pag-asa street, pasig, 1606, Metro Manila
                        </li>
                        <li class="list-unstyled-item">
                            <a href="https://build-it.services" class="nav-link">Build IT</a>
                        </li>
                        <li class="list-unstyled-item">
                            (123) 456-78990
                        </li>
                        <li class="list-unstyled-item">
                            www.sample.com
                        </li>
                    </div>
                </div>
                <div class="col-12 col-md-6" data-aos="fade-up">
                    <form id="contactForm">
                        <div class="group mb-3">
                            <input type="text" name="name" id="name" placeholder="Your Name" class="form-control py-3">
                            <span id="name-error" class="text-danger text-uppercase mt-1" style="font-size: 11px; display: none;"></span>
                        </div>
                        <div class="group mb-3">
                            <input type="email" name="email" id="email" placeholder="Your Email" class="form-control py-3">
                            <span id="email-error" class="text-danger text-uppercase mt-1" style="font-size: 11px; display: none;"></span>
                        </div>
                        <div class="group mb-3">
                            <textarea name="message" id="message" rows="5" placeholder="Your Message" class="form-control py-3"></textarea>
                            <span id="message-error" class="text-danger text-uppercase mt-1" style="font-size: 11px; display: none;"></span>
                        </div>
                        <button type="submit" class="btn btn-secondary float-end px-5 py-3 text-white text-uppercase fw-bold">Submit</button>
                    </form>                                       
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="estimationModal" tabindex="-1" aria-labelledby="estimationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="estimationModalLabel">Construction Cost Estimation</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <canvas id="myChart" width="400" height="200"></canvas>
                    <div class="result" id="result">
                </div>
            </div>
          </div>
        </div>
    </div>

@endsection
