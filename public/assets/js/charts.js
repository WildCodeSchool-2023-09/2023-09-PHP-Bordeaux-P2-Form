function chartForm(idDiv, type, label, dataPoints) {
    window.onload = function () {
        var chart = new CanvasJS.Chart(idDiv, {
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: label,
            },
            data: [
                {
                    type: type,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    indexLabel: "{label} - #percent%",
                    yValueFormatString: "#,##0",
                    dataPoints: dataPoints,
                },
            ],
        });
        chart.render();
    };
}
