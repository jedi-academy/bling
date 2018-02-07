// Morris.js Charts sample data for SB Admin template

$(function() {

    // Donut Chart
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Household",
            value: 15
        }, {
            label: "Butler",
            value: 12
        }, {
            label: "Companion",
            value: 4
        }, {
            label: "Motley",
            value: 30
        }],
        resize: true
    });

 
});
