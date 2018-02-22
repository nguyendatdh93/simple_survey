# Survey list

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02

## Overview
  
Display all surveys are own of operator. Operator only access from nomarl machine (not private machine).

## Table columns
   * Status
     * Draft
     * Published
     * Closed
     * Deleted (Survey was cleared data)
   * Note
   * Survey name
   * Image
   * Published at
   * Closed at
   * Number answers
   * Controls (display button)
      * Duplicate survey.
      * Edit survey (Only allow with Draft or Published).
   
## Functional references : 
  * showListSurvey 
     
  
        Path : app/Http/Controllers/SurveyController.php
            
## Script references: 
    
    
        Path : resources/views/admin/survey/list/survey/script.blade.php
    
## Database table related
* surveys
* answers (For get number answers of survey).
    
