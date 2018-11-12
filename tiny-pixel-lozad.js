lozad(".lazy-load", { 
		rootMargin: "300px 0px", 
		loaded: function (el) {
			el.classList.add("is-loaded");
		}
	}).observe();