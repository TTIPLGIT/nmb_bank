(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

	// Selected menu active
	var url = window.location.href;
	var arrUrl = url.split('/');
	var routeUrl = '';
	$(".app-menu a").each(function() {
		if(arrUrl.length == 4) {
			routeUrl = url;
		}
		if(arrUrl.length == 5) {
			routeUrl = url;
		}
		if(arrUrl.length >= 6) {
			routeUrl = arrUrl[0]+'/'+arrUrl[1]+'/'+arrUrl[2]+'/'+arrUrl[3]+'/'+arrUrl[4];
		}
		if (routeUrl == (this.href)) {
			//$(this).closest("a").addClass("active");
			//for making parent of submenu active
			//$(this).closest("a").parent().parent().parent().addClass("is-expanded");treeview
			$(this).closest("a").parentsUntil("treeview").addClass("is-expanded");
			//$(this).closest("a").parentsUntil("treeview").children("a").addClass("active");
		}
	});
})();
