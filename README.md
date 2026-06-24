# 🎫 Online Support Ticket System

## 📖 Project Overview

The **Online Support Ticket System** is a Laravel-based web application that allows customers (including guest users) to raise support tickets for product or service-related issues. Support agents can manage, reply, and track tickets through a secure dashboard.

Each ticket is assigned a **unique reference number**, which customers can use to check the status of their request without logging in.

---

## 🚀 Features

### 👤 Guest / Customer Features

- Create a support ticket without login
- Submit the following details:
  - Customer Name
  - Email Address
  - Phone Number
  - Problem Description
- Receive a **unique ticket reference number**
- Get **automatic email confirmation** after submission
- Check ticket status using reference number
- View support agent replies

---

### 🧑‍💼 Support Agent Features

- Secure login system for agents
- View all submitted tickets
- View **pending / new tickets**
- Search tickets by customer name
- Pagination support for ticket listing
- Highlight unread/new tickets
- Open ticket details page
- Reply to tickets
- Send reply email automatically to customer

---

## ⚙️ Functional Requirements Implementation

1. Any user can create a support ticket  
2. Guest users can submit ticket with required details  
3. System generates a **unique reference number**  
4. Email confirmation sent after ticket creation  
5. Agents can view pending tickets after login  
6. Ticket listing supports search, pagination, and status highlighting  
7. Agents can reply to tickets  
8. Replies are saved and emailed to customer  
9. Customers can check status using reference number  
10. Ticket replies are visible in customer view  

---

## 📱 Non-Functional Requirements

- Responsive UI (Mobile / Desktop)
- Fast interaction using AJAX where applicable
-  input validation on all forms
- Secure handling of user data and ticket references
- Ticket reference numbers are hard to guess (secure random generation)
- Built using Laravel best practices and MVC structure

---

## 🛠️ Tech Stack

- Laravel Framework
- MySQL 
- Bootstrap 5 (Responsive UI)
- AJAX (for dynamic updates)
- SweetAlert2 (for alerts/notifications)
- SMTP Email Service

---

## 📸 Screenshots

### 🖥️ Desktop View
![Desktop View](screenshots/Desktop_view.jpg)

---
### 📱 Mobile View
![Mobile View](screenshots/Desktop_view.jpg)
---

### 🎫 Ticket Creation Page
![Ticket Form](screenshots/Ticket_creation_page(Gest).jpg)

---

### 📩 Ticket Reply View
![Reply View](screenshots/Ticket_Reply_View.jpg)
---

### 📩 Ticket Status View
![Reply View](screenshots/Ticket_status_check_page.jpg)
