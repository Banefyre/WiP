$( document ).ready(function() {

	//	var start = new Date("2014-05-01");
	//	var end = new Date("2014-05-30");

	//	focus(new Date());

	function focus(date) {
		console.log(date);
		console.log(start);
		var diffDays = subDates(date, start);
	}

	function subDates(date1, date2) {
		var timeDiff = Math.abs(date1.getTime() - date2.getTime());
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		return diffDays;
	}

	$('#timeline-container').on('mousewheel', function(event) {
		$(".timeline-cp").animate({left: "+=" + (event.deltaY * event.deltaFactor) }, 10);
		console.log(event.deltaX, event.deltaY, event.deltaFactor);
	});

	$("#left").click(function() {
		console.log("test");
		$(".timeline-cp").animate({left: "+=50",}, 50);
	});

	$("#right").click(function() {
		$(".timeline-cp").animate({left: "-=50",}, 50);
	});

	$('#timeline-container').bind('mousewheel', function(event, delta) {
		val = this.scrollLeft - (delta * 50);
		jQuery(this).stop().animate({scrollLeft:val},500);
		event.preventDefault();
	});
});
