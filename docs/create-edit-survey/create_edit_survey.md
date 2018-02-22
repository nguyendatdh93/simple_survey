#Create/edit survey

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02


##Overview
The survey set consists of 4 parts : 
   * Survey note : Operators maybe set the note for easy searching
   * Survey header : Defind some basic info of survey (survey name, image, description).
   * Survey content : Contain all questions of survey. Survey will has 4 mode :
     * Single line (Input).
     * Multi line (Textarea).
     * Single choice (Radio button).
     * Multi choices (Checkbox).
   * Survey footer : Contains all agreement of survey.

##Logic edit survey

  * Only allow surveys have status : Draft, published.
  * For survey as published : 
      * All input will be disable.
      * Copy URL will show.
      * Can close survey.
  * For survey as draft : 
      * Can save survey "Draft" or "Publish"
          
##Functional references :
  * save
       
  
        Path : app/Http/Controllers/SurveyController.php     
       
  * createOrUpdateSurvey : Create survey or update survey
           
  
        Path : app/Http/Controllers/SurveyController.php
  
  * createQuestions : Save questions of survey
             
  
        Path : app/Http/Controllers/SurveyController.php
        
  * edit : Edit survey
               
    
          Path : app/Http/Controllers/SurveyController.php
    
## Script references: 
    Path : resources/views/admin/survey/list/edit/script.blade.php
    
##Database table related:
  * surveys
  * questions
  * question_choices
  * confirm_contents