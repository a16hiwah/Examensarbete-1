// ==UserScript==
// @name CakePHP - Generate data
// @namespace Violentmonkey Scripts
// @match http://localhost/Examensarbete/App/CakePHP/*
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/RandApp/randapp.js
// @require http://localhost/Examensarbete/Database/Generate_data/Libraries/ContextFreeLib/js/contextfreegrammar.js
// @grant none
// ==/UserScript==

/** Create and add users, resources and comments for the CakePHP web application */
window.onload = function ()
{
	/** How many users to add */
	const USERS = 100;

	/** How many resources to add */
	const RESOURCES = 100;

	/** How many comments to add */
	const COMMENTS = 100;

	/** How many times in total the script will run */
	const TOTAL_RUNS = USERS + RESOURCES + COMMENTS + Math.trunc(USERS / 2);

	/** When set to false, resources and comments will consist of more text */
	const SMALL_DATASET = true;

	/** How many users that have been added */
	let users_added = (localStorage.getItem("users_added"))
		? parseInt(localStorage.getItem("users_added"))
		: 0;

	/** How many users that have been modified */
	let users_modified = (localStorage.getItem("users_modified"))
		? parseInt(localStorage.getItem("users_modified"))
		: 0;
	
	/** How many resources that have been added */
	let resources_added = (localStorage.getItem("resources_added"))
		? parseInt(localStorage.getItem("resources_added"))
		: 0;

	/** How many comments that have been added */
	let comments_added = (localStorage.getItem("comments_added"))
		? parseInt(localStorage.getItem("comments_added"))
		: 0;

	/** How many times the script has been run */
	let times_run = (localStorage.getItem("times_run"))
		? parseInt(localStorage.getItem("times_run"))
		: 1;
	
	/** All created users with their usernames and passwords */
	let created_users_data = (localStorage.getItem("created_users_data"))
		? JSON.parse(localStorage.getItem("created_users_data"))
		: [];

	let randApp = null;
	let grammar = null;

	/** Create all data */
	if (users_added < USERS)
	{
		createUser();
	}
	else if (users_modified < USERS / 2)
	{
		modifyUser();
	}
	else if (resources_added < RESOURCES)
	{
		createResource();
	}
	else if (comments_added < COMMENTS)
	{
		createComment();
	}
	else
	{
		console.log("Completed - All data has been added to the CodeIgniter database");
	}


	/** HELPER FUNCTIONS */

	/**
	 * Only assign objects to "randApp" and "grammar" before they are actually
	 * used by calling this function to prevent different data being generated
	 * for both web applications.
	 */
	function initDataGen()
	{
		/** Object used to generate "random" numbers */
		randApp = new RandApp(
			{
				"seed":1,
				"distribution":"uniform",
				"persistentSeed":false
			}
		);
			
		/** Object used to generate words and scentences */
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

	/** Print status on script progress in the browser console */
	function printTimesRun()
	{
		console.log(`Times run: ${times_run} of ${TOTAL_RUNS}`);
		localStorage.setItem("times_run", times_run + 1);
	}

	/**
	 * Opens the specified page if it is not already opened.
	 * Returns "false" if no redirect is needed.
	 */
	function redirect(url)
	{
		let active_page = window.location.href;
		let redirect_index = active_page.search("\\?redirect");

		if (redirect_index > -1)
		{
			active_page = active_page.substr(0, redirect_index);
		}

		if (active_page !== url)
		{
			window.open(url, "_self");
			return true;
		}
		return false;
	}

	/** Creates a user in the database */
	function createUser()
	{
		if( ! redirect("http://localhost/Examensarbete/App/CakePHP/users/add"))
		{
			let username = createUsername();
			let password = createPassword();
	
			document.getElementById("form-username").value = username;
			document.getElementById("form-password").value = password;
			document.getElementById("form-passconf").value = password;
	
			created_users_data.push([username, password]);
			
			localStorage.setItem("users_added", users_added + 1);
			localStorage.setItem("created_users_data", JSON.stringify(created_users_data));
	
			printTimesRun();
	
			document.getElementsByName("submit")[0].click();
		}
	}

	/** Returns a unique username */
	function createUsername()
	{
		initDataGen();

		let username = null;
		let is_unique = false;

		let unavail_usernames = (localStorage.getItem("unavail_usernames"))
			? JSON.parse(localStorage.getItem("unavail_usernames"))
			: [];

		while ( ! is_unique)
		{
			/** Used to create different types of usernames */
			let random_num = randApp.randIntFromIntervall(1, 100);

			if (random_num <= 50)
			{
				username = grammar.generateRandomNoun() + grammar.generateRandomNoun();
			}
			else
			{
				username = grammar.generateRandomNoun() + randApp.randIntFromIntervall(1, 999);
			}

			if ( ! unavail_usernames.includes(username))
			{
				is_unique = true;
				unavail_usernames.push(username);
				localStorage.setItem("unavail_usernames", JSON.stringify(unavail_usernames));
			}
		}

		return username;
	}

	/** Returns a random password */
	function createPassword()
	{
		initDataGen();

		let password = grammar.generateRandomVerb()
			+ grammar.generateRandomNoun()
			+ randApp.randIntFromIntervall(1, 999);
		
		return password;
	}

	/** Modifies the profile image and biography of a user */
	function modifyUser()
	{
		let user_modified = (localStorage.getItem("user_modified"))
			? parseInt(localStorage.getItem("user_modified"))
			: 0;

		/**
		 * Modify one user and then sign out and change user
		 */
		if ( ! user_modified)
		{
			if ( ! signIn())
			{
				let my_account_opened = (localStorage.getItem("my_account_opened"))
					? parseInt(localStorage.getItem("my_account_opened"))
					: 0;

				/**
				 * Prevent being stuck in a redirect loop when performing
				 * more than one redirect in a sequence.
				 */
				if ( ! my_account_opened)
				{
					if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/my-account"))
					{
							localStorage.setItem("my_account_opened", 1);
							location.reload();
					}
				}
				else
				{
					/** Save the URL for the selected resource */
					let edit_usr_url = (localStorage.getItem("edit_usr_url"))
						? JSON.parse(localStorage.getItem("edit_usr_url"))
						: document.getElementById("edit-usr-btn").href;

					localStorage.setItem("edit_usr_url", JSON.stringify(edit_usr_url));
					
					if ( ! redirect(edit_usr_url))
					{
						initDataGen();

						document.getElementById("profile-img-2").checked = true;
	
						let num_of_sentences = randApp.randIntFromIntervall(1, 5);
							
						let biography = "";
		
						for (let i = 0; i < num_of_sentences; i++)
						{
							biography += grammar.generateSentence();
						}
		
						document.getElementById("form-biography").value = biography;
			
						localStorage.setItem("user_modified", 1);
						localStorage.setItem("users_modified", users_modified + 1);
			
						printTimesRun();
			
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

	/** Creates a resource in the database */
	function createResource()
	{
		let resource_created = (localStorage.getItem("resource_created"))
			? parseInt(localStorage.getItem("resource_created"))
			: 0;

		/**
		 * Create one resource and then sign out and change user
		 */
		if ( ! resource_created)
		{
			if ( ! signIn())
			{
				if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/resources/create-resource"))
				{
					initDataGen();

					let num_of_paragraphs = (SMALL_DATASET)
						? randApp.randIntFromIntervall(1, 4)
						: randApp.randIntFromIntervall(10, 40);
	
					let title = grammar.generateSentence();
					let description = grammar.generateSentence();
					let body = "";
	
					for (let i = 0; i < num_of_paragraphs; i++)
					{
						let num_of_sentences = (SMALL_DATASET)
							? randApp.randIntFromIntervall(10, 50)
							: randApp.randIntFromIntervall(100, 500);
	
						for (let j = 0; j < num_of_sentences; j++)
						{
							body += grammar.generateSentence();
						}
	
						if (i !== num_of_paragraphs - 1)
						{
							body += "\n\n";
						}
					}
	
					document.getElementById("form-title").value = title;
					document.getElementById("form-description").value = description;
					document.getElementById("form-body").value = body;
	
					localStorage.setItem("resource_created", 1);
					localStorage.setItem("resources_added", resources_added + 1);
	
					printTimesRun();
	
					document.getElementsByName("submit")[0].click();
				}
			}
		}
		else
		{
			signOut();
		}
	}

	/** Creates a comment in the database */
	function createComment()
	{
		let comment_created = (localStorage.getItem("comment_created"))
			? parseInt(localStorage.getItem("comment_created"))
			: 0;

		/**
		 * Create one comment and then sign out and change user
		 */
		if ( ! comment_created)
		{
			if ( ! signIn())
			{
				initDataGen();

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

				/**
				 * Prevent being stuck in a redirect loop when performing
				 * more than one redirect in a sequence.
				 */
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
					/** Get the elements for all resources */
					let resources = document.querySelectorAll('td > a');

					/** Select a "random" element */
					let random_resource = randApp.randIntFromIntervall(0, resources.length - 1);

					/** Save the URL for the selected resource */
					let resource_url = (localStorage.getItem("resource_url"))
						? JSON.parse(localStorage.getItem("resource_url"))
						: resources[random_resource].href;

					localStorage.setItem("resource_url", JSON.stringify(resource_url));

					if ( ! redirect(resource_url))
					{
						let num_of_sentences = (SMALL_DATASET)
							? randApp.randIntFromIntervall(1, 5)
							: randApp.randIntFromIntervall(10, 50);
							
						let comment = "";

						for (let i = 0; i < num_of_sentences; i++)
						{
							comment += grammar.generateSentence();
						}

						document.getElementById("form-comment").value = comment;
			
						localStorage.setItem("comment_created", 1);
						localStorage.setItem("comments_added", comments_added + 1);
			
						printTimesRun();
			
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
	 * Automatically selects the next user to sign in when no user is signed in.
	 * Returns "false" when no sign in is needed.
	 */
	function signIn()
	{
		/** Keep track of sign in status */
		let signed_in = (localStorage.getItem("signed_in"))
			? parseInt(localStorage.getItem("signed_in"))
			: 0;

		if ( ! signed_in)
		{
			if ( ! redirect("http://localhost/Examensarbete/App/CakePHP/users/login"))
			{
				/** Keep track of the user account that should be used for creating resources or comments */
				let user_index = (localStorage.getItem("user_index"))
				? parseInt(localStorage.getItem("user_index"))
				: 0;

				/** Reset index and start over when it becomes invalid */
				if (user_index >= created_users_data.length)
				{
					user_index = 0;
				}

				let username = created_users_data[user_index][0];
				let password = created_users_data[user_index][1];

				document.getElementById("form-username").value = username;
				document.getElementById("form-password").value = password;

				localStorage.setItem("signed_in", 1);
				localStorage.setItem("user_index", user_index + 1);

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
	 * Signs out the current user and resets necessary data to prepare for the
	 * next run.
	 */
	function signOut()
	{
		localStorage.setItem("signed_in", 0);
		localStorage.setItem("user_modified", 0);
		localStorage.setItem("my_account_opened", 0);
		localStorage.setItem("resource_created", 0);
		localStorage.setItem("comment_created", 0);
		localStorage.setItem("subpage_opened", 0);

		localStorage.removeItem("edit_usr_url");
		localStorage.removeItem("random_subpage");
		localStorage.removeItem("resource_url");
		
		redirect("http://localhost/Examensarbete/App/CakePHP/users/logout");
	}
};
