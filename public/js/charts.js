// Bar Chart
var types = Object.keys(averageDurations);
var averages = Object.values(averageDurations);
var ctx = document.getElementById("myBarChart").getContext('2d');
var myLineChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: types,
    datasets: [
      {
        label: "Average Duration",
        data: averages,
        backgroundColor: "rgba(2,117,216,1)",
        borderColor: "rgba(2,117,216,1)",
      },
    ],
  },
  options: {
    scales: {
      xAxes: [
        {
          title: {
            display: true,
            text: 'Vehicle Type'
        }
        },
      ],
      yAxes: [
        {
          beginAtZero: true,
                title: {
                    display: true,
                    text: 'Average Duration'
                }
        },
      ],
    },
    
  },
});

//
var labels = Object.keys(paymentMethodCounts);
var dataValues = Object.values(paymentMethodCounts);
// Pie Chart
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: "pie",
  data: {
    labels: labels,
    datasets: [
      {
        data: dataValues,
        backgroundColor: ["#28a745", "#007bff", "#ffc107"],
      },
    ],
  },
});

//
var months = Object.keys(monthlyTotals);
var amounts = Object.values(monthlyTotals);

var daysOfMonth = Object.keys(dailyTotalsForMonth);
var daysOfMonthAmounts = Object.values(dailyTotalsForMonth);

var daysOfWeek = Object.keys(dailyTotalsForWeek);
var daysOfWeekAmounts = Object.values(dailyTotalsForWeek);

var hours = Object.keys(hourlyTotals);
var hoursAmounts = Object.values(hourlyTotals);

const selectTime = document.getElementById('time-span');

// Area Chart
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [],
    datasets: [
      {
        label: "Total Amount",
        data: [],
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
      },
    ],
  },
  options: {
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: '',
        }
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true,
        },
        scaleLabel: {
          display: true,
          labelString: 'Total Amount'
        }
      }]
    },
    
  },
});

selectTime.addEventListener('change', function() {
  // Get the selected option's value
  const selectedValue = selectTime.value;

  // Compare the selected value and update the result element
  if (selectedValue === 'Year') {
    myLineChart.data.labels = months;
    myLineChart.data.datasets[0].data = amounts;
    
  } else if (selectedValue === 'Week') {
    myLineChart.data.labels = daysOfWeek;
    myLineChart.data.datasets[0].data = daysOfWeekAmounts;
    
  } else if (selectedValue === 'Day') {
    myLineChart.data.labels = hours;
    myLineChart.data.datasets[0].data = hoursAmounts;
    
  } else if (selectedValue === 'Month') {
    myLineChart.data.labels = daysOfMonth;
    myLineChart.data.datasets[0].data = daysOfMonthAmounts;
    
  } else {
    myLineChart.data.labels = [];
    myLineChart.data.datasets[0].data = [];
  }
  myLineChart.options.scales.xAxes[0].scaleLabel.labelString = selectedValue;
  myLineChart.update();
});
