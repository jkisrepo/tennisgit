 // LINE CHART
 var line = new Morris.Line({
     element: 'line-chart',
     resize: true,
     data: window['byMonthAndYear_statistic'],
     xkey: 'date',
     ykeys: [window['post_data_field']],
     labels: [window['post_data_field'][0].toUpperCase() + window['post_data_field'].slice(1)],
     lineColors: ['#3c8dbc'],
     hideHover: 'auto',
     dateFormat: function (value) {
         return moment(value).format('DD MMM');
     },
     xLabelFormat: function (value) {
         return moment(value).format('DD MMM');
     }
 });

 //BAR CHART
 var bar = new Morris.Bar({
     element: 'bar-chart',
     resize: true,
     data: window['byYear_statistic'],
     barColors: ['#00a65a'],
     xkey: 'month',
     ykeys: [window['post_data_field']],
     labels: [window['post_data_field'][0].toUpperCase() + window['post_data_field'].slice(1)],
     hideHover: 'auto'
 });
