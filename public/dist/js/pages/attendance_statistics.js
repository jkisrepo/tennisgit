var bar = new Morris.Bar({
    element: 'bar-chart',
    resize: true,
    data: window['byMonthAndYear'],
    barColors: ['#337ab7'],
    xkey: 'date',
    ykeys: ["attendance"],
    labels: ["Attendance"],
    hideHover: 'auto',
    dateFormat: function (value) {
        return moment(value).format('DD MMM');
    }
});


var bar = new Morris.Bar({
    element: 'bar-chart1',
    resize: true,
    data: window['byMonthAndYear'],
    barColors: ['#00a65a', '#f56954'],
    xkey: 'month',
    ykeys: ["present", "absent"],
    labels: ["Present", "Absent"],
    hideHover: 'auto'
});
