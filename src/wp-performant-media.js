import 'intersection-observer';
import lozad from 'lozad';

import './wp-performant-media.scss';

lozad(".lazy-load", { 
	rootMargin: "300px 0px", 
	loaded: function (el) {
		el.classList.add("is-loaded");
	}
}).observe();