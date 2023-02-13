<style>
  /* .apexcharts-legend-series {
    cursor: pointer;
    line-height: normal;
    margin: 0px 5px !important;
  } */

  /* .wrapper-chart {
    height: 100px;
  } */

  /* canvas {
    background: #fff;
    height: 200px;
  } */
</style>
<div class="dashboardcontent">
  <div class="dashboardcontent-row container">

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_1">แหล่งท่องเที่ยว (Attraction) <span id="count_item_1">0</span> รายการ</h5>
        <div class="wrapper-chart">
          <canvas id="chart_1"></canvas>
        </div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_2">ที่พักนักท่องเที่ยว (Accommodation) <span id="count_item_2">0</span> รายการ</h5>
        <div class="wrapper-chart">
          <canvas id="chart_2"></canvas>
        </div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_3">การท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism) <span id="count_item_3">0</span> รายการ</h5>
        <div class="wrapper-chart">
          <canvas id="chart_3"></canvas>
        </div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_4">รายการการนำเที่ยว <span id="count_item_4">0</span> รายการ</h5>
        <div class="wrapper-chart">
          <canvas id="chart_4"></canvas>
        </div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_5">การท่องเที่ยวคาร์บอนต่ำเพื่อความยั่งยืน <span id="count_item_5">0</span> รายการ</h5>
        <div class="wrapper-chart">
          <canvas id="chart_5"></canvas>
        </div>
      </div>
    </div>

  </div>
</div>
<script>
  $(function() {
    $('.btn-menulist').each(function(key, elm) {
      if ($(elm).data('tab') == 2) {
        $(elm).click();
      }
    });

    var res = main_post(BASE_URL_BACKEND + '/dashboard/getData');

    // Chart 1
    var series_1 = [
      res.attraction[1][1].length,
      res.attraction[1][2].length,
      res.attraction[1][3].length,
      res.attraction[1][4].length,
      res.attraction[1][5].length,
      res.attraction[1][6].length,
    ];
    createChart('chart_1', series_1, res.type_sub[1]);

    // Chart 2
    var series_2 = [
      res.attraction[2][7].length,
      res.attraction[2][8].length,
      res.attraction[2][9].length,
      res.attraction[2][10].length,
    ];
    createChart('chart_2', series_2, res.type_sub[2]);

    // Chart 3
    var series_3 = [
      res.attraction[3][11].length,
      res.attraction[3][12].length,
      res.attraction[3][13].length,
      res.attraction[3][14].length,
    ];

    createChart('chart_3', series_3, res.type_sub[3]);


    // Chart 4
    var series_4 = [
      res.attraction[4][15].length,
    ];

    createChart('chart_4', series_4, res.type_sub[4]);

    // Chart 4
    var series_5 = [
      res.attraction[5][16].length,
    ];

    createChart('chart_5', series_5, res.type_sub[5]);


    $('#count_item_1').html(eval(series_1.join("+")));
    $('#count_item_2').html(eval(series_2.join("+")));
    $('#count_item_3').html(eval(series_3.join("+")));
    $('#count_item_4').html(eval(series_4.join("+")));
    $('#count_item_5').html(eval(series_5.join("+")));
  });



  function createChart(chartId, data, labels) {

    const ctx = document.getElementById(chartId).getContext("2d");
    if ($(window).width() > 748) {
      var position = "right";
    } else {
      var position = "top";
    }

    var color = rendom_color();
    if (chartId == 'chart_4') { // ฟ้า
      color = ['#74b9ff'];
    } else if (chartId == 'chart_5') { // เขียว
      color = ['#00b894'];
    }

    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          // label: "Test2",
          data: data,
          backgroundColor: color,
          // borderColor: [],
          // borderWidth: 1
        }]
      },
      options: {
        title: {
          display: false,
          text: "The Dashboard"
        },
        animation: {
          animateScale: true,
          animateRotate: true
        },
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          cursor: "pointer",
          display: true,
          position: position,
          align: "start",
          offsetY: 0,
          offsetX: 0,
          width: 600,
          markers: {
            width: 10,
            height: 10
          },
          labels: {
            boxWidth: 12,
            padding: 12,
          },
          layout: {
            padding: {
              left: 220
            }
          }
        },
      }
    });
  };

  function rendom_color() {

    const array = [
      '#55efc4', '#81ecec', '#74b9ff', '#a29bfe',
      // '#00b894', '#00cec9', '#0984e3', '#6c5ce7', '#b2bec3',
      '#ffeaa7', '#fab1a0', '#ff7675', '#fd79a8', '#636e72',
      '#ff9f43', '#e17055', '#d63031', '#e84393', '#6c5ce7', '#00b894',
    ];

    let randomIndex;
    let currentIndex = array.length;

    // While there remain elements to shuffle.
    while (currentIndex != 0) {

      // Pick a remaining element.
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;

      // And swap it with the current element.
      [array[currentIndex], array[randomIndex]] = [
        array[randomIndex], array[currentIndex]
      ];
    }

    return array;
  }
</script>