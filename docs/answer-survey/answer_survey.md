# Answer survey

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02

## Overview

Logic for answer survey.

Answer survey => Confirm answer survey => Thanks page.
 
- URL to be encrypt by id.
- A user could answer many time/survey.
- if survey finished or deleted that will be show message :
        このURLは有効期限が過ぎたため表示できません。

## Functional references : 

* showQuestionSurvey : Show form answer survey.
        
        
        
        Path : app/Http/Controllers/AnswerSurveyController.php
    
* answerSurvey : Get the answer data to display on the confirm form

    
        Path : app/Http/Controllers/AnswerSurveyController.php
    
* showFormConfirmAnswerSurvey : show form confirm answer.
    

        Path : app/Http/Controllers/AnswerSurveyController.php
    
* showThankPage 
    
        
        Path : app/Http/Controllers/AnswerSurveyController.php
    
## Script references : 
    
    
    Path : resources/views/user/survey/answer/fill.blade.php
    
## Database table references :
- answers
- answer_questions
 