$( document ).ready(function() {

	var start = new Date($("#timeline div").last().attr("date"));

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
		$(".timeline-group").removeClass("focus");
		$('#fake-form').hide();
		$('#list-cp').empty();
		$('#infos-cp').empty();
		$('#number_fixed').remove();
		$('#infos-content').fadeOut(250);
		$('#list-cp').fadeOut(250);
		$('div[scrollable="true"]').animate({left: "+=" + (event.deltaY * event.deltaFactor) }, 10);
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


	var html = [];
	var left = $("#timeline div").last().parent().width() / 2;
	var allRange = (parseInt($("#group_0").css("left")) - parseInt($("#timeline div").last().parent().css("left")));
	for (i = 0; i < (allRange / 100) + 1; i++) {
		html.push('<div class="marker" style="left:' + left + 'px"></div>');
		left += 100;
	}
	$("#markers").append( html.join('') );


	var width;

	$('.timeline-group').hover(
		function(){
			if (!$(this).hasClass('focus'))
			{
				width = $(this).width();
				var len = $(this).children().length;
				$(this).append("<p id='number_commit'>" + len + "</p>");
				$('#number_commit').delay(400).fadeIn(250);
			}
		}, function() {
			$("#number_commit").remove();
		});

	$('.timeline-group').click(function(){
		$(".timeline-group").removeClass("focus");
		$('#infos-cp').empty();
		$('#list-cp').empty();
		$('#fake-form').hide();
		$(this).addClass('focus');
		$('#number_fixed').remove();
		$("#number_commit").remove();
		var len = $(this).children().length;
		$(this).append("<p id='number_fixed'>" + len + "</p>");
		//$('#number_commit').delay(400).fadeIn(250);
		$('#infos-content').fadeIn(250);
		$('#list-cp').fadeIn(250);
		//diff = focus("2014-05-12");
		diff = focus($(this).children().attr('date'));
		var start = $("#timeline div").last().parent().css("left").replace(/[^-\d\.]/g, '');
		var offset = +start + +(100 * diff) - +($('#timeline-container').width() / 2) + +width / 2;
		//console.log(start, offset);
		$('div[scrollable="true"]').animate({left: "-=" + offset }, 500);


		var author;
		var full_date;
		var sha;
		var author;
		var description;


		var date = $(this).children().attr('date');
		$('#list-cp').append('<h4>' + date  + '</h4>');
		$(this).children("div").each(function (){
			author = $(this).attr('commit_author');
			full_date = $(this).attr('full_date');
			sha = $(this).attr('sha');
			description = $(this).attr('description');
			url = $(this).attr('url');
			$('#list-cp').append('<p><a class="commit_link" href="#">' + author + ' authored on ' + full_date + '</a>');
			});

			$('.commit_link').bind("click", function(e){
				$('#list-cp').empty();
				$('#infos-cp').show();
				$('#infos-cp').append('<h4>COMMIT '+ sha.substr(0, 7) +'</h4>');
				$('#infos-cp').append('<p><span>Lien vers le commit : </span><a href='+ url +'>' + sha + '</a><br/><span>Author : </span>' + author + '<br/><span>Date : </span>' + full_date + '<br/><span>Description : </span>' + description + '<br/></p>');
		});
	});

	$('#go_date').click(function(){
		diff = focus($("#date").val());
		var start = $("#timeline div").last().parent().css("left").replace(/[^-\d\.]/g, '');
		var offset = +start + +(100 * diff) - +($('#timeline-container').width() / 2);
		$('div[scrollable="true"]').animate({left: "-=" + offset }, 500);
	});

	$('#timeline').click(function(){
		var evt=window.event;
		//window.status=evt.clientX+" : "+evt.clientY
		//var cp = ('<div id="checkpoint"></div>')
	    //.offset({ my: evt.clientX, at: evt.clientY, of: $('#timeline') })
	    //.appendTo('#timeline');
		console.log(evt.clientY);
		var css = evt.clientX - 40;
		if (evt.clientY < 413 && evt.clientY > 400)
		{
			$('#infos-content').fadeIn(250);
			$('#fake-form').show();
			$('#timeline').append("<div scrollable='true' class='timeline-group blue scale4' id='group_99' style='left: " + css + "px; display: block;'></div>");
		}
	});

	$('#save_cp').click(function(){
		$('#infos-content').hide();
	});

});
