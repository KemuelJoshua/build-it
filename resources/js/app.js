import './bootstrap';

$(function() {
    AOS.init();
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 30,
          },
        },
      });
      

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });


    const myModal = new bootstrap.Modal('#estimationModal', {
        keyboard: false
    })

    $('#submit-estimate').on('submit', function() {
        const square_meter = $('#square_meter').val();
        const budget = $('#budget').val();

        estimate(square_meter, budget);

    });


    myModal.show();
});

function estimate(square_meter, budget) {
    $.ajax({
        url: '',
        method: 'POST',
        response: 'json',
        data: {
            'square_meter': square_meter,
            'budget': budget
        }, beforeSend() {
            // disable button
        }, success(response) {
            console.log(response)
        }   
    }).done({
        // enable button
    });

}