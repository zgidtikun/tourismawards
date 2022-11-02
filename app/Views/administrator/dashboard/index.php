<div class="dashboardcontent">
  <div class="dashboardcontent-row">

    <div class="dashboardcontent-col2">
      <div class="dashboardcontent-detail">
        <div id="chart"></div>
      </div>
    </div>

  </div>
</div>
<script>
  var options = {
    labels: ['Wellness & Spa Retreat (เวลเนส แอนด์ สปา รีทรีต)', 'February', 'March', 'April'],
    chart: {
      // width: '100%',
      type: "donut",
      events: {
        // updated: function() {
        //   // $(".apexcharts-legend").mCustomScrollbar();
        // }
      }
    },
    dataLabels: {
      enabled: false
    },
    series: [44, 55, 13, 33], // เอาไว้ใส่ item
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 100
        },
        legend: {
          show: true
        }
      }
    }],
    legend: {
      position: "right",
      offsetX: -40,
      offsetY: 0,
      height: 250
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);

  chart.render().then(() => {
    // $(".apexcharts-legend").mCustomScrollbar();
  });
</script>