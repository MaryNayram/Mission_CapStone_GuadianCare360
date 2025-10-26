

Author: Mary Doh  
Organisation: E-learning Provider  
Date Created: 3/10/2025  

 Introduction
Welcome to GuardianCare360, a secure, scalable web-based platform designed to deliver cybersecurity training and task management for healthcare professionals in Ghana. It empowers administrators and staff with the tools to learn, manage, and stay informed — all from a clean, intuitive dashboard.

This README provides a complete guide to setting up, running, and deploying GuardianCare360 locally or via CI/CD, ensuring a seamless experience for both training and operational workflows.


 Scope
GuardianCare360 serves two core functions:

1. Cybersecurity Training Platform  
   - Tailored for healthcare staff in Ghana  
   - Delivers interactive modules to build awareness and resilience against cyber threats

2. Task & Notification System  
   - Role-aware dashboard for admins and employees  
   - Streamlines task workflows, tracks progress, and sends real-time alerts


System Overview

GuardianCare360 is structured into four key layers:
- Frontend
Built with HTML5, CSS, and JavaScript to deliver a responsive, interactive user experience for both administrators and staff.
- Backend
Powered by PHP, the backend handles core logic including registration, login, logout, course access, task workflows, and notification delivery.
- Database
MySQL is used to store and manage user data, course modules, task records, and notification logs — ensuring fast and reliable access.
- Hosting
The application runs locally via XAMPP, using Apache and PHP to simulate a real-time server environment for development and testing.

Core Features

  Cybersecurity Training

- Register (UC-1)  
  Staff sign up with name, email, password, and organization

- Login (UC-2)  
  Secure access to course modules and dashboard

- Logout (UC-3)  
  Ends session and redirects to login

- View Course Modules (UC-4)  
  Browse available modules with descriptions

- View Course Content (UC-5)  
  Access multimedia training content

- Create Course Content (UC-6)  
  Admins manage modules: add, update, delete

Task Management

- Role Management  
  Admins and employees get tailored controls and views

- Task Control (admin)
  Create, assign, update, and delete tasks with full visibility

- Smart Filtering  
  Sort tasks by priority, status, and deadline

- Secure Login  
  Role-based authentication ensures data protection

- Real-Time Notifications  
  Alerts for new tasks, updates, and broadcasts

- Deadline Tracking  
  Highlights overdue tasks and upcoming deadlines

- Broadcast + Personal Alerts  
  Supports both global announcements and user-specific updates

 Tech Stack

- PHP 7.4+  
- MySQL 5.7+  
- Bootstrap + Font Awesome  
- HTML5, CSS, JavaScript  
- XAMPP (Apache, PHP, MySQL)

 Installation Instructions

1. Clone the Repository  
   ```
   git clone https://github.com/MaryNayram/Mission_Capstone_GuardianCare360.git
   ```

2. Navigate to Project Directory  
   ```
   cd GuardianCare360
   ```

3. Install Dependencies  
   ```
   npm install
   ```

4. Set Up Database  
   - Create a MySQL database named `guardiancare360`  
   - Import schema from `database/guardiancare360.sql`

5. Configure Environment Variables  
   - Create a `.env` file in the root directory  
   - Add:
     ```
     DB_HOST=localhost
     DB_USER=root
     DB_PASSWORD=yourpassword
     DB_DATABASE=guardiancare360
     ```

6. Start the Application  
   - Ensure Apache and MySQL are running via XAMPP  
   - Visit: `http://localhost/GuardianCare360`



 CI/CD Deployment (GitHub Actions)

GuardianCare360 supports automated deployment via GitHub Actions:

- SSH into your Ubuntu server (`nayram@172.31.122.175`)  
- Pull latest code into `/var/www/guardiancare360`  
- Secrets stored securely in GitHub:
  - SSH_HOST
  - SSH_USER
  - SSH_KEY

Push to `main` triggers:
- PHP linting  
- Optional tests  
- Secure deployment via SSH


  System Highlights

- Modular backend: Models, DB, Auth, Notifications  
- Dynamic dashboard with real-time badge updates  
- Filterable notification center with pagination  
- Mark-as-read logic for personal alerts  
- Clean UI with responsive layout and role-aware navigation


Supporting Documentation

For deeper architectural insight, including UML diagrams and SRS breakdowns, refer to the full spec:

GuardianCare360 SRS Document  
https://docs.google.com/document/d/1wENthQEVcoz9qFVa4i23SHJcu4GycL2_gQqtlQsStH0/edit?usp=sharing


 Conclusion

GuardianCare360 is more than a training tool — it’s a full operational platform for healthcare teams. Whether you're educating staff on cybersecurity or managing daily tasks, this system delivers clarity, control, and confidence.

