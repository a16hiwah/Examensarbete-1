// ==UserScript==
// @name CakePHP navigation to use when measuring php execution time
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CakePHP/resources/*
// @grant none
// ==/UserScript==

window.onload = function ()
{
	/** How many measurements to run */
	const MEASUREMENTS = 500;

	/** How many measurments has been done */
	const TIMES_RUN = (localStorage.getItem("TIMES_RUN"))
		? parseInt(localStorage.getItem("TIMES_RUN"))
		: 0;
		
	/** Last page visited */
	var last_visit = (localStorage.getItem("last_visit"))
		? parseInt(localStorage.getItem("last_visit"))
		: -1;

	if (TIMES_RUN < MEASUREMENTS)
	{
		localStorage.setItem("TIMES_RUN", TIMES_RUN + 1);
		console.log(`Times run: ${TIMES_RUN + 1} of ${MEASUREMENTS}`);
		navigatePages();
	}
	else
	{
		console.log("Navigation complete");
	}

	/** Navigates to the next page that should be loaded and measured */
	function navigatePages()
	{
		var active_page = window.location.href;

		if (active_page.search("open") > -1)
		{
			/** Go back to "Resources" page */
			window.open(
				"http://localhost/Examensarbete/App/CakePHP/resources/view/a",
				"_self"
			)
		}
		else
		{
			/** Open next resource page */

			/** Get all pages that should be visited */
			var elements = document.querySelectorAll('td > a');

			/** Start over when all pages has been visited */
			if (last_visit === elements.length - 1)
			{
				last_visit = -1;
			}

			localStorage.setItem("last_visit", last_visit + 1);
			
			elements[last_visit+1].click();
		}
	}

};
