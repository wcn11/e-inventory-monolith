let time_Array = ["2018-12-07 15:45:17", "2018-12-07 15:30:17", "2018-12-07 15:15:16", "2018-12-07 15:00:17", "2018-12-07 14:45:16", "2018-12-07 14:30:17", "2018-12-07 14:15:17", "2018-12-07 14:00:17", "2018-12-07 13:45:17", "2018-12-07 13:30:16", "2018-12-07 13:15:17", "2018-12-07 16:00:17"];
let meas_value_Array = [200, 230, 191, 111, 130, 111, 91, 0, 88, 77, 230, 111];

export const planetChartData = {
    type: "line",
    data: {
        labels: time_Array,
        datasets: [
            {
                label: "Stock Keluar",
                data: meas_value_Array,
                backgroundColor: "rgba(71, 183,132,.5)",
                borderColor: "#47b784",
                borderWidth: 3
            }
        ]
    },
    options: {
        responsive: true,
        lineTension: 1,
        scales: {
            xAxes: [
                {
                    ticks: {
                        type: 'time',
                        source: 'data'
                    },
                    time: {
                        parser: 'YYYY-MM-DD HH:mm:ss',
                        unit: 'minute',
                        displayFormats: {
                            'minute': 'YYYY-MM-DD HH:mm:ss',
                            'hour': 'YYYY-MM-DD HH:mm:ss'
                        }
                    },
                }
            ],
            yAxes: [
                {
                    ticks: {
                        beginAtZero: true,
                        padding: 25
                    }
                }
            ]
        }
    }
};

export default planetChartData;
