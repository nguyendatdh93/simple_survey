# Download list managerment

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02


## Overview
  
Display all surveys own of operator with status : Published, Closed. Operator only access from secure machine. (a few machine have IP private).

## Table columns
   * Status
     * Published
     * Closed
   * Note
   * Survey name
   * Image
   * Published at
   * Closed at
   * Number answers
   * Controls (Display as button)
      * Go to dowload page.
   
## Functional references : 
  * showDownloadListSurvey 
     
  
        Path : app/Http/Controllers/SurveyController.php
            
## Script references: 
    
    
        Path : resources/views/admin/survey/list/download/script.blade.php
    
## Database table related
* surveys
* answers (For get number answers of survey).
    
## Document reference

   see ![Document](https://docs.google.com/spreadsheets/d/1KZBQCwq3FLdunpxjGNZlLA58ZovPQ_9wuOiBkCXG2Os/edit#gid=1917074744)
