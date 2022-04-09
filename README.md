# Orange Digital Center Backend 5 Days Hackathon
- Our task was to create restful APIs for backend of ODC 
- this my first time working with restful APIs, it was quite easy & powerful as you will just write the code with any language then it can be used in any
place .. Wow 
- I finished this projet in 10H with quite number of feature, it was so great experience 
# Features Of Project:
## Admin Panel :
- admin login
- admin logout
    - if admin logged out, all other functionalities in admin panel  
    wont work until admin log in
- add subadmins [can view data only cannot add or delete or edit]
- view all students in the system
- view a specific student
- add a new course data
- edit data of existing course
- add question [msq question] for specifc exam [each exam is for one course]
- delete a specific question 
- view all courses in the system
- view specific course
- send exam code :
	- check if entered student id and course id exists
	- check if code is already sent
	- send code to email 
	- this feature is only for admin [not subadmin]
 - this code is : 
	- unique
	- used one time [you can have the exam only one time]
	- expired after two days of admin sending code date
- send interview email :
	- check if entered student id and course id exist
	- check if interview email is already sent
	- send details of interview to email of student
                
- show exams result for all student in a specific course sorted with highest degree
- view student & course enrollment [each user and corrsponding course]


## Student:

- take an exam for specific course :
	- check if user has taken exam before or not
	- check if entered code is wrong
	- check if code is valid [not expired]
	- now all 15 random questions will be shown to user
	- take answer of user for 15 msq questions
	- count number of right answer
	- output total number of questions , total number of right answer
- student can view his profile 
- student can edit his profile 
- student can enroll in a course [not enrolled in previously]
- generate random questions for exam :
	- 15 msq random questions from all questions for a specific course 
- logout :
	- if user logged out, all other functionalities in student panel wont work until student sign in
- student logs in using otp 
- otp : 
	- used only time only
	- is unique
	- expired after 5 minutes
- sign in page
        - check if account is not verified
        - check if both username and password are wrong
        - check is username is correct but password is wrong
        - check if email [user] does not exists
- sign up page
	- password must be strong [validation]
	- Email enterd by user must be valid [@XYZ.ABC] [validation]
	- check if Email already exists
	- passwrod is hashed
- forget your password page
	- a token is send to the entered email
	- check if email does not exists
- change your password page [after forget your password request]
	- check if token is not valid
	- check if email does not exists
	- send an email to user to infrom him that his password has been changed

- student can view running courses
- student can view history courses
- student can view courses he is not enrolled in
- student can view courses he is enrolled in [where code with 'pending status' text or code if it is sent by admin]
