<style>
  .apexcharts-legend-series {
    cursor: pointer;
    line-height: normal;
    margin: 0px 5px !important;
  }
</style>
<div class="dashboardcontent">
  <div class="dashboardcontent-row container">

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_1">แหล่งท่องเที่ยว (Attraction) <span id="count_item_1">0</span> รายการ</h5>
        <div id="chart_1"></div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_2">ที่พักนักท่องเที่ยว (Accommodation) <span id="count_item_2">0</span> รายการ</h5>
        <div id="chart_2"></div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_3">การท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism) <span id="count_item_3">0</span> รายการ</h5>
        <div id="chart_3"></div>
      </div>
    </div>

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <h5 id="title_chart_4">รายการการนำเที่ยว <span id="count_item_4">0</span> รายการ</h5>
        <div id="chart_4"></div>
      </div>
    </div>

  </div>
</div>
<script>
  $(function() {

    var res = main_post(BASE_URL_BACKEND + '/Dashboard/getData');
    // cc(res)

    // Shared Colors Definition
    // const primary = '#6993FF';
    // const success = '#1BC5BD';
    // const info = '#8950FC';
    // const warning = '#FFA800';
    // const danger = '#F64E60';
    // const green = '#0f0';

    const colors = [
      // '#55efc4','#81ecec','#74b9ff','#a29bfe','#dfe6e9',
      // '#00b894','#00cec9','#0984e3','#6c5ce7','#b2bec3',
      // '#ffeaa7','#fab1a0','#ff7675','#fd79a8','#636e72',
      '#ff9f43', '#e17055', '#d63031', '#e84393', '#6c5ce7', '#00b894',
    ];

    // Chart 1
    var series_1 = [
      res.attraction[1][1].length,
      res.attraction[1][2].length,
      res.attraction[1][3].length,
      res.attraction[1][4].length,
      res.attraction[1][5].length,
      res.attraction[1][6].length,
    ];
    var options_1 = {
      series: series_1, // เอาไว้ใส่ item
      labels: res.type_sub[1],
      chart: {
        width: '100%',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        fontSize: '15px',
        offsetY: 0,
        width: 550,
        markers: {
          width: 13,
          height: 13
        },
        formatter: function(seriesName, opts) {
          return [seriesName, "&nbsp;&nbsp;&nbsp;", '<span style="float:right;margin-top: 3px;"><b>' + opts.w.globals.series[opts.seriesIndex] + '</b></span>']
        },
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 250
          },
          legend: {
            position: ''
          }
        }
      }],
      colors: colors
    }
    var chart_1 = new ApexCharts(document.querySelector("#chart_1"), options_1);
    chart_1.render();

    // Chart 2
    var series_2 = [
      res.attraction[2][7].length,
      res.attraction[2][8].length,
      res.attraction[2][9].length,
      res.attraction[2][10].length,
    ];
    var options_2 = {
      series: series_2, // เอาไว้ใส่ item
      labels: res.type_sub[2],
      chart: {
        width: '100%',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        fontSize: '15px',
        offsetY: 0,
        width: 550,
        markers: {
          width: 13,
          height: 13
        },
        formatter: function(seriesName, opts) {
          return [seriesName, "&nbsp;&nbsp;&nbsp;", '<span style="float:right;margin-top: 3px;"><b>' + opts.w.globals.series[opts.seriesIndex] + '</b></span>']
        },
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 250
          },
          legend: {
            position: ''
          }
        }
      }],
      colors: colors
    }
    var chart_2 = new ApexCharts(document.querySelector("#chart_2"), options_2);
    chart_2.render();

    // Chart 3
    var series_3 = [
      res.attraction[3][11].length,
      res.attraction[3][12].length,
      res.attraction[3][13].length,
      res.attraction[3][14].length,
    ];
    var options_3 = {
      series: series_3, // เอาไว้ใส่ item
      labels: res.type_sub[3],
      chart: {
        width: '100%',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        fontSize: '15px',
        offsetY: 0,
        width: 550,
        markers: {
          width: 13,
          height: 13
        },
        formatter: function(seriesName, opts) {
          return [seriesName, "&nbsp;&nbsp;&nbsp;", '<span style="float:right;margin-top: 3px;"><b>' + opts.w.globals.series[opts.seriesIndex] + '</b></span>']
        },
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 250
          },
          legend: {
            position: ''
          }
        }
      }],
      colors: colors
    }
    var chart_3 = new ApexCharts(document.querySelector("#chart_3"), options_3);
    chart_3.render();

    // Chart 4
    var series_4 = [
      res.attraction[4][15].length,
    ];
    var options_4 = {
      series: series_4, // เอาไว้ใส่ item
      labels: res.type_sub[4],
      chart: {
        width: '100%',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        fontSize: '15px',
        offsetY: 0,
        width: 550,
        markers: {
          width: 13,
          height: 13
        },
        formatter: function(seriesName, opts) {
          return [seriesName, "&nbsp;&nbsp;&nbsp;", '<span style="float:right;margin-top: 3px;"><b>' + opts.w.globals.series[opts.seriesIndex] + '</b></span>']
        },
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 250
          },
          legend: {
            position: ''
          }
        }
      }],
      colors: colors
    }
    var chart_4 = new ApexCharts(document.querySelector("#chart_4"), options_4);
    chart_4.render();

    $('#count_item_1').html(eval(series_1.join("+")));
    $('#count_item_2').html(eval(series_2.join("+")));
    $('#count_item_3').html(eval(series_3.join("+")));
    $('#count_item_4').html(eval(series_4.join("+")));
  });
</script>