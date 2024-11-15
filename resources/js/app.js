import axios from 'axios';
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

    $('#estimate-btn').on('click', function() {
        var budget = $('#budget').val(); 
        var sqm = $('#square_meter').val(); 
    
        var $button = $(this);
        $button.prop('disabled', true).text('Loading...');

        axios.get('/forecast', {
            params: {
                budget: budget,
                sqm: sqm
            }
        })
        .then(function (response) {
            var labels = response.data.years;
            var values = response.data.forecast;
    
            var ctx = document.getElementById('myChart').getContext('2d');
    
            if (window.myChart instanceof Chart) {
                window.myChart.destroy();
            }
    
            window.myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Forecasted Lot Size in the Future',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
    
            estimateCost();
        })
        .catch(function (error) {
            console.error('Error fetching data:', error);
    
            Swal.fire({
                title: 'Error!',
                text: error.response ? error.response.data.message || 'An error occurred while fetching the data.' : 'Network or server error.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }).finally(function() {
            $button.prop('disabled', false).text('Estimate Project Cost');
        });
    });
    
    $('#contactForm').on('click', function (event) {
        event.preventDefault();

        var $form = $(this);
        var $button = $form.find('button[type="submit"]');
        $button.prop('disabled', true).text('Loading...');

        $('.text-danger').text('').hide();

        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            message: $('#message').val()
        };

        axios.post('/message', formData)
            .then(function (response) {
                $('#contactForm')[0].reset(); 
                Swal.fire({
                    title: 'Success!',
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            })
            .catch(function (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    if (errors.name) {
                        $('#name-error').text(errors.name[0]).show();
                    }
                    if (errors.email) {
                        $('#email-error').text(errors.email[0]).show();
                    }
                    if (errors.message) {
                        $('#message-error').text(errors.message[0]).show();
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: error.response ? error.response.data.message || 'An error occurred while fetching the data.' : 'Network or server error.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            }).finally(function() {
                $button.prop('disabled', false).text('Submit');
            });
    });
    
});

const myModal = new bootstrap.Modal('#estimationModal', {
    keyboard: false
})

function estimateCost() {
    const squareMeter = parseFloat($("#square_meter").val());
    const budget = parseFloat($("#budget").val());
    const resultElement = $("#result");

    let minBudget, maxBudget;
    if (isNaN(squareMeter) || squareMeter < 50) {
        Swal.fire({
            title: 'Error!',
            text: 'Please enter a valid square meter value (minimum 50)',
            icon: 'error',
            confirmButtonText: 'Ok!'
        });
        return;
    }
    if (isNaN(budget)) {
        Swal.fire({
            title: 'Error!',
            text: 'Please enter a valid budget value.',
            icon: 'error',
            confirmButtonText: 'Ok!'
        });
        return;
    }
    if (squareMeter >= 50 && squareMeter <= 99) {
        minBudget = 2500000;
        maxBudget = 3500000;
    } else if (squareMeter >= 100 && squareMeter <= 149) {
        minBudget = 4000000;
        maxBudget = 5000000;
    } else if (squareMeter >= 150 && squareMeter <= 199) {
        minBudget = 6000000;
        maxBudget = 7000000;
    } else if (squareMeter >= 200 && squareMeter <= 300) {
        minBudget = 8000000;
        maxBudget = 10000000;
    } else {
        Swal.fire({
            title: 'Error!',
            text: "Please enter a valid square meter value (minimum 50) and (maximum 300)",
            icon: 'error',
            confirmButtonText: 'Ok!'
        });
        return;
    }
    
    if (budget < minBudget) {
        Swal.fire({
            title: 'Info!',
            text: "Budget is not enough for this square meter. The minimum budget required is " + minBudget + ".",
            icon: 'info',
            confirmButtonText: 'Ok!'
        });
        return;
    } else if (budget > maxBudget) {
        Swal.fire({
            title: 'Info!',
            text: "Your budget exceeds the maximum budget for this square meter range. The maximum budget is " + maxBudget + ".",
            icon: 'info',
            confirmButtonText: 'Ok!'
        });
        return;
    }
    

    // Percentages for budget breakdown
    const laborPercent = 0.45;
    const materialsPercent = 0.45;
    const contingencyPercent = 0.07;
    const equipmentPercent = 0.03;

    // Budget allocations
    const laborBudget = budget * laborPercent;
    const materialsBudget = budget * materialsPercent;
    const contingencyBudget = budget * contingencyPercent;
    const equipmentBudget = budget * equipmentPercent;

    // Wage rates
    const wageRates = {
        foreman: 900,
        carpenter: 750,
        mason: 750,
        welder: 750,
        painter: 750,
        electrician: 750,
        helper: 645
    };

    // Constraints for number of workers
    const workerConstraints = {
        foreman: { max: 1, min: 1 },
        carpenter: { max: 6, min: 3 },
        mason: { max: 6, min: 3 },
        welder: { max: 2, min: 1 },
        painter: { max: 2, min: 1 },
        electrician: { max: 2, min: 1 },
        helper: { max: 10, min: 5 }
    };

    // Adjust number of workers based on budget and square footage
    const workers = {
        foreman: Math.min(workerConstraints.foreman.max, Math.max(workerConstraints.foreman.min, Math.floor(budget / 500000))),
        carpenter: Math.min(workerConstraints.carpenter.max, Math.max(workerConstraints.carpenter.min, Math.floor(squareMeter / 1000))),
        mason: Math.min(workerConstraints.mason.max, Math.max(workerConstraints.mason.min, Math.floor(squareMeter / 1000))),
        welder: Math.min(workerConstraints.welder.max, workerConstraints.welder.min),
        painter: Math.min(workerConstraints.painter.max, workerConstraints.painter.min),
        electrician: Math.min(workerConstraints.electrician.max, workerConstraints.electrician.min),
        helper: Math.min(workerConstraints.helper.max, Math.max(workerConstraints.helper.min, Math.floor(budget / 300000)))
    };

    // Total labor cost per day
    const dailyLaborCost = (workers.foreman * wageRates.foreman) +
        (workers.carpenter * wageRates.carpenter) +
        (workers.mason * wageRates.mason) +
        (workers.welder * wageRates.welder) +
        (workers.painter * wageRates.painter) +
        (workers.electrician * wageRates.electrician) +
        (workers.helper * wageRates.helper);

    // Calculate number of days the labor budget will cover
    const workingDays = Math.floor(laborBudget / dailyLaborCost);
    // Assuming an average month has 30 days (adjust if needed)
    const averageMonthLength = 30;

    // Calculate estimated months (rounded)
    const estimatedMonths = Math.round(workingDays / averageMonthLength);

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Display the breakdown (improved formatting and clarity)
    resultElement.html(`
        <div class="container">
            <h2>Here is the overall cost breakdown and estimation</h2>
    
            <!-- First Table: Cost Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td align="left">Prepared square meter</td>
                        <td colspan="3" align="left">${squareMeter} sq m.</td>
                    </tr>
                    <tr>
                        <td align="left">Your budget</td>
                        <td colspan="3" align="left">₱ ${formatNumberWithCommas(budget)}</td>
                    </tr>
                    <tr>
                        <td align="left">Budget range for ${squareMeter} square meters</td>
                        <td colspan="3" align="left">₱ ${formatNumberWithCommas(minBudget)} - ₱ ${formatNumberWithCommas(maxBudget)}</td>
                    </tr>
                    <tr>
                        <td align="left">Estimated working days</td>
                        <td>${workingDays} days (approximately ${estimatedMonths} months based on an average month of ${averageMonthLength} days)</td>
                    </tr>
                </table>
            </div>
    
            <!-- Second Table: Budget Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="3" align="center"><strong>Budget Breakdown</strong></td>
                        </tr>
                        <tr>
                            <th>Breakdown</th>
                            <th>Percentage</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Labor</td>
                            <td align="center">45%</td>
                            <td align="center">₱ ${formatNumberWithCommas(laborBudget.toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Materials</td>
                            <td align="center">45%</td>
                            <td align="center">₱ ${formatNumberWithCommas(materialsBudget.toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Contingency</td>
                            <td align="center">7%</td>
                            <td align="center">₱ ${formatNumberWithCommas(contingencyBudget.toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Equipment</td>
                            <td align="center">3%</td>
                            <td align="center">₱ ${formatNumberWithCommas(equipmentBudget.toFixed(2))}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Third Table: Labor Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="4" align="center"><strong>Labor (45%)</strong></td>
                        </tr>
                        <tr>
                            <th align="center">Workers</th>
                            <th align="center">No. of workers</th>
                            <th align="center">Salary per day</th>
                            <th align="center">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Foreman</td>
                            <td align="center">${workers.foreman}</td>
                            <td align="center">₱ ${wageRates.foreman}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.foreman * wageRates.foreman).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Carpenter</td>
                            <td align="center">${workers.carpenter}</td>
                            <td align="center">₱ ${wageRates.carpenter}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.carpenter * wageRates.carpenter).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Mason</td>
                            <td align="center">${workers.mason}</td>
                            <td align="center">₱ ${wageRates.mason}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.mason * wageRates.mason).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Welder</td>
                            <td align="center">${workers.welder}</td>
                            <td align="center">₱ ${wageRates.welder}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.welder * wageRates.welder).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Painter</td>
                            <td align="center">${workers.painter}</td>
                            <td align="center">₱ ${wageRates.painter}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.painter * wageRates.painter).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Electrician</td>
                            <td align="center">${workers.electrician}</td>
                            <td align="center">₱ ${wageRates.electrician}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.electrician * wageRates.electrician).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td align="center">Helper</td>
                            <td align="center">${workers.helper}</td>
                            <td align="center">₱ ${wageRates.helper}</td>
                            <td align="center">₱ ${formatNumberWithCommas((workers.helper * wageRates.helper).toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><strong>Total Daily Labor</strong></td>
                            <td align="center">₱ ${formatNumberWithCommas(dailyLaborCost.toFixed(2))}</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><strong>Total Labor Cost</strong></td>
                            <td align="center">₱ ${formatNumberWithCommas(laborBudget.toFixed(2))}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Fourth Table: Materials Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="3" align="center"><strong>Materials (45%)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td align="center">Cement</td></tr>
                        <tr><td align="center">Rebar (Carbon, Stainless Steel, Galvanized, Glass Fiber)</td></tr>
                        <tr><td align="center">Hollow blocks (Pillar, Lintel, Jamb, Stretcher, Bull Nose, Concrete)</td></tr>
                        <tr><td align="center">Tiles and Adhesive</td></tr>
                        <tr><td align="center">Roping Materials including C - Purlins</td></tr>
                        <tr><td align="center">Angle bars for traces</td></tr>
                        <tr><td align="center">Painting materials</td></tr>
                        <tr><td align="center">Electrical Materials</td></tr>
                        <tr><td align="center">Plywood and Lumber</td></tr>
                        <tr><td align="center">Nails, doorjambs, softwoods, fasteners</td></tr>
                        <tr><td align="center">Panel doors (Oak, Walnut, Glazed, Shaker)</td></tr>
                        <tr>
                            <td align="center"><strong>Total Material Cost: ₱ ${formatNumberWithCommas(materialsBudget.toFixed(2))}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Fifth Table: Contingency Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="2" align="center"><strong>Contingency (7%)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Note: It is strongly recommended that a contingency fund of 7% of the total project budget be allocated for the construction of your new home. This reserve will serve as a financial safety net to mitigate the potential impact of unforeseen circumstances, such as fluctuations in material costs or unexpected labor challenges.</td>
                        </tr>
                        <tr>
                            <td align="center"><strong>Total Contingency Cost: ₱ ${formatNumberWithCommas(contingencyBudget.toFixed(2))}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Sixth Table: Equipment Breakdown -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="2" align="center"><strong>Equipment (3%)</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">Note: Equipment costs typically cover the rental of construction machinery, tools, scaffolding, and other specialized equipment required for the project.</td>
                        </tr>
                        <tr>
                            <td align="center"><strong>Total Equipment Cost: ₱ ${formatNumberWithCommas(equipmentBudget.toFixed(2))}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `);
    
    myModal.show();

}

