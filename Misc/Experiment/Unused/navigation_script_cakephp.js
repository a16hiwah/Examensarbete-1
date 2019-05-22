// ==UserScript==
// @name CakePHP - Navigation
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CakePHP/resources*
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/RandApp/randapp.js
// @grant none
// ==/UserScript==

// Opens a random subpage followed by a random resource.
// Response times are saved to a file from PHP when combined with "measure_php_exec_time.php"
window.onload = function ()
{
	/** How many measurements to run */
	const MEASUREMENTS = 100;

	/** How many times in total the script will run */
	const TOTAL_RUNS = MEASUREMENTS;

	/** How many times the script has been run */
	let times_run = (localStorage.getItem("times_run"))
		? parseInt(localStorage.getItem("times_run"))
		: 1;
		
	let randApp = null;

	if (times_run < MEASUREMENTS)
	{
		printTimesRun();
		updateTimesRun();
		openNextPage();
	}
	else
	{
		console.log("Navigation complete");
	}

	/**
	 * Only assign an object to "randApp" before it is actually used by calling
	 * this function to prevent different navigation sequences in the web
	 * applications.
	 */
	function initRandApp()
	{
		/** Object used to generate "random" numbers */
		randApp = new RandApp(
			{
				"seed":1,
				"distribution":"uniform",
				"persistentSeed":false
			}
		);
	}

	/** Print status on script progress in the browser console */
	function printTimesRun()
	{
		console.log(`Times run: ${times_run} of ${TOTAL_RUNS}`);
	}

	/** Update script progress status */
	function updateTimesRun()
	{
		localStorage.setItem("times_run", times_run + 1);
	}

	/**
	 * Opens the specified page if it is not already opened.
	 * Returns "false" if no redirect is needed.
	 */
	function redirect(url)
	{
		let active_page = window.location.href;

		if (active_page !== url)
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
		initRandApp();

		/** All subpages on the "Resources" page */
		let subpages = ["0-9"];
		
		let a = "a".charCodeAt(0);
		let z = "z".charCodeAt(0);

		/** Push letters in the range a-z to the array "subpages" */
		for (; a <= z; ++a)
		{
			subpages.push(String.fromCharCode(a));
		}

		/** Subpages on the "Resources" page without any resources */
		let empty_subpages = (localStorage.getItem("empty_subpages"))
			? JSON.parse(localStorage.getItem("empty_subpages"))
			: [];

		/**
		 * Choose a "random" subpage on the "Resources" page by selecting
		 * an index from the subpages array.
		 */
		let random_subpage = (localStorage.getItem("random_subpage"))
			? parseInt(localStorage.getItem("random_subpage"))
			: randApp.randIntFromIntervall(0, subpages.length - 1);

		/** Only subpages with resources are valid */
		let indexIsValid = false;

		while ( ! indexIsValid)
		{
			if ( ! empty_subpages.includes(random_subpage))
			{
				indexIsValid = true;
			}
			else
			{
				random_subpage = randApp.randIntFromIntervall(0, subpages.length - 1);
			}
		}
		
		localStorage.setItem("random_subpage", random_subpage);

		let subpage_url =
			"http://localhost/Examensarbete/App/CakePHP/resources/view/"
			+ subpages[random_subpage];

		let subpage_opened = (localStorage.getItem("subpage_opened"))
			? parseInt(localStorage.getItem("subpage_opened"))
			: 0;

		if ( ! subpage_opened)
		{
			if ( ! redirect(subpage_url))
			{
				/**
				 * If there are no resources on the selected subpage,
				 * a new subpage must be chosen.
				 */
				if (document.querySelectorAll('td > a').length === 0)
				{
					localStorage.removeItem("random_subpage");
					empty_subpages.push(random_subpage);
					localStorage.setItem("empty_subpages", JSON.stringify(empty_subpages));
					location.reload();
				}
				else
				{
					localStorage.setItem("subpage_opened", 1);
					location.reload();
				}
			}
		}
		else
		{
			let active_page = window.location.href;

			if (active_page.search("open") > -1)
			{
				/** Go back to "Resources" page */
				redirect("http://localhost/Examensarbete/App/CakePHP/resources/view/a");
			}
			else
			{
				/** All resources on the current subpage */
				let resources = document.querySelectorAll('td > a');

				/** The resource that should be opened */
				let random_resource = randApp.randIntFromIntervall(0, resources.length - 1);

				reset();

				/**
				 * Clicking on the resource will open it and cause the script to
				 * execute from the beginning again.
				 */
				resources[random_resource].click();
			}
		}
	}

	/** Prepare the script for a new run */
	function reset()
	{
		localStorage.removeItem("random_subpage");
		localStorage.setItem("subpage_opened", 0);
	}
};
