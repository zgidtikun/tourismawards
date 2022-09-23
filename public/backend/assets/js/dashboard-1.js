// (function($) {
//     "use strict";

//     let draw = Chart.controllers.line.prototype.draw;
//     Chart.controllers.line = Chart.controllers.line.extend({
//         draw: function() {
//             draw.apply(this, arguments);
//             let nk = this.chart.chart.ctx;
//             let _stroke = nk.stroke;
//             nk.stroke = function() {
//                 nk.save();
//                 nk.shadowColor = 'rgba(0, 0, 0, .1)';
//                 nk.shadowBlur = 30;
//                 nk.shadowOffsetX = 0;
//                 nk.shadowOffsetY = 5;
//                 _stroke.apply(this, arguments)
//                 nk.restore();
//             }
//         }
//     });

//     const nk = document.getElementById("activity_chart").getContext('2d');
//     const gradientStroke = nk.createLinearGradient(0, 200, 0, 0);
//     gradientStroke.addColorStop(0, "#36b9d8");
//     gradientStroke.addColorStop(1, "#4bffa2");

//     const gradientStroke2 = nk.createLinearGradient(200, 0, 100, 0);
//     gradientStroke2.addColorStop(0, "#4bffa2");
//     gradientStroke2.addColorStop(0.5, "rgba(54, 185, 216, 1)");
//     gradientStroke2.addColorStop(0.6, "rgba(54, 185, 216, 1)");
//     gradientStroke2.addColorStop(0.75, "rgba(54, 185, 216, 1)");
//     gradientStroke2.addColorStop(0.8, "rgba(54, 185, 216, 1)");
//     gradientStroke2.addColorStop(1, "#36b9d8");


//     new Chart(nk, {
//         type: 'line',
//         data: {
//             labels: ["07 Jan", "11 Jan", "15 Jan", "21 Jan", "25 Jan", "29 Jan"],
//             datasets: [{
//                 data: [250, 570, 300, 780, 500, 850],
//                 borderWidth: 6,
//                 borderColor: gradientStroke2,
//                 backgroundColor: gradientStroke,
//                 pointBackgroundColor: gradientStroke,
//                 pointBorderColor: '#fff',
//                 pointBorderWidth: 2,
//                 pointHoverBackgroundColor: gradientStroke,
//                 pointHoverBorderColor: gradientStroke,
//                 pointRadius: 5,
//                 pointHoverRadius: 6,
//                 borderWidth: 1,
//             }]
//         },
//         options: {
//             responsive: !0,
//             tooltips: {
//                 mode: 'index',
//                 titleFontSize: 12,
//                 titleFontColor: '#333',
//                 bodyFontColor: '#666',
//                 backgroundColor: '#fff',
//                 cornerRadius: 3,
//                 intersect: false,
//             },
//             maintainAspectRatio: false,
//             legend: {
//                 display: !1
//             },
//             scales: {
//                 xAxes: [{
//                     display: 1,
//                     gridLines: {
//                         display: 1
//                     }
//                 }],
//                 yAxes: [{
//                     display: 1,
//                     ticks: {
//                         padding: 10,
//                         stepSize: 250,
//                         max: 1000,
//                         min: 0
//                     },
//                     gridLines: {
//                         display: !0,
//                         drawBorder: !1,
//                         lineWidth: 1,
//                         zeroLineColor: "#e5e5e5"
//                     }
//                 }]
//             }
//         },
//     });

// })(jQuery);


// (function($) {
//     "use strict";
//     //doughut chart
//     const ctx = document.getElementById("task_dist_chart").getContext('2d');

//     const gradientStroke = ctx.createLinearGradient(0, 80, 80, 0);
//     // const gradientStroke = ctx.createRadialGradient(130, 0, 0, 130, 68, 130);
//     gradientStroke.addColorStop(0, "#f0a907");
//     gradientStroke.addColorStop(1, "#f53c79");

//     const gradientStroke2 = ctx.createLinearGradient(0, 80, 80, 0);
//     // const gradientStroke2 = ctx.createRadialGradient(130, 0, 0, 130, 68, 130);
//     gradientStroke2.addColorStop(0, "#4dedf5");
//     gradientStroke2.addColorStop(1, "#480ceb");

//     const gradientStroke3 = ctx.createLinearGradient(0, 80, 80, 0);
//     // const gradientStroke3 = ctx.createRadialGradient(130, 0, 0, 130, 68, 130);
//     gradientStroke3.addColorStop(0, "#51f5ae");
//     gradientStroke3.addColorStop(1, "#3fbcda");

//     const gradientStroke4 = ctx.createLinearGradient(0, 80, 80, 0);
//     // const gradientStroke4 = ctx.createRadialGradient(130, 0, 0, 130, 68, 130);
//     gradientStroke4.addColorStop(0, "#f25521");
//     gradientStroke4.addColorStop(1, "#f9c70a");

//     new Chart(ctx, {
//         type: 'doughnut',
//         data: {
//             datasets: [{
//                 data: [45, 25, 20, 10],
//                 backgroundColor: [
//                     gradientStroke,
//                     gradientStroke2,
//                     gradientStroke3,
//                     gradientStroke4
//                 ],
//                 hoverBackgroundColor: [
//                     gradientStroke,
//                     gradientStroke2,
//                     gradientStroke3,
//                     gradientStroke4
//                 ],
//                 borderWidth: 5

//             }],
//             labels: [
//                 "Front-End",
//                 "Design",
//                 "Back-End",
//                 "Testing"
//             ],
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             legend: false
//         }
//     });

// })(jQuery);