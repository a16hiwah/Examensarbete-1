// ==UserScript==
// @name 04 CakePHP - Generate data
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CakePHP/*
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/RandApp/randapp.js
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/ContextFreeLib/js/contextfreegrammar.js
// @grant none
// ==/UserScript==

// Create and add users and resources for the CakePHP web application

// If the script stops, it is possible to refresh the page manually in the browser
// If it stops often, add the following line of code to the head in default.ctp:
// <meta http-equiv="Refresh" content="5">
// 5 is the number of seconds before an automatic page refresh and might have to
// be tweaked depending on the performance of the computer running the script

window.onload = function ()
{
	// How many users to create
	const USERS = 200;

	// How many users to modify, i.e. change profile image and add biography, MAX = USERS
	const MODIFY_USERS = 100;

	// How many resources to create, see file "DATA_DISTRIBUTION" for information about total resources
	const TOTAL_RESOURCES_A_TO_N = 316;

	// How many resources to create per subpage in the range O through Z, see file "DATA_DISTRIBUTION" for information
	const RESOURCES_PER_SUBPAGE_O_TO_Z = 10;

	// How many subpages there are for every test, i.e. Low, medium and high resource content,
	// see file "DATA_DISTRIBUTION" for information
	const SUBPAGES_PER_DATA_VOLUME = 4;

	// How many times in total the script will run
	const TOTAL_RUNS = USERS + MODIFY_USERS + TOTAL_RESOURCES_A_TO_N + RESOURCES_PER_SUBPAGE_O_TO_Z * 12;

	// How many users that have been created
	let usersCreated = (localStorage.getItem("usersCreated"))
		? parseInt(localStorage.getItem("usersCreated"))
		: 0;

	// How many users that have been modified
	let usersModified = (localStorage.getItem("usersModified"))
		? parseInt(localStorage.getItem("usersModified"))
		: 0;
	
	// How many resources that have been created in the range A through N
	let resourcesCreatedAtoN = (localStorage.getItem("resourcesCreatedAtoN"))
		? parseInt(localStorage.getItem("resourcesCreatedAtoN"))
		: 0;

	// How many resources that have been created with a low amount of text
	let resourcesCreatedLow = (localStorage.getItem("resourcesCreatedLow"))
		? parseInt(localStorage.getItem("resourcesCreatedLow"))
		: 0;

	// How many resources that have been created with a medium amount of text
	let resourcesCreatedMedium = (localStorage.getItem("resourcesCreatedMedium"))
		? parseInt(localStorage.getItem("resourcesCreatedMedium"))
		: 0;
	
	// How many resources that have been created with a high amount of text
	let resourcesCreatedHigh = (localStorage.getItem("resourcesCreatedHigh"))
		? parseInt(localStorage.getItem("resourcesCreatedHigh"))
		: 0;

	// How many times the script has been run
	let timesRun = (localStorage.getItem("timesRun"))
		? parseInt(localStorage.getItem("timesRun"))
		: 1;
	
	// All created users with their usernames and passwords; used for signing users into the web application
	let createdUsersData = (localStorage.getItem("createdUsersData"))
		? JSON.parse(localStorage.getItem("createdUsersData"))
		: [];

	let randApp = null;
	let grammar = null;

	if (usersCreated < USERS)
	{
		createUser();
	}
	else if (usersModified < MODIFY_USERS)
	{
		modifyUser();
	}
	else if (resourcesCreatedAtoN < TOTAL_RESOURCES_A_TO_N)
	{
		createResource("low", "a-n");
	}
	else if (resourcesCreatedLow < RESOURCES_PER_SUBPAGE_O_TO_Z * SUBPAGES_PER_DATA_VOLUME)
	{
		createResource("low");
	}
	else if (resourcesCreatedMedium < RESOURCES_PER_SUBPAGE_O_TO_Z * SUBPAGES_PER_DATA_VOLUME)
	{
		createResource("medium");
	}
	else if (resourcesCreatedHigh < RESOURCES_PER_SUBPAGE_O_TO_Z * SUBPAGES_PER_DATA_VOLUME)
	{
		createResource("high");
	}
	else
	{
		console.log("Completed - All data has been added to the CakePHP database");
	}


	/**
	 * Only call immediatly before using "randApp" to prevent different data being
	 * generated for each web application
	 */
	function initRandApp()
	{
		// Object used to generate "random" numbers
		randApp = new RandApp(
			{
				"seed":1,
				"distribution":"uniform",
				"persistentSeed":false
			}
		);
	}

	/**
	 * Only call immediatly before using "grammar" to prevent different data being
	 * generated for each web application
	 */
	function initGrammar()
	{
		// Object used to generate words and scentences
		grammar = new ContextFreeGrammar(
			{
				"probabilityNounPhrase":0.5,
				"probabilityVerbPhrase":0.5,
				"probabilityDualAdjectives":0.5,
				"probabilityStartAdjective":0.5,
				"distributionOfNouns":"uniform",
				"distributionOfVerbs":"uniform",
				"distributionOfAdjectives":"uniform",
				"distributionOfAdverbs":"uniform",
				"distributionOfDeterminers":"uniform",
				"distributionOfConjunctions":"uniform",
				"distributionOfModals":"uniform",
				"randomSeed":1
			}
		);
	}

	/**
	 * Print status on script progress in the browser console
	 */
	function printTimesRun()
	{
		console.log(`Times run: ${timesRun} of ${TOTAL_RUNS}`);
	}

	/**
	 * Update script progress status
	 */
	function updateTimesRun()
	{
		localStorage.setItem("timesRun", timesRun + 1);
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
		let redirectIndex = activePage.search("\\?redirect");

		if (redirectIndex > -1)
		{
			activePage = activePage.substr(0, redirectIndex);
		}

		if (activePage !== url)
		{
			window.open(url, "_self");
			return true;
		}
		return false;
	}

	/**
	 * Creates a user in the database
	 */
	function createUser()
	{
		if( ! redirect("http://localhost/Examensarbete/App/CakePHP/users/add"))
		{
			let username = createUsername();
			let password = createPassword();
	
			document.getElementById("form-username").value = username;
			document.getElementById("form-password").value = password;
			document.getElementById("form-passconf").value = password;
	
			createdUsersData.push([username, password]);
			
			localStorage.setItem("usersCreated", usersCreated + 1);
			localStorage.setItem("createdUsersData", JSON.stringify(createdUsersData));
	
			printTimesRun();
			updateTimesRun();
	
			document.getElementsByName("submit")[0].click();
		}
	}

	/**
	 * Creates a unique username
	 * 
	 * @returns {string} Returns a username
	 */
	function createUsername()
	{
		let username = null;
		let isUnique = false;

		let unavailUsernames = (localStorage.getItem("unavailUsernames"))
			? JSON.parse(localStorage.getItem("unavailUsernames"))
			: [];

		initRandApp();
		initGrammar();
		
		while ( ! isUnique)
		{
			// Used to create different types of usernames
			let randomNum = randApp.randIntFromIntervall(1, 100);

			if (randomNum <= 50)
			{
				username = grammar.generateRandomNoun() + grammar.generateRandomNoun();
			}
			else
			{
				username = grammar.generateRandomNoun() + randApp.randIntFromIntervall(1, 999);
			}

			if ( ! unavailUsernames.includes(username))
			{
				isUnique = true;
				unavailUsernames.push(username);
				localStorage.setItem("unavailUsernames", JSON.stringify(unavailUsernames));
			}
		}

		return username;
	}

	/**
	 * Creates a random password
	 * 
	 * @returns {string} Returns a password
	 */
	function createPassword()
	{
		initRandApp();
		initGrammar();
		
		let password = grammar.generateRandomVerb()
			+ grammar.generateRandomNoun()
			+ randApp.randIntFromIntervall(1, 999);
		
		return password;
	}

	/**
	 * Modifies the profile image and biography of a user
	 */
	function modifyUser()
	{
		// Boolean
		let userModified = (localStorage.getItem("userModified"))
			? parseInt(localStorage.getItem("userModified"))
			: 0;

		// Modify one user and then sign out and change user
		if ( ! userModified)
		{
			if ( ! signIn())
			{
				// Boolean
				let myAccountOpened = (localStorage.getItem("myAccountOpened"))
					? parseInt(localStorage.getItem("myAccountOpened"))
					: 0;

				// Prevent being stuck in a redirect loop when performing
				// more than one redirect in a sequence.
				if ( ! myAccountOpened)
				{
					if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/my-account/overview"))
					{
							localStorage.setItem("myAccountOpened", 1);
							location.reload();
					}
				}
				else
				{
					// Save the URL to the edit-user page
					let editUsrUrl = (localStorage.getItem("editUsrUrl"))
						? JSON.parse(localStorage.getItem("editUsrUrl"))
						: document.getElementById("edit-usr-btn").href;

					localStorage.setItem("editUsrUrl", JSON.stringify(editUsrUrl));
					
					if ( ! redirect(editUsrUrl))
					{
						initRandApp();
						initGrammar();

						document.getElementById("profile-img-2").checked = true;
	
						let numOfSentences = randApp.randIntFromIntervall(1, 5);
							
						let biography = "";
		
						for (let i = 0; i < numOfSentences; i++)
						{
							biography += grammar.generateSentence();
						}
		
						document.getElementById("form-biography").value = biography;
			
						localStorage.setItem("userModified", 1);
						localStorage.setItem("usersModified", usersModified + 1);
			
						printTimesRun();
						updateTimesRun();
			
						document.getElementsByName("submit")[0].click();
					}
				}
			}
		}
		else
		{
			signOut();
		}
	}

	/**
	 * Creates a resource in the database
	 */
	function createResource(dataVolume, range = null)
	{
		// Boolean
		let resourceCreated = (localStorage.getItem("resourceCreated"))
			? parseInt(localStorage.getItem("resourceCreated"))
			: 0;

		// Create one resource and then sign out and change user
		if ( ! resourceCreated)
		{
			if ( ! signIn())
			{
				if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/resources/create-resource"))
				{
					// How many resources should be added to the the different "Resources" subpages
					// The total must equal "RESOURCES"
					let resourcesPerSubpage =
					[
						{ "subpage":"0-9", "amount":0 },
						{ "subpage":"A",   "amount":0 },
						{ "subpage":"B",   "amount":100 },
						{ "subpage":"C",   "amount":50 },
						{ "subpage":"D",   "amount":5 },
						{ "subpage":"E",   "amount":0 },
						{ "subpage":"F",   "amount":2 },
						{ "subpage":"G",   "amount":1 },
						{ "subpage":"H",   "amount":100 },
						{ "subpage":"I",   "amount":50 },
						{ "subpage":"J",   "amount":0 },
						{ "subpage":"K",   "amount":5 },
						{ "subpage":"L",   "amount":2 },
						{ "subpage":"M",   "amount":1 },
						{ "subpage":"N",   "amount":0 },
						{ "subpage":"O",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"P",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"Q",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"R",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"S",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"T",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"U",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"V",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"W",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"X",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"Y",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z },
						{ "subpage":"Z",   "amount":RESOURCES_PER_SUBPAGE_O_TO_Z }
					];

					// Keep track of which subpage the next resource should be added to
					let subpageIndex = (localStorage.getItem("subpageIndex"))
						? parseInt(localStorage.getItem("subpageIndex"))
						: 0;
					
					// How many resources have been created on the page of "subpageIndex"
					let resourcesOnSubpage = (localStorage.getItem("resourcesOnSubpage"))
						? parseInt(localStorage.getItem("resourcesOnSubpage"))
						: 0;

					// When all resources for a subpage have been created, move to the next subpage
					if (resourcesOnSubpage >= resourcesPerSubpage[subpageIndex]["amount"])
					{
						subpageIndex++;

						// If the next subpage should be empty, a new index must be selected
						if (resourcesPerSubpage[subpageIndex]["amount"] === 0)
						{
							let indexIsValid = false;

							while ( ! indexIsValid)
							{
								subpageIndex++;

								if (resourcesPerSubpage[subpageIndex]["amount"] !== 0)
								{
									indexIsValid = true;
								}
							}
						}
						
						localStorage.setItem("subpageIndex", subpageIndex);
						resourcesOnSubpage = 0;
					}

					// The number of paragraphs in a resource
					let paragraphs = null;

					let sentencesPerParagraph = null;

					switch (dataVolume)
					{
						case "low":
							paragraphs = 1;
							sentencesPerParagraph = 1;
							break;

						case "medium":
							paragraphs = 2;
							sentencesPerParagraph = 125;
							break;

						case "high":
							paragraphs = 10;
							sentencesPerParagraph = 100;
							break;

						default:
							console.error(`The variable "dataVolume" has an invalid value.`);
					}

					initGrammar();

					let title =
						resourcesPerSubpage[subpageIndex]["subpage"]
						+ " "
						+ grammar.generateSentence();
					
					let description = grammar.generateSentence();
					let body = "";
	
					for (let i = 0; i < paragraphs; i++)
					{
						for (let j = 0; j < sentencesPerParagraph; j++)
						{
							body += grammar.generateSentence();
						}
	
						if (i !== paragraphs - 1)
						{
							body += "\n\n";
						}
					}
	
					document.getElementById("form-title").value = title;
					document.getElementById("form-description").value = description;
					document.getElementById("form-body").value = body;
	
					localStorage.setItem("resourceCreated", 1);
					localStorage.setItem("resourcesOnSubpage", resourcesOnSubpage + 1);

					if (range !== null)
					{
						localStorage.setItem("resourcesCreatedAtoN", resourcesCreatedAtoN + 1);
					}
					else
					{
						switch (dataVolume)
						{
							case "low":
								localStorage.setItem("resourcesCreatedLow", resourcesCreatedLow + 1);
								break;

							case "medium":
								localStorage.setItem("resourcesCreatedMedium", resourcesCreatedMedium + 1);
								break;

							case "high":
								localStorage.setItem("resourcesCreatedHigh", resourcesCreatedHigh + 1);
								break;

							default:
								console.error(`The variable "dataVolume" has an invalid value.`);
						}
					}
	
					printTimesRun();
					updateTimesRun();
	
					document.getElementsByName("submit")[0].click();
				}
			}
		}
		else
		{
			signOut();
		}
	}

	/**
	 * Automatically selects the next user to sign in when no user is signed in
	 * 
	 * @return {boolean} Returns "false" when no sign in is needed
	 */
	function signIn()
	{
		// Keep track of sign in status
		let signedIn = (localStorage.getItem("signedIn"))
			? parseInt(localStorage.getItem("signedIn"))
			: 0;

		if ( ! signedIn)
		{
			if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/users/login"))
			{
				// Keep track of the user account that should be used for creating
				// resources
				let userIndex = (localStorage.getItem("userIndex"))
					? parseInt(localStorage.getItem("userIndex"))
					: 0;

				// Reset index and start over when it becomes invalid
				if (userIndex >= createdUsersData.length)
				{
					userIndex = 0;
				}

				let username = createdUsersData[userIndex][0];
				let password = createdUsersData[userIndex][1];

				document.getElementById("form-username").value = username;
				document.getElementById("form-password").value = password;

				localStorage.setItem("signedIn", 1);
				localStorage.setItem("userIndex", userIndex + 1);

				document.getElementsByName("submit")[0].click();
				return true;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Signs out the current user and resets necessary data to prepare for the next run
	 */
	function signOut()
	{
		localStorage.setItem("signedIn", 0);
		localStorage.setItem("userModified", 0);
		localStorage.removeItem("editUsrUrl");
		localStorage.setItem("resourceCreated", 0);
		localStorage.setItem("myAccountOpened", 0);

		redirect("http://localhost/Examensarbete/App/CakePHP/users/logout");
	}
};
