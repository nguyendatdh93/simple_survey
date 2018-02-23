
# Simple survey project

## Background
    
   The operators implemented some twitter campaign presentations, selecting winners, and sending messages to them.
    Direct Message of twitter, Message content is usually congratulations won + url has form fill out personal information to send gifts to the winner
   * To carry out the personal information gathering stage + to ensure the confidentiality of personal information. Team operation often creates a single form in php (html)
    and send the link to the winner, this personal information after the answer is complete, the system engineer will go directly to the database extracted data, sent to the operation
    ... and many other steps.
   * The above processes cost a lot of team resources + the possibility of high errors + less security ... So the desire to have a solution to solve the problem.

## Expected System Overview :

![Image](https://lh3.googleusercontent.com/5sBMEi75Utn3AVc2Em_To6hN0xfOKiQLW4HOArZtQXv3DHoF5jLEUnS9aQ7Z-rD0p_b5qfCfDZdHtXG7VCY_-yhMkyxpLR_XuIljKOlos_zl_r9mw414dUu-sR6-3ImKWjuy1vx0kQ)


## Survey System Operation Flow :

* Operator								
  * Login to Survey System							
  * Create Survey							
  * Publish Survey							
  * Notify Survey URL to Winner via Twitter Direct Message		
													
* Answers (Users)								
  * Receive Survey URL							
  * Answer Questions							
								
* Data Download								
  * Login to Survey System from Secure Computer							
  * Display all of survey (survey be created by the operator)							
  * Download data of survey	
  
## Survey System Specification

1. **Operator**																
	* Pages and Functions															
	  * Login Page														
	  * Survey List Page														
	  * Create Survey, Edit Survey Page, Save Draft														
	  * Copy Survey Function (copy as a survey)														
	  * Delete Survey Function														
	  * Publish Survey and Close Survey Function																										
	* Specification															
		* Only Allied Architects Employee can use this system(account has domain of company)						
		* User G Suite for authenticate														
		* Add survey name for each survey to users able to understand what survey they do (description for survey)														
		* The system allows operator to upload header image for each survey	(This image will show at top of survey)				
		* About Question in Survey:(The survey can has one or multi question with different modes)						
		    * Text Form (single line or multiple line)												
		    * Radio Button												
			* Checkbox											
		* With earch question in survey, Operator can set required* or optional														
		* Operator could not edit survey if the survey was published														
		* Operator can delete survey (include data in database) after campaign closed downloaded data														
		* Operator can use function "Copy survey" to create a survey same struct (question,title,..)														
		* Survey list will show only themself survey																				
2. **Users**											
	* Pages and Functions										
		* Answer Pages																
	* Specification										
		* Any one can access survey if they got URL (encode URL )									
		* Below message will be displayed if survey finished or deleted <br>									
			このURLは有効期限が過ぎたため表示できません。								
											
3. **Data Download**											
	* Pages and Functions										
		- Login Page									
		- Survey List Page									
		- Survey Data Download Function (only Public, Closed Survey)																	
	* Specification										
		- This function will be used only by Secure Computer (IP address limit)									
		- Authenticate by G Suite									
		- Operation can use only Download Data of Survey List

## Database

  see [Database](https://docs.google.com/spreadsheets/d/1KZBQCwq3FLdunpxjGNZlLA58ZovPQ_9wuOiBkCXG2Os/edit#gid=1208666288)

## Document

  see [Desgin](https://docs.google.com/spreadsheets/d/1KZBQCwq3FLdunpxjGNZlLA58ZovPQ_9wuOiBkCXG2Os/edit#gid=430061643)
  
## Structure source
   ![Structure](https://lh3.googleusercontent.com/i1cA72JZLMBl6ktfLb8Ik_n44O40bAuICy3J0OfDkrV07QXgfZUbYJ3bsEPpigisXq3r-e49r-Z-UTj2RYEj=w1855-h965-rw)
   
   The system based on laravel framework. see [Directory structure](https://laravel.com/docs/5.6/structure#the-root-app-directory) laravel for reference<br>
   
   **Notes :**
   * app/BaseWidget : Contains the core for system (datatable, form,...)
   * atb/admin-template : The package adminlte template
   * app/Http/Services : Contains the task common implementation.
   * app/Http/Validator : Contains the validating.
   * resources/lang : Definded language for system.
   * resources/views/admin : Contains template for admin site (survey list, download list,...)
   * resources/views/admin : Contains template for user site (answer survey site, confirm survey site,...) 
   * .env : Contains the configration for enviroment
        									