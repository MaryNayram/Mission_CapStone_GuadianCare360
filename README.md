GuardianCare360  
Author: Mary Doh  
Organisation: GuardianCare360
Date Created: 3/10/2025  

Introduction  
GuardianCare360 is a secure, scalable web-based platform designed to deliver cybersecurity training and task management for healthcare professionals in Ghana. It empowers administrators and staff with tools to learn, manage, and stay informed through a clean, intuitive dashboard.  

This README provides a complete guide to setting up, running, and deploying GuardianCare360 locally. It ensures a seamless experience for both training and operational workflows.  

Scope  
GuardianCare360 serves two core functions. First, it delivers interactive cybersecurity training modules tailored for healthcare staff in Ghana to build awareness and resilience against cyber threats. Second, it provides a task and notification system with role-aware dashboards for administrators and employees. This system streamlines task workflows, tracks progress, and sends real-time alerts.  

System Overview  
The platform is structured into four key layers. The frontend is built with HTML5, CSS, and JavaScript to provide a responsive user experience. The backend, powered by PHP, handles core logic such as registration, login, course access, task workflows, and notification delivery. MySQL is used as the database to store and manage user data, course modules, task records, and notification logs. Hosting is done locally via XAMPP, using Apache and PHP to simulate a real-time server environment for development and testing.  

Core Features  

Cybersecurity Training  
Users can register with their name, email, password, and organization. Secure login grants access to course modules and dashboards. Logout ends the session and redirects to the login page. Staff can browse available modules and access multimedia training content. Administrators can create, update, and delete course content.  

Task Management  
The system supports role-based dashboards for admins and employees. Admins can create, assign, update, and delete tasks with full visibility. Smart filtering allows sorting tasks by priority, status, and deadline. Role-based authentication ensures secure login. Real-time notifications alert users to new tasks, updates, and broadcasts. Deadline tracking highlights overdue tasks and upcoming deadlines. The system supports both global announcements and user-specific alerts.  

Tech Stack  
GuardianCare360 is built using PHP version 7.4 or higher, MySQL version 5.7 or higher, Bootstrap, Font Awesome, HTML5, CSS, and JavaScript. It runs locally using XAMPP, which includes Apache, PHP, and MySQL.  

Installation Instructions  
To install GuardianCare360, follow these steps:  
Clone the repository using the command:  
git clone https://github.com/MaryNayram/Mission_Capstone_GuardianCare360.git  

Navigate to the project directory:  
cd GuardianCare360  

Install dependencies using:  
npm install  

Set up the database by creating a MySQL database named guardiancare360. Import the schema from the file located at database/guardiancare360.sql.  

Configure environment variables by creating a file named .env in the root directory. Add the following lines:  
DB_HOST=localhost  
DB_USER=root  
DB_PASSWORD=yourpassword  
DB_DATABASE=guardiancare360  

Start the application by ensuring Apache and MySQL are running via XAMPP. Then visit http://localhost/GuardianCare360 in your browser.  

Pushing to the main branch triggers PHP linting, optional tests, and secure deployment via SSH.  

System Highlights  
The backend is modular, with separate components for models, database access, authentication, and notifications. The dashboard updates in real time with badge indicators. The notification center supports filtering and pagination. Personal alerts include mark-as-read logic. The user interface is clean, responsive, and adapts to user roles.  

Supporting Documentation  
For deeper architectural insight, including UML diagrams and a breakdown of the software requirements specification, refer to the GuardianCare360 SRS Document available at:  
https://docs.google.com/document/d/1wENthQEVcoz9qFVa4i23SHJcu4GycL2_gQqtlQsStH0/edit?usp=sharing  

Conclusion  
GuardianCare360 is more than a training tool. It is a full operational platform for healthcare teams. Whether educating staff on cybersecurity or managing daily tasks, this system delivers clarity, control, and confidence.  


