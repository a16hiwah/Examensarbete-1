// ==UserScript==
// @name 05 CakePHP - Response time for opening subpages
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CakePHP/*
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/RandApp/randapp.js
// @grant none
// ==/UserScript==

// If the script stops, it is possible to refresh the page manually in the browser
// If it stops often, add the following line of code to the head in default.ctp:
// <meta http-equiv="Refresh" content="5">
// 5 is the number of seconds before an automatic page refresh and might have to
// be tweaked depending on the performance of the computer running the script

window.onload = function ()
{
	// How many measurements to run for every individual test,
	// i.e. 100, 50, 5, 2, 1 or 0 resources per page
	const MEASUREMENTS_PER_TEST = 500;

	let measurementsPerformed = (localStorage.getItem("measurementsPerformed"))
		? JSON.parse(localStorage.getItem("measurementsPerformed"))
		: { 100:0, 50:0, 5:0, 2:0, 1:0, 0:0 };

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

		download("cakephp_open_subpages.csv", csv);
	}

	/**
	 * Only call immediatly before using "randApp" to prevent different data being
	 * generated for each web application
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
		console.log("100: " + measurementsPerformed[100]);
		console.log("50: " + measurementsPerformed[50]);
		console.log("5: " + measurementsPerformed[5]);
		console.log("2: " + measurementsPerformed[2]);
		console.log("1: " + measurementsPerformed[1]);
		console.log("0: " + measurementsPerformed[0]);
	}

	/**
	 * Opens the specified page if it is not already opened
	 * 
	 * @param {string} url This URL will be opened in the active window/tab
	 * @returns {boolean} Returns "false" if no redirect is needed
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
		let subpages = ["0-9"];
		
		let a = "a".charCodeAt(0);
		let n = "n".charCodeAt(0);

		// Push letters in the range a-n to the array "subpages"
		for (; a <= n; ++a)
		{
			subpages.push(String.fromCharCode(a));
		}

		initRandApp();

		// Choose a random subpage on the "Resources" page by selecting
		// an index from the subpages array.
		let randomSubpage = (localStorage.getItem("randomSubpage"))
			? parseInt(localStorage.getItem("randomSubpage"))
			: randApp.randIntFromIntervall(0, subpages.length - 1);

		localStorage.setItem("randomSubpage", randomSubpage);

		let subpageUrl =
			"http://localhost/Examensarbete/App/CakePHP/resources/view/"
			+ subpages[randomSubpage];

		if ( ! redirect(subpageUrl))
		{
			let results = (localStorage.getItem("results"))
				? JSON.parse(localStorage.getItem("results"))
				: [];
			
			let execTime = document.getElementById("exec-time").innerHTML;

			let activeSubpage = subpages[randomSubpage];

			switch (activeSubpage)
			{
				// 100
				case "b":
				case "h":
					if (measurementsPerformed[100] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[100]++;
						results.push(`${execTime},100`);
					}
					break;

				// 50
				case "c":
				case "i":
					if (measurementsPerformed[50] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[50]++;
						results.push(`${execTime},50`);
					}
					break;

				// 5
				case "d":
				case "k":
					if (measurementsPerformed[5] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[5]++;
						results.push(`${execTime},5`);
					}
					break;

				// 2
				case "f":
				case "l":
					if (measurementsPerformed[2] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[2]++;
						results.push(`${execTime},2`);
					}
					break;

				// 1
				case "g":
				case "m":
					if (measurementsPerformed[1] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[1]++;
						results.push(`${execTime},1`);
					}
					break;

				// 0
				case "0-9":
				case "a":
				case "e":
				case "j":
				case "n":
					if (measurementsPerformed[0] < MEASUREMENTS_PER_TEST)
					{
						measurementsPerformed[0]++;
						results.push(`${execTime},0`);
					}
					break;

				default:
					console.error(`An incorrect subpage has been opened (${activeSubpage})`);
			}

			localStorage.setItem("measurementsPerformed", JSON.stringify(measurementsPerformed));
			localStorage.setItem("results", JSON.stringify(results));

			reset();
			redirect("http://localhost/Examensarbete/App/CakePHP/home");
		}
	}

	/**
	 * Prepare the script for a new run
	 */
	function reset()
	{
		localStorage.removeItem("randomSubpage");
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
