<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems.
// This will help you to shape your own designs and functionality.
// Your analysis of competitor sites should follow an approach that you can decide for yourself.
// Examining each site and evaluating it against a common set of criteria will make it easier for you to draw comparisons between them.
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

// execute the header script:
require_once "header.php";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
	//fotm buttons to display the dsign and analysis fo the 3 webistes
	echo <<<_END
	<form action = "competitors.php" method = "POST">
		<button name = "surveyMonkeyButton" type = "submit"> Survey Monkey </button>
		<button name = "googleFormsButton" type = "submit"> Google Forms </button>
		<button name = "surveyPlanetButton" type = "sbumit"> Survey Planet </button>
	</form>
_END;

//if survey monkey button pressed, only display design and analysis of survey monkey
if(isset($_POST['surveyMonkeyButton']))
{
	echo <<<_END
	<h1> Survey Monkey </h1>
	<div style = "background-color: #a3d9ed">
	<p> Survey Monkey is a website that uses minimal colours to present a modern and sleek looking website which makes it easier for the user to create surveys and use this website as a whole. </p>

	<h2> User account set-up/login process </h2>
	<p> Account set ups can be a long and tedious process, which sometimes could lead to the user leaving the website. However, with SurveyMonkey, this is not the case. The home page is clean and sign up button and log in button is in the middle of the page. This makes it easy for first time users to create accounts as little to no time is spent searching for the sign up/login form. </p>
	<p> Once the button is pressed, the sign up form is displayed with is simple and well presented. With only key information being asked for, users will feel that their information will be secure as they are not sharing anything they would not choose to share such as phone number and pictures of privacy certificate logos are displayed beneath the sign up form for further enforcement of how safe the user’s data will be. As well as this, SurveyMonkey has provided the option to sign in with an account with another provider, for example, clicking on the google mail button will give you an option to sign in with your gmail account. This removes the need to choose usernames and passwords for the SurveyMonkey website. Overall, providing a very seamless and fluid sign up and login process.
	The right side of the page is used solely for displaying a quote which entices you to sign up. </p>

	 <p> The login form follows a very similar form style which the user will be familiar with after signing up.
	The left half of the site displays the form and the right displays an image and quote that again, entices you to log in for a discount. </p>

	<p>  Users do not have to log in each time they visit the website as they can have their usernames and passwords stored for an even easier login process to the website. </p>

	<h2> Layout/survey creation/presentation of surveys </h2>

	<p> Survey creation on this website looks to be effortless as all you need to do is input the survey name and what category it will be. That is all the information needed for a survey to be created. An interesting feature that SurveyMonkey has is that when creating the survey, the user could search for a pre-built survey which they could have been planning to make. This could potentially save time of the user as there would be no need to create a survey from scratch and instead they could use the pre-built survey and edit that one instead. If the user does not know what survey to search for, then they can see the most popular surveys used by other users and select a pre-built one from there. Both of these reduce input errors as survey names and questions are already created for the user. </p>

	<p> After the survey has been created the user can see how the survey will look like when another user is answering the survey. This way, the creator can assess the layout of the questions and if changes are needed to be made, then go back and make them.  As the survey is presented in a clean and minimal manner, it will make It easier for the survey takers to answer the questions. </p>

	<h2> Question types </h2>

	<p>  When creating the questions, the question number is already calculated for you, so there will always be an order to the surveys. The website automatically detects what type of question the user has inputted will be, this seems to be right every time I have tested this which makes the question creation fluid and easy to create. However, you can still change the question type manually if you feel a different type would be more suitable. This is an important feature to have as it allows for users of all survey creation knowledge to create surveys. As the process is the same for each question, the user will become accustomed to how surveys and questions within the survey are created. </p>

	<h2> Ease of use </h2>

	<p> Throughout the website, a consistent colour scheme of primarily white with green accents was used. This allows for a more user friendly experience as no matter where you are on the website, they will all have a similar style that will make you feel familiar with the website. </p>

	<p> A header spreads across all pages of the website which means that there is an ease of navigation. The user will know that if they wish to navigate to another page, all they need to do is scroll up if they have done already and select what they would like from the header. </p>

	<p> An option to change the language, this expands the audience of this website to 15 other languages. This is significantly more than some other websites and allows the user to possible use and communicate with he website in their native tongue. </p>

	<p>Surveys are shown in chronological order, which gives the user an understanding of the timeframe of all the surveys they have created. </p>

	<p> Ability to manage surveys and group surveys and put them into folders. Allows for more order, which is especially useful when dealing with a large number of surveys. <p>

	<h2> Analysis tools </h2>

	<p> Dependant on the question type, different types of questions can be displayed in different manners. If a question type is text then to all answers are viewed as text on the page. </p>

	<p> When the question type is in groups, for example, multiple choice, then visual analysis such as pie charts and bar charts are possible. This website allows for many different types of charts to display the output of the surveys into a visual manner that is easy to read and understand. As well as this, percentages are given too which is useful. </p>

	<p> In addition, charts that display the number of answers with a timeline of when those answers were submitted can be useful when analysing results. </p>
</div>
_END;
}
//if google forms button pressed, only display design and analysis of google forms
if(isset($_POST['googleFormsButton']))
{
	echo <<<_END
<h1> Google Forms </h1>
<div style = "background-color: #eaeda3">
	<p> Google Forms allows you to create forms view responses instantly. </p>

	<h2> User account set-up/login process </h2>

	<p> As this survey website is made by Google, a separate account to sign up/ log in is not required as you are able to log in with a google account. There is a much larger possibility that someone has a google account than a SurveyMonkey account, so this makes it easier for new users of google forms to log in. </p>

	<p> The login process of all google applications is identical or almost identical, therefore, it means if one person is able to log into an application such as YouTube, they would also be able to log into Google Forms.  </p>

	<p> If the user does not have a google account then they will be redirected to create one, although this sign up process asks for more information (such as phone number )than SurveyMonkey , this account can be used for many purposes. </p>

	<h2> Layout/survey creation/presentation of surveys </h2>

	<p> After the user has logged in, options are displayed where the user can choose from the template surveys or create a new survey from scratch. If the user decides to select a template survey, then the survey will open with the questions already inserted. This is ideal for those who have little to no knowledge of survey creation or someone who wants to make a survey in a short amount of time. This would be a good idea to implement into my survey website as I shouldn’t assume all users have the same amount of knowledge for survey creation. </p>

	<p> If the user has chosen to create a survey from scratch, then they will be shown an empty survey with empty boxes. This is where they input information like survey name, survey description and the questions. Personally, I find this method easier to use than the one of Survey Monkey as everything can be inputted altogether, this way, you can see all the questions you have, the survey name and the description and edit all of them if you wish to do so. </p>

	<p> Once the user is happy with the survey they have created, they can press the button ‘Send’ which allows the user to share their created survey to others to gather responses. This Share feature allows users to share the survey through social media platforms such as Facebook, Twitter and Google+ but also through email, URL link and embedded HTML. </p>

	<h2> Question types </h2>

	<p> Google Forms does not have the option of adding a question number to the question, but questions can still be created in the order the user wants them to be displayed in, the question can be inputted in a simple text box. There are a variety of question types that Google Forms have but Survey Monkey does not. For example paragraph, multiple choice grid and tick box grid. Also, each question has the functionality of adding images, titles, sections and video. These question types provide they survey creator to create the survey as they would like it to be. This is important as it ensures the survey creator will get the correct responses for the question. </p>

	<p> Ease of use </p>

	<p> There is a material design throughout Google Forms website that carries onto the form creation page. This provides a consistent user experience which in turn, makes the website more user friendly. Also, the rise in popularity of materialism will only please users as Google Forms looks modern and sleek. </p>

	<p> With this material design, is the ability to give your survey a theme that allows you to customise the header, main theme, and background colour to the materialistic colours provided as well as changing the font. This is essential for user satisfaction as it allows the user to make the survey they have created to look exactly how they would want it to be. </p>

	<p> Another feature is that, Google Forms allows you to insert a custom confirmation message for when a response is recorded. This is particularly useful for when the survey creator wants the user to perform an action after the user completes the survey. </p>

	<p> Survey can be converted into a quiz which provides interactivity between user and the survey. </p>

	<h2> Analysis tools </h2>

	<p> As with SurveyMonkey, Google Forms functions in the same way where if the question type is not a multiple choice, then it will display the answer as a normal text output. When the question type is either Multiple Choice, Drop Down or Checkbox – responses can be viewed in a visual manner, which increases the readability for the survey creator. </p>

<p> Furthermore, Google Forms has the ability to create a spreadsheet and store the responses with the question next to it all with a press of a button. This is extremely helpful as I will be using a similar concept where I store the responses from my surveys into a database. </p>
</div>
_END;
}
//if survey planet button pressed, only display design and analysis of survey planet
if(isset($_POST['surveyPlanetButton']))
{
	echo <<<_END
	<h1> Survey planet </h1>
	<div style = "background-color: Pink">
		<p> A simple survey that allows survey creator to view and share survey results ina diffeent manner to the previous two </p>

		<h2> User account set-up/login process </h2>

		<p> Login process is of the same format as the sign up process, however, before logging in, the user needs to verify the email address that they made the account with. This is another security feature that stops people from creating fake accounts. </p>

		<h2> Question types </h2>

		<p> Sliders, Range, Scale, Scoring are a few of the question types that are available for Survey Planet as well as the standard multiple choice, single answer and checkbox. </p>

		<h2> Layout/survey creation/presentation of surveys </h2>

		<p> Survey planet uses a card style interface when once clicked on + new survey from the header a card pops up where it asks for the survey title, an email and a welcome message.  This website is another example of simple and clean website that focuses more on productivity than being visually appealing. Survey creation is really simple to do, after the survey has been created, a page is displayed where questions can be inserted upon a click of a button. Survey planet also gives template questions to insert into the created survey. ‘Once click to add a new question’ is clicked, the left side of the page has all the question attributes for you to fill in, and on the right is a preview of the question you are making. </p>

		<p> Although creating a question is simple, if the survey creator wants to add more than one question, then they will have to back to the survey planet home page each time. This could be improved by adding another button that allows the user to insert a new question. </p>

		<p> Again, the surveys are presents in a card style as displayed below, this is a modern way to approach survey displaying.  </p>

		<h2> Ease of use </h2>

		<p> Contrasting colours of white and dark purple which complement each other well, and used throughout the website, enabling an easier and more user friendly experience. </p>

		<p> The use of the left hand side of the page for tools such as see results, add question, make active etc.
		Visually pleasing results with animations to look more dynamic than static pie charts. Clickable pie charts too with interactive results. Also able to view the answer for each question and the question itself.
	 </p>

	 <h2> Analysis Tools </h2>

	 <p> The figure below shows the results of a checkbox question that was answered by 4 participants. The pie chart is dynamic and is clickable, and as mentioned before, is colourful and unique from pie charts that I have come across other survey websites.</p>
</div>
_END;
}
//conclusion will be always on page regardless of which/ none of the buttons are pressed
echo <<<_END
<h1> Conclusion </h1>
<p> I have tested and used 3 different websites, that all are designed for the same purpose – to create surveys and allow them to be taken. Survey Monkey was the most all rounded as it had many different question types with a question number that is automatically inserted for the survey creator. With a modern interface and implementation of ‘most popular surveys’ and ‘template surveys’ too. Google Forms performs just like Survey Monkey and creates surveys where responses can be recorded and stored in a spreadsheet, but it’s overall simplicity means that some features had to be left out such as no question numbers and son on. However, Google forms does allow you to insert pictures and videos as well create sections within questions. Survey Planet is out of the three, the most dynamic in terms of the responses and presenting results, as well having many security methods like ‘I am not a robot’ verification and ‘double-data verification’. In my opinion, Survey Monkey provides the best overall functionality and for that reason I would have to say it is the best out of the three. </p>
_END;
}

// finish off the HTML for this page:
require_once "footer.php";
?>
