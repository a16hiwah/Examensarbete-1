// ==UserScript==
// @name 03 CodeIgniter - Response time for opening resources
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CodeIgniter/*
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/RandApp/randapp.js
// @grant none
// ==/UserScript==

// If the script stops, it is possible to refresh the page manually in the browser
// If it stops often, add the following line of code to the head in header.php:
// <meta http-equiv="Refresh" content="5">
// 5 is the number of seconds before an automatic page refresh and might have to
// be tweaked depending on the performance of the computer running the script

window.onload = function ()
{
	// How many measurements to run for every individual test,
	// i.e. low, medium and high amount of data for individual resources
	const MEASUREMENTS_PER_TEST = 500;

	let measurementsPerformed = (localStorage.getItem("measurementsPerformed"))
		? JSON.parse(localStorage.getItem("measurementsPerformed"))
		: { "low":0, "medium":0, "high":0 };

	// Keep track of when the script is finished
	let isCompleted = false;
	
	// Check if all tests has enough measurements
	for (const [key, value] of Object.entries(measurementsPerformed))
	{
		if (value < MEASUREMENTS_PER_TEST)
		{
			isCompleted = false;
			break;
		}
		else
		{
			isCompleted = true;
		}
	}
	
	let randApp = null;

	if ( ! isCompleted)
	{
		printStatus();
		openNextPage();
	}
	else
	{
		printStatus();

		console.log("Measurements complete");

		let results = JSON.parse(localStorage.getItem("results"));

		let csv = "";

		for (let i = 0; i < results.length; i++)
		{
			csv += results[i];

			if (i !== results.length - 1)
			{
				csv += "\n";
			}
		}

		download("codeigniter_open_resources.csv", csv);
	}

	/**
	 * Only assign an object to "randApp" before it is actually used by calling
	 * this function to prevent different navigation sequences in the web
	 * applications.
	 */
	function initRandApp()
	{
		// Pseudorandom number generator (PRNG)
		randApp = new RandApp(
			{
				"seed":1,
				"distribution":"uniform",
				"persistentSeed":false
			}
		);
	}

	/**
	 * Print status on script progress in the browser console
	 */
	function printStatus()
	{
		console.log("Measurements performed:");
		console.log("Low: " + measurementsPerformed["low"]);
		console.log("Medium: " + measurementsPerformed["medium"]);
		console.log("High: " + measurementsPerformed["high"]);
	}

	/**
	 * Opens the specified page if it is not already opened.
	 * Returns "false" if no redirect is needed.
	 */
	function redirect(url)
	{
		let activePage = window.location.href;

		if (activePage !== url)
		{
			window.open(url, "_self");
			return true;
		}
		else
		{
			return false;
		}
	}

	function openNextPage()
	{
		// The subpages on the "Resources" page that should be measured
		let subpages = [];
		
		let o = "o".charCodeAt(0);
		let z = "z".charCodeAt(0);

		// Push letters in the range o-z to the array "subpages"
		for (; o <= z; ++o)
		{
			subpages.push(String.fromCharCode(o));
		}

		initRandApp();
		
		// Choose a random subpage on the "Resources" page by selecting
		// an index from the subpages array.
		let randomSubpage = (localStorage.getItem("randomSubpage"))
			? parseInt(localStorage.getItem("randomSubpage"))
			: randApp.randIntFromIntervall(0, subpages.length - 1);

		localStorage.setItem("randomSubpage", randomSubpage);

		let subpageUrl =
			"http://localhost/Examensarbete/App/CodeIgniter/index.php/resources/view/"
			+ subpages[randomSubpage];

		let subpageOpened = (localStorage.getItem("subpageOpened"))
			? parseInt(localStorage.getItem("subpageOpened"))
			: 0;

		if ( ! subpageOpened)
		{
			if ( ! redirect(subpageUrl))
			{
				localStorage.setItem("subpageOpened", 1);
				location.reload();
			}
		}
		else
		{
			let activePage = window.location.href;

			if (activePage.search("open/") > -1)
			{
				let results = (localStorage.getItem("results"))
					? JSON.parse(localStorage.getItem("results"))
					: [];
			
				let execTime = document.getElementById("exec-time").innerHTML;

				let activeSubpage = subpages[randomSubpage];

				switch (activeSubpage)
				{
					// Low
					case "o":
					case "p":
					case "q":
					case "r":
						if (measurementsPerformed["low"] < MEASUREMENTS_PER_TEST)
						{
							measurementsPerformed["low"]++;
							results.push(`${execTime},low`);
						}
						break;

					// Medium
					case "s":
					case "t":
					case "u":
					case "v":
						if (measurementsPerformed["medium"] < MEASUREMENTS_PER_TEST)
						{
							measurementsPerformed["medium"]++;
							results.push(`${execTime},medium`);
						}
						break;

					// High
					case "w":
					case "x":
					case "y":
					case "z":
						if (measurementsPerformed["high"] < MEASUREMENTS_PER_TEST)
						{
							measurementsPerformed["high"]++;
							results.push(`${execTime},high`);
						}
						break;

					default:
						console.error(`An incorrect subpage has been opened (${activeSubpage})`);
				}

				localStorage.setItem("measurementsPerformed", JSON.stringify(measurementsPerformed));
				localStorage.setItem("results", JSON.stringify(results));
				
				reset();

				// Go back to homepage
				redirect("http://localhost/Examensarbete/App/CodeIgniter/index.php/home");
			}
			else
			{
				// All resources on the current subpage
				let resources = document.querySelectorAll('td > a');

				// The resource that should be opened
				let randomResource = randApp.randIntFromIntervall(0, resources.length - 1);

				// Clicking on the resource will open it and cause the script to
				// execute from the beginning again.
				resources[randomResource].click();
			}
		}
	}

	/**
	 * Prepare the script for a new run
	 */
	function reset()
	{
		localStorage.removeItem("randomSubpage");
		localStorage.setItem("subpageOpened", 0);
	}

	/**
	 * Function to download text as a textfile
	 * 
	 * @param {string} filename The name of the file
	 * @param {string} text The contents of the file
	 */
	function download(filename, text) {
		let element = document.createElement('a');
		element.setAttribute(
			'href',
			'data:text/plain;charset=utf-8,' + encodeURIComponent(text)
		);
		element.setAttribute('download', filename);

		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();

		document.body.removeChild(element);
	}
};
