# Download answer survey

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02


## Overview
  
- Display all questions and answers of survey.<br>
- Operator can download answers as CSV file 
- Operator can clear data of survey when downloaded at least once time.
- For survey published : 
  * Disable all 2 buttons : "Download CSV" and "Clear data".
- For survey closed : 
  * Disable button "Clear data" if the previous operator didn't download the answer data of survey  
   
## Functional references : 
  * showDownloadPageSurveyBySurveyId 
    
    
            Path : app/Http/Controllers/SurveyController.php
    
## Script references: 
    
    
        Path : resources/views/admin/survey/list/answer/script.blade.php
        
## Database table related
* surveys
* answers (For get number answers of survey).
* questions (Get all survey's question to display as table header)
* answers_question
* question_choices
    
