$(".pupil-mark").click(function(){
	$(this).parent().parent().children('.pupil-name').addClass('bold');
	$(".marks-dates-list").children("#"+$(this).attr('id')).addClass('bold');
});

$(".pupil-mark").blur(function(){
	$(this).parent().parent().children('.pupil-name').removeClass('bold');
	$(".marks-dates-list").children("#"+$(this).attr('id')).removeClass('bold');

	var mark = $(this).val().replace(/[^0-9]/g,""),
		subj = $(".subject-button.bold").attr('id'),
		pupil = $(this).parent().parent().children('.pupil-name').attr('id'),
		date = $(".marks-dates-list").children("#"+$(this).attr('id')).text().split("."),
		day = date[0],
		month = date[1];
	$.ajax({
            type: "POST",
            url: "site/addmarks",
            dataType:"json",
            data: {"subject" : subj, "pupil" : pupil, "mark" : mark, "day" : day, "month" : month},
            success:function(response){
	            $(this).css("background-color", "green");
            },
            error:function (xhr, ajaxOptions, thrownError){
                //alert("error updating marks, contact administrator, please");
            }
        });
});

$(".btn-addlesson").click(function(){
	var date = $(".calendar").val(),
		theme = $(".theme-content").text(),
		subj = $(".subject-button.bold").attr('id');
	//try{
		date = date.split(".");
		$.ajax({
            type: "POST",
            url: "site/addlesson",
            dataType:"json",
            data: {"theme" : theme, "subject" : subj, "day" : date[0], "month" : date[1]},
            success:function(response){
	           window.location.href = "addmarks?subject="+subj+"&m="+date[1];
	        },
            error:function (xhr, ajaxOptions, thrownError){
                alert("error adding lesson, contact administrator, please");
            }
        });
	//}catch(e){}

});

$(".month-select").change(function(){
	var data = $(".month-select option:selected").val().split("-");
	window.location.href.match(/addmarks/i) ?
	window.location.href = "addmarks?subject="+data[0]+"&m="+data[1] :
	window.location.href = "viewmarks?subject="+data[0]+"&m="+data[1];
});

