// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Sample data for 9 pie charts
const chartData = [
    {
        id: 'pieChart1',
        labels: ["Direct", "Referral", "Social"],
        data: [55, 30, 15],
        colors: ['#4e73df', '#1cc88a', '#36b9cc']
    },
    {
        id: 'pieChart2',
        labels: ["Sales", "Marketing", "Operations"],
        data: [40, 35, 25],
        colors: ['#ff6384', '#36a2eb', '#ffce56']
    },
    {
        id: 'pieChart3',
        labels: ["Product A", "Product B", "Product C"],
        data: [45, 25, 30],
        colors: ['#ff9f40', '#4bc0c0', '#9966ff']
    },
    {
        id: 'pieChart4',
        labels: ["North", "South", "East", "West"],
        data: [25, 25, 25, 25],
        colors: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0']
    },
    {
        id: 'pieChart5',
        labels: ["Online", "Offline", "Hybrid"],
        data: [60, 30, 10],
        colors: ['#ff9f40', '#4bc0c0', '#9966ff']
    },
    {
        id: 'pieChart6',
        labels: ["Youth", "Adult", "Senior"],
        data: [20, 50, 30],
        colors: ['#4e73df', '#1cc88a', '#36b9cc']
    },
    {
        id: 'pieChart7',
        labels: ["Segment A", "Segment B", "Segment C"],
        data: [35, 35, 30],
        colors: ['#ff6384', '#36a2eb', '#ffce56']
    },
    {
        id: 'pieChart8',
        labels: ["Channel 1", "Channel 2", "Channel 3"],
        data: [40, 30, 30],
        colors: ['#ff9f40', '#4bc0c0', '#9966ff']
    },
    {
        id: 'pieChart9',
        labels: ["Region 1", "Region 2", "Region 3", "Region 4"],
        data: [25, 25, 25, 25],
        colors: ['#4e73df', '#1cc88a', '#36b9cc', '#ff6384']
    }
];

// Function to create pie charts
function createPieCharts() {
    chartData.forEach(chart => {
        var ctx = document.getElementById(chart.id);
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chart.labels,
                datasets: [{
                    data: chart.data,
                    backgroundColor: chart.colors,
                    hoverBackgroundColor: chart.colors.map(color => 
                        Chart.helpers.color(color).lighten(0.1).rgbString()
                    ),
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    });
}

// Call the function to create charts when the document is ready
document.addEventListener('DOMContentLoaded', createPieCharts);