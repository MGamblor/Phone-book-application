# Phone-Book-Application
CRUD Application (HTML5, CSS3, jQuery, PHP, SQL, Bootstrap)

## Installation
1) Import database located in the SQL file named 'cintact_list' to your DBMS
2) Update the database connection settings in 'config.php' to connect with the database
3) Load the site

## Features

*	The contact list includes fields displayed in order of Avatar, First Name, Last Name, Contact Number and Email.
*	The contact list on small screens such as phones will only display the Avatar, First Name and Last Name to prevent the need to scroll a lot.  
*	Users can View/Edit/Delete and Add new contacts.
* The ‘Add Contact’ button to be displayed top right of screen for desktop and in the drop down menu for mobile devices.
*	Contacts to have pictures (Avatar) with size of thumbnails.
*	Search bar will be in the top left corner and filter results by first names that begin with the users input. 
*	Pagination will be utilised to browse through large contact list.
*	Site to be clean, professional, modern and with clear navigations. Breadcrumbs links to be displayed above the contact list table to help users move around the application with ease.
*	Error/help messages to support input validation.
*	Success messages shown when editing, deleting or creating a contact.

## Constraints

*	Page to display 10 contacts maximum at any time. 
*	The database is checked for existing data and response given accordingly (no duplicates).
*	Prevent progress to next page if any required field is left empty.
*	Action buttons will only display appropriate glyphicon images on mobile devices.
*	Application of session management, authentication, security and sanitisation of user input.
*	Validation for input fields (When adding or editing contact details).
      * First Name is mandatory and must contain more than 3 letters and have no special characters
      * Middle name must have no special characters.
      * Last Name is mandatory and must contain more than 3 letters have no special characters
      * Email address is mandatory and must be valid
      * A contact number is mandatory and must be 10 digits long
