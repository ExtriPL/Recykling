function prepareDatapoints(objectArray) {
    datapoints = [];
    labels = [];
    for (const [key, value] of Object.entries(objectArray)) {
        // console.log(`${key}: ${value}`);
        datapoints = [...datapoints, {
            x: key,
            y: value
        }];
    }
    for (const [key, value] of Object.entries(objectArray)) {
        labels = [...labels, key];
    }
    window.chart.data.datasets[0].data = datapoints;
    window.chart.data.labels = labels;
    window.chart.update();
}

function prepareChart() {
    var ctx = document.getElementById('wgCzasu').getContext('2d');
    window.chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Pole zebranych odpadków',
                data: datapoints,
                backgroundColor: [
                    'rgba(97, 147, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(97, 147, 255, 1)'
                ],
                borderWidth: 1
            }],
            labels: labels
        }
    });
}