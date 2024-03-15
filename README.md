## Final Assignment's Video:
https://drive.google.com/file/d/1emE8F2klzVQ4yvMnjxiXxj5IFqaxFNwv/view?usp=drivesdk

## Project Setup

- Clone/download the project on your system
- Run `composer install`
- Create `.env` file from `.env.example`
- Run `php artisan key:generate`
- Configure database credentials
- Configure mail settings
- Create `JWT_SECRET` key in `.env` file
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `php artisan serve`. This will run the project on `localhost:8000`

## Superuser Credentials

Once you've completed the project setup and ran migration and seeding, 3 superuser accounts have been created,

###### Site Admin
- email - admin@jobspulse.com
- password - 123
###### Site Manager
- email - manager@jobspulse.com
- password - 123
###### Site Editor
- email - editor@jobspulse.com
- password - 123

You can now log into these accounts from this url - `localhost:8000/jobs-pulse/admin/login`
Each superuser has different roles and permissions which is managed by Laravel policies

## Login & Registration

#### Company/Employeer
###### For creating a company/employer amount
- Click on Register on the navigation bar
- Now click on the Company Register button
- Fill up the registration form and submit. This will create a company and an Admin profile.

A 6 digit OTP code, which expires in 5 minutes, would be sent to the registered email using the mail configuration. The admin has to verify his email using this OTP code. Once verified he can then access the company user dashboard.
Initially the job posting and other features would be unavailable until a superuser with Site Admin or Site Manager role approves the company. Once approved the admin can post jobs, select/reject applications and request for available plugins.

###### To login
- Simply click on Login on the navigation bar
- Then click on the Company Login button
- Enter your credentials and submit.

#### Candidate
###### For creating a candidate profile
- Click on Register on the navigation bar
- Now click on the Candidate Register button
- Fill up the registration form and submit. This will create a candidate profile for the user.

A 6 digit OTP code, which expires in 5 minutes, would be sent to the registered email using the mail configuration. The user has to verify his email using this OTP code. Once verified he can then access the candidate dashboard.
Initially the candidate won't be able to apply for jobs until he sets up his candidate profile from the dashboard. Once setup he can then start applying for jobs.

###### To login
- Simply click on Login on the navigation bar
- Then click on the Candidate Login button
- Enter your credentials and submit.

## Job Posting
Once a company is approved, the Jobs tab will become available on the company's dashboard. From this tab the company can manage it's jobs. They can post jobs, view jobs they've posted, edit jobs and update availability of the jobs which have been approved.

[![Alt text](https://img.youtube.com/vi/ke8E9P6Y_z4/0.jpg)](https://www.youtube.com/watch?v=ke8E9P6Y_z4)

## Managing Job Applications
To manage job applications, on the company dashboard, navigate to the Applications tab. On this tab a company can view all approved jobs and their respective applications. From this tab they can view applicants profile, select applicants for interview and reject applications.

[![Alt text](https://img.youtube.com/vi/6ugu_jDYNO4/0.jpg)](https://www.youtube.com/watch?v=6ugu_jDYNO4)

## Applying For Jobs
Candidates can apply for jobs once they've finished their profile setup. To apply simply open the job you want to apply to and click on the Apply button. The candidates can view all the jobs they've applied to on their dashboard along with the status of the applications.

<img src="Screenshot 2024-03-16 015729.png" alt="drawing" width="300"/>
<img src="Screenshot 2024-03-16 015521.png" alt="drawing" width="300"/>

## Candidate Dashboard
The Candidate dashboard is a fairly simple one. It contains 3 tabs as well as the profile information page.
#### Dashboard Tab
On the dashboard tab an overview of the candidate's activity on the site is displayed.
I.e. - number of jobs applied, number of selected/rejected applications & number of saved jobs.

#### Job Applications Tab
On the job application tab a candidate can view all the jobs he has applied to along with the status of the applications. The candidate can also delete the applications that are still on "PENDING" phase.

<img src="Screenshot 2024-03-16 015521.png" alt="drawing" width="300"/>

#### Saved Jobs Tab
On this tab the candidate's saved jobs are displayed. The candidate can delete jobs from his saved list or he can choose to clear his saved jobs list.

## Company Dashboard
Initially company dashboard has 5 tabs,
- Dashboard
- Company
- Jobs
- Applications
- Plugins

Later if the company wishes they can request Employee and/or Blog plugins from the Plugins tab. If the requests are accepted the Employees and Blogs tab will become available.

#### Dashboard Tab
On the company's dashboard tab some basic information/overview of the company are displayed.

#### Company Tab
Information of the company is displayed on this tab. Only admins can update the company's information, for other employees the information are read only.
If the company gets restricted, the restriction feedback/reason will be displayed at the bottom of the page.

#### Jobs Tab
A company can manage it's jobs from this tab.
Company user with editor role can only view and update existing jobs. While company users with manager or admin role can view, update, post jobs as well as change availabilities of jobs.

[![Alt text](https://img.youtube.com/vi/1jg6xXxxtgM/0.jpg)](https://www.youtube.com/watch?v=1jg6xXxxtgM)

#### Applications Tab
All the applications received for jobs posted by a company can be managed from this tab. Only company users with admin and manager roles can access this tab. The authorized user can
- View all of the applications on a job
- View candidate information
- Select candidate for interview
- Reject applications

[![Alt text](https://img.youtube.com/vi/6ugu_jDYNO4/0.jpg)](https://www.youtube.com/watch?v=6ugu_jDYNO4)

#### Plugins Tab
This tab is only accessible to admins. From this tab, admins can request plugins as well as view the status for the requested plugins. Once a plugin is requested it is initially admitted to the "PENDING" phase. If a authorized superuser approves the request the plugin is then made available to the company.

#### Employees Tab
This tab is activated once the employee plugin is approved. On this tab only admins can
- create employees
- manage employee roles
- delete employees

Other company users can only view employee information and roles.

#### Blogs Tab
The Blogs tab is only available if the blog plugin is activated. There are two sub tabs available on this tab, "My Blogs" & "All Blogs".
On "My Blogs" tab users can post, update and delete their own blogs.
On "All Blogs" tab, all of the blogs posted by the employees of the company are displayed. The admin has authority to delete any blog posted under the company from this sub tab. 
