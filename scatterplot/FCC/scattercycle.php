<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>FCC Data Viz Project #4: Scatterplot</title>
    <meta name='viewport' content='user-scalable=no, width=device-width, initial-scale=1' />
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='mobile-web-app-capable' content='yes'> 

    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    <script src='https://d3js.org/d3.v4.min.js'></script>
	<style>
		.axis path,
		.axis line {
			fill: none;
			stroke: white;
			shape-rendering: crispEdges;
		}
		
		.axis text {
			font-family: sans-serif;
			fill: white;
		}
	
	</style>
</head>

<body>

<div id="title"></div>
<div id="forChart"></div>
<script>

const datafile = 'data/cyclist-data.json';
	
const w = 1800;
const h = 800;
const margin = {
	top: 25,
	right: 25,
	bottom: 25,
	left: 25
};
	
//const year = timeFormat('%Y');

const rowConverter = function(d){
	return {
		title: d.title,
		year: parseTime(d.year),
		plays: d.plays
	};
};
	
const forTitle = "Doping in Professional Bicycle Racing";
const forSubTitle = "35 Fastest times up Alpe d'Huez";
	
d3.json(datafile, function(dataset) {

	console.log(dataset);

	const artistTitle = d3.select("#title")
		.text(forTitle);
	
	const xScale = d3.scaleLinear()
					 .domain([1970, 2020])
					 .range([margin.left, w-margin.right]);

	xScale = d3.scaleTime()
                .domain([
                    d3.min(dataset, function(d) { return d.date; }),
                    d3.max(dataset, function(d) { return d.date; })
                ])
                .range([margin.left, w - margin.right]);

	var svg = d3.select("#forChart")
		.append("svg")
		.attr("width", w)
		.attr("height", h);

	svg.selectAll("circle")
		.data(dataset)
		.enter()
		.append("circle")
		.attr("cx", function (d) {
			released = parseInt(d.year);
			return xScale(released);
		})
		.attr("cy", function(d) {
			playcount = parseInt(d.plays);
			return yScale(playcount);			
		})
		.attr("r", 5)
		.style("fill", "white")
		.append("title")
		.text(function(d){
			return d.title;
		});
	
	const formatYear = d3.format("d");
	
	const xAxis = d3.axisBottom()
					.scale(xScale)
					.tickFormat(formatYear);
	
	svg.append("g")
		.attr("class", "axis")
	   .attr("transform", "translate(0," + (h-margin.bottom) + ")")
	   .call(xAxis);

	svg.append("g")
		.attr("id", "y-axis")
		.attr("transform", "translate(" + padding + ",0)")
		.call(yAxis);

});		
</script>	

</body>

</html>