<script>
var areaChartData = {
	  labels  : [<?php foreach ($jumlah_keluhan as $key=>$value){ echo "'" . $key . "',"; }?>],
	  datasets: [
		{
		  label               : 'Jumlah Keluhan',
		  backgroundColor     : 'rgba(60,141,188,0.9)',
		  borderColor         : 'rgba(60,141,188,0.8)',
		  pointRadius          : false,
		  pointColor          : '#3b8bba',
		  pointStrokeColor    : 'rgba(60,141,188,1)',
		  pointHighlightFill  : '#fff',
		  pointHighlightStroke: 'rgba(60,141,188,1)',
		  data                : [<?php foreach ($jumlah_keluhan as $key=>$value){ echo "'" . $value . "',"; }?>]
		},
	  ]
	}
	var barChartCanvas = $('#barChart').get(0).getContext('2d');
	var barChartData = $.extend(true, {}, areaChartData);
	var barChartOptions = {
	  responsive              : true,
	  maintainAspectRatio     : false,
	  datasetFill             : false
	};
	new Chart(barChartCanvas, {
	  type: 'bar',
	  data: barChartData,
	  options: barChartOptions
	});
</script>