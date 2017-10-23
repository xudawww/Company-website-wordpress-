function post_ajax() {
	var result = '';
	$.ajax({
        type: "POST",
        url: "check_new_orders",
		data: {},
		success: function(response) {
			result = response;
		},
		error: function(response) {
			result = localStorage.orders;
		},
		async: false
		});
		
		return result;
}
$(document).ready(function () {
		//localStorage.clear();
		if(localStorage.orders == undefined) {
     	localStorage.orders = 0;
		}
		setInterval(function(){ 
			var new_orders = post_ajax();
			new_orders = Number(new_orders);
			if(localStorage.orders < new_orders) {
				localStorage.orders = new_orders;
				//$('#order_notification').attr("src", "./notification.mp3");
				$('#order_notification')[0].play();
			}
		}, 2000);
});
