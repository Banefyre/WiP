$( document ).ready(function() {

	var start = new Date("2013-09-22");
	//	var end = new Date("2014-05-30");

	//	focus(new Date());

	function focus(date) {
		date = new Date(date);
		var diffDays = subDates(date, start);
		return (diffDays);
	}

	function subDates(date1, date2) {
		var timeDiff = Math.abs(date1.getTime() - date2.getTime());
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		return diffDays;
	}

	$('#timeline-container').on('mousewheel', function(event) {
		$(".timeline-group").animate({left: "+=" + (event.deltaY * event.deltaFactor) }, 10);
	});

	$("#left").click(function() {
		$(".timeline-group").animate({left: "+=50",}, 50);
	});

	$("#right").click(function() {
		$(".timeline-group").animate({left: "-=50",}, 50);
	});

	$('#timeline-container').bind('mousewheel', function(event, delta) {
		val = this.scrollLeft - (delta * 50);
		$(this).stop().animate({scrollLeft:val},500);
		event.preventDefault();
	});

	$('#timeline').fadeIn(500);
	$('.timeline-group').delay(500).fadeIn(500);

	$('.timeline-group').each(function(){
		var len = $(this).children().length;
		if (len > 5)
			len = 5;
		$(this).attr("class", "timeline-group scale" + len);
	});

	var width;

	$('.timeline-group').hover(
		function(){
			width = $(this).width();
			var len = $(this).children().length;
			$(this).append("<p id='number_commit'>" + len + "</p>");
			$('#number_commit').delay(400).fadeIn(250);
		}, function() {
			$("#number_commit").remove();
		});

	$('.timeline-group').click(function(){
		$(".timeline-group").removeClass("focus");
		$(this).addClass('focus');

		$("#number_commit").remove();
		var len = $(this).children().length;
		$(this).append("<p id='number_fixed'>" + len + "</p>");
		//$('#number_commit').delay(400).fadeIn(250);


		diff = focus($(this).children().attr('date'));
		var start = $("#group_9").css("left").replace(/[^-\d\.]/g, '');
		var offset = +start + +(100 * diff) - +($('#timeline-container').width() / 2) + +width / 2;
		$('.timeline-group').animate({left: "-=" + offset }, 500);

	});

});
