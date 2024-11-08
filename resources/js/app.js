import axios from 'axios';
import './bootstrap';

$(function() {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });


    $('#submit-estimate').on('submit', function() {
        const square_meter = $('#square_meter').val();
        const budget = $('#budget').val();

        estimate(square_meter, budget);

    });

    $('#estimate-btn').on('click', function() {
        // Get the budget and sqm values (assuming they're from input fields with IDs 'budget' and 'sqm')
        var budget = $('#budget').val(); // Adjust the selector if needed
        var sqm = $('#square_meter').val(); // Adjust the selector if needed
    
        // Send the data to the server using axios GET request with query parameters
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
    
            // Check if a chart already exists and destroy it if necessary
            if (window.myChart instanceof Chart) {
                window.myChart.destroy();  // Destroy the existing chart before creating a new one
            }
    
            // Create a new chart
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
            // Handle error and show SweetAlert with error details
            console.error('Error fetching data:', error);
    
            Swal.fire({
                title: 'Error!',
                text: error.response ? error.response.data.message || 'An error occurred while fetching the data.' : 'Network or server error.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
    });
    
    
});

const myModal = new bootstrap.Modal('#estimationModal', {
    keyboard: false
})

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

function estimateCost() {
    const squareMeter = parseFloat($("#square_meter").val());
    const budget = parseFloat($("#budget").val());
    const resultElement = $("#result");

    console.log('working');

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
            title: 'Error!',
            text: "Budget is not enough for this square meter. The minimum budget required is " + minBudget + ".",
            icon: 'error',
            confirmButtonText: 'Ok!'
        });
        return;
    } else if (budget > maxBudget) {
        Swal.fire({
            title: 'Error!',
            text: "Your budget exceeds the maximum budget for this square meter range. The maximum budget is " + maxBudget + ".",
            icon: 'error',
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
        <table style="border: solid 4px black; text-align: center; width:100% important;">
            <h2>Here is the overall cost breakdown and estimation</h2>
            <table border="1">
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Prepared square meter</td>
                    <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp;${squareMeter} sq m.</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Your budget</td>
                    <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp;₱ ${formatNumberWithCommas(budget)}</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Budget range for ${squareMeter} square meters</td>
                    <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp;₱ ${formatNumberWithCommas(minBudget)} - ₱ ${formatNumberWithCommas(maxBudget)}</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Estimated working days</td>
                    <td>${workingDays} days (approximately ${estimatedMonths} months based on an average month of ${averageMonthLength} days)</td>
                </tr>
            </table>
            <br><br>
            <table border="1">
                <tr>
                    <td colspan="3" align="center"><strong>Budget Breakdown</strong></td>
                </tr>
                <tr>
                    <th>Breakdown</th>
                    <th>Percentage</th>
                    <th>Amount</th>
                </tr>
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
            </table>
            <br><br>
            <table border="1">
                <tr>
                    <td colspan="4" align="center"><strong>Labor(45%)</strong></td>
                </tr>
                <tr>
                    <th align="center">Workers</th>
                    <th align="center">No. of workers</th>
                    <th align="center">Salary per day</th>
                    <th align="center">Total Cost</th>
                </tr>
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
                        <td colspan="3" align="right"><strong>Total Daily Labor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                        <td align="center">₱ ${formatNumberWithCommas(dailyLaborCost.toFixed(2))}</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Total Labor Cost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                        <td align="center">₱ ${formatNumberWithCommas(laborBudget.toFixed(2))}</td>
                    </tr>
            </table>

                    <table border="1">
            <tr>
                <td align="center"><strong>Materials (45%)</td></strong>
            </tr>
            <tr>
                <td align="center">Materials</td>
            </tr>
            <tr>
                <td align="center">Cement</td>
            </tr>
            <tr>
                <td align="center">Rebars</td>
            </tr>
            <tr>
                <td align="center">Hollow blocks</td>
            </tr>
            <tr>
                <td align="center">Tiles and Adhesive</td>
            </tr>
            <tr>
                <td align="center">Roping Materials Including C-Purlins</td>
            </tr>
            <tr>
                <td align="center">Angle bars for traces</td>
            </tr>
            <tr>
                <td align="center">Painting materials</td>
            </tr>
            <tr>
                <td align="center">Electrical Materials</td>
            </tr>
            <tr>
                <td align="center">Plywood & Lambers (nails, doorjambs, etc.)</td>
            </tr>
            <tr>
                <td align="center">Panel doors</td>
            </tr>
            <tr>
                <td align="center"><strong>Total Material Cost: ₱ ${formatNumberWithCommas(materialsBudget.toFixed(2))}</strong></td>
            </tr>
        </table>

        <br><br>
        <table border="1">
            <tr>
                <td colspan="2" align="center"><Strong>Contingency (7%)</td></Strong>
            </tr>
            <tr>
                <td align="center">Note: It is strongly recommended that a contingency fund of 7% of the total project budget be allocated for the construction of your new home. This reserve will serve as a financial safety net to mitigate the potential impact of unforeseen circumstances, such as fluctuations in material costs or unexpected labor challenges. By incorporating this contingency, you can enhance the overall stability and success of your building project.</td>

            </tr>
            <tr>
                <td align="center"><strong>Total Contingency Cost: ₱ ${formatNumberWithCommas(contingencyBudget.toFixed(2))}</td></strong>
            </tr>
        </table>
        <br><br>
        <table border="1">
            <tr>
                <td colspan="2" align="center"><Strong>Equipment (3%)</td></Strong>
            </tr>
            <tr>
                <td align="center">Note: Allocating 3% of your budget for equipment is crucial to ensure sufficient funds for purchasing or renting construction equipment like excavators, backhoes, and bulldozers.</td>

            </tr>
            <tr>
                <td align="center"><strong>Total Equipment Cost: ₱ ${formatNumberWithCommas(equipmentBudget.toFixed(2))}</td></strong>
            </tr>
        </table>
        </table>
        <br>
        </table>
    `);
    myModal.show();

}

      