<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/dashboard/pie-chart',
            type: 'POST',
            dataType: 'JSON',
            contentType : 'application/json',
        }).done(function(response) {
            donutWithDetails("#donut_basic_details", 146, response);
        });
    });

    // Chart setup
    function donutWithDetails(element, size, data) {    

    // Basic setup
    // ------------------------------

    // Main variables
    var d3Container = d3.select(element),
        distance = 2, // reserve 2px space for mouseover arc moving
        radius = (size/2) - distance,
        sum = d3.sum(data, function(d) { return d.value; });


    // Tooltip
    // ------------------------------

    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0])
        .direction('e')
        .html(function (d) {
            return "<ul class='list-unstyled mb-5'>" +
                "<li>" + "<div class='text-size-base mb-5 mt-5'>" + d.data.icon + d.data.status + "</div>" + "</li>" +
                "<li>" + "Total: &nbsp;" + "<span class='text-semibold pull-right'>" + d.value + "</span>" + "</li>" +
                "<li>" + "Share: &nbsp;" + "<span class='text-semibold pull-right'>" + (100 / (sum / d.value)).toFixed(2) + "%" + "</span>" + "</li>" +
            "</ul>";
        });


    // Create chart
    // ------------------------------

    // Add svg element
    var container = d3Container.append("svg").call(tip);

    // Add SVG group
    var svg = container
        .attr("width", size)
        .attr("height", size)
        .append("g")
            .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");  


    // Construct chart layout
    // ------------------------------

    // Pie
    var pie = d3.layout.pie()
        .sort(null)
        .startAngle(Math.PI)
        .endAngle(3 * Math.PI)
        .value(function (d) { 
            return d.value;
        }); 

    // Arc
    var arc = d3.svg.arc()
        .outerRadius(radius)
        .innerRadius(radius / 1.35);


    //
    // Append chart elements
    //

    // Group chart elements
    var arcGroup = svg.selectAll(".d3-arc")
        .data(pie(data))
        .enter()
        .append("g") 
            .attr("class", "d3-arc")
            .style({
                'stroke': '#fff',
                'stroke-width': 2,
                'cursor': 'pointer'
            });

    // Append path
    var arcPath = arcGroup
        .append("path")
        .style("fill", function (d) {
            return d.data.color;
        });


    //
    // Add interactions
    //

    // Mouse
    arcPath
        .on('mouseover', function(d, i) {

            // Transition on mouseover
            d3.select(this)
            .transition()
                .duration(500)
                .ease('elastic')
                .attr('transform', function (d) {
                    d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                    var x = Math.sin(d.midAngle) * distance;
                    var y = -Math.cos(d.midAngle) * distance;
                    return 'translate(' + x + ',' + y + ')';
                });

            $(element + ' [data-slice]').css({
                'opacity': 0.3,
                'transition': 'all ease-in-out 0.15s'
            });
            $(element + ' [data-slice=' + i + ']').css({'opacity': 1});
        })
        .on('mouseout', function(d, i) {

            // Mouseout transition
            d3.select(this)
            .transition()
                .duration(500)
                .ease('bounce')
                .attr('transform', 'translate(0,0)');

            $(element + ' [data-slice]').css('opacity', 1);
        });

    // Animate chart on load
    arcPath
        .transition()
        .delay(function(d, i) {
            return i * 500;
        })
        .duration(500)
        .attrTween("d", function(d) {
            var interpolate = d3.interpolate(d.startAngle,d.endAngle);
            return function(t) {
                d.endAngle = interpolate(t);
                return arc(d);  
            }; 
        });


    //
    // Add text
    //

    // Total
    svg.append('text')
        .attr('class', 'text-muted')
        .attr({
            'class': 'half-donut-total',
            'text-anchor': 'middle',
            'dy': -13
        })
        .style({
            'font-size': '12px',
            'fill': '#999'
        })
        .text('Total');

    // Count
    svg
        .append('text')
        .attr('class', 'half-donut-count')
        .attr('text-anchor', 'middle')
        .attr('dy', 14)
        .style({
            'font-size': '21px',
            'font-weight': 500
        });

    // Animate count
    svg.select('.half-donut-count')
        .transition()
        .duration(1500)
        .ease('linear')
        .tween("text", function(d) {
            var i = d3.interpolate(this.textContent, sum);

            return function(t) {
                this.textContent = d3.format(",d")(Math.round(i(t)));
            };
        });


    //
    // Add legend
    //

    // Append list
    var legend = d3.select(element)
        .append('ul')
        .attr('class', 'chart-widget-legend')
        .selectAll('li')
        .data(pie(data))
        .enter()
        .append('li')
        .attr('data-slice', function(d, i) {
            return i;
        })
        .attr('style', function(d, i) {
            return 'border-bottom: solid 2px ' + d.data.color;
        })
        .text(function(d, i) {
            return d.data.status + ': ';
        });

    // Append text
    legend.append('span')
        .text(function(d, i) {
            return d.data.value;
        });
    }
</script>