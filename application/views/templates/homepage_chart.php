<div class="nav-tabs-custom">
    <ul class="nav nav-tabs pull-right">
        <li class="active"><a data-toggle="tab" href="#colume-chart">Chart</a>
          
          </li>
        <li><a data-toggle="tab" href="#line-chart">Line</a></li>
        <li><a data-toggle="tab" href="#pie-chart">Pie</a></li>
    </ul>
    <div class="tab-content">
          <div class="tab-pane active" id="colume-chart">
            <div id="chart1"></div>
          </div>
          <div class="tab-pane" id="line-chart">
            <div id="line_chart"></div>
          </div>
          <div class="tab-pane" id="pie-chart">
            <div id="pie_chart" ></div>
          </div>
     </div>
</div>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


function adminlogin()
{
    adminlogout_process (document.getElementById("admin_un").value);
}
if(screen.width < 767)
{
    google.charts.load('current', {'packages':['bar','corechart']});
    google.charts.setOnLoadCallback(drawColumnChartMobile);
}
else
{
    google.charts.load('current', {'packages':['bar','corechart']});
    google.charts.setOnLoadCallback(drawColumnChart1);
}
    google.charts.load('current', {'packages':['bar','corechart']});
    google.charts.setOnLoadCallback(drawColumnChart1);
    google.charts.setOnLoadCallback(drawLineChart);
    google.charts.setOnLoadCallback(drawPieChart);
    
    function drawColumnChart1() {

        var data = google.visualization.arrayToDataTable([
         ['Today', 'Revenue', { role: 'style' }, { role: 'annotation' } ],
         ['Today', <?php echo $revenue_day; ?>, '#b87333','<?php echo $revenue_day; ?> USD' ],
         ['This week',<?php echo $revenue_week; ?>, '#b87333','<?php echo $revenue_week; ?> USD'  ],
         ['This month', <?php echo $revenue_month; ?>, 'silver','<?php echo $revenue_month; ?> USD'  ],
         ['This year', <?php echo $revenue_year; ?>, 'gold', '<?php echo $revenue_year; ?> USD' ]
      ]);
        var options = {
                       width:900,
                       height:300};
        var chart = new google.visualization.ColumnChart(document.getElementById('chart1'));
        chart.draw(data, options);
      }




      function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
             ['Today', 'Revenue', { role: 'style' }, { role: 'annotation' } ],
             ['Today', <?php echo $revenue_day; ?>, '#b87333','<?php echo $revenue_day; ?> USD' ],
             ['This week',<?php echo $revenue_week; ?>, '#b87333','<?php echo $revenue_week; ?> USD'  ],
             ['This month', <?php echo $revenue_month; ?>, 'silver','<?php echo $revenue_month; ?> USD'  ],
             ['This year', <?php echo $revenue_year; ?>, 'gold', '<?php echo $revenue_year; ?> USD' ]
          ]);

        var options = {
        chartArea:{
        width: '100%',
        left: '10%'
        },
        width: '900',
        colors: ['#39BA99'],
        legend: 'none',
        backgroundColor: { fill:'transparent' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
      }

      function drawPieChart(){
        //=====================Pine Chart===================    
         var piedata = google.visualization.arrayToDataTable([
             ['Today', 'Revenue', { role: 'style' }, { role: 'annotation' } ],
             ['Today', <?php echo $revenue_day; ?>, '#b87333','<?php echo $revenue_day; ?> USD' ],
             ['This week',<?php echo $revenue_week; ?>, '#b87333','<?php echo $revenue_week; ?> USD'  ],
             ['This month', <?php echo $revenue_month; ?>, 'silver','<?php echo $revenue_month; ?> USD'  ],
             ['This year', <?php echo $revenue_year; ?>, 'gold', '<?php echo $revenue_year; ?> USD' ]
          ]);
         

        var options = {          
          backgroundColor: { fill:'transparent' },
          colors: ['#535176','#454564','#31354B'],
          legend: 'none',
           width: '900',
          height: '500'
        };

        var piechart = new google.visualization.PieChart(document.getElementById('pie_chart'));

        piechart.draw(piedata,options);




      }



      function drawColumnChartMobile() {
       
        var data = google.visualization.arrayToDataTable([
         ['Today', 'Revenue', { role: 'style' }, { role: 'annotation' } ],
         ['Today', <?php echo $revenue_day; ?>, '#b87333','<?php echo $revenue_day; ?> USD' ],
         ['This week',<?php echo $revenue_week; ?>, '#b87333','<?php echo $revenue_week; ?> USD'  ],
         ['This month', <?php echo $revenue_month; ?>, 'silver','<?php echo $revenue_month; ?> USD'  ],
         ['This year', <?php echo $revenue_year; ?>, 'gold', '<?php echo $revenue_year; ?> USD' ]
      ]);
        
        var options = {
                       width:400,
                       height:300};

        
        var chart = new google.visualization.ColumnChart(document.getElementById('chart1'));
        chart.draw(data, options);
      }
</script>