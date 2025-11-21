ITE 3 - Midterm Project Instructions
Laravel CRUD Management System

Project Overview
Create a Management System of your choice using Laravel, Tailwind CSS, and 
MySQL.

Required Features
1. Two Related Tables (One-to-Many)
Example: Books (Many) → Categories (One)
• Primary table (like Students)
• Secondary table (like Courses)
• Foreign key relationship (nullable)
• Both models with proper relationships
2. Dashboard Page Must Have:
A. Three Statistics Cards
• First two cards must be dynamic (count from database)
• Third card can be static or dynamic
B. Add New Record Form
• All required input fields
• Dropdown to select related item (optional)
• Form validation with error messages
• Success message after submission
C. Records Table
• Display all primary records
• Show related item name (or "N/A")
• Edit button (opens modal)
• Delete button (with confirmation)

D. Edit Modal
• Pre-filled form with existing data
• Update all fields including relationship
• Validation on update

E. Delete Function
• Confirmation dialog
• Removes record from database
• Success message
3. Second Management Page
Same as Courses page in the example:
• Add new form for secondary entity
• Table showing all records
• Show count of related items (e.g., "5 books")
• Edit modal functionality
• Delete with confirmation
4. Navigation
• Sidebar with logo
• Dashboard link
• Secondary page link
• Active link highlighting
• User profile section with logout
Technical Requirements
Backend:
• Two Models with belongsTo() and hasMany() relationships
• Two Controllers with: index(), store(), update(), destroy()
• Three Migrations (2 tables + 1 foreign key)
• Routes (GET, POST, PUT, DELETE) with auth middleware
• Form validation (required, unique, data types)
Frontend:
• Two Blade views (dashboard + secondary page)
• Forms, tables, modals with Tailwind CSS
• Responsive design (mobile-friendly)
• Success/error notifications
Database:
• Proper data types
• Foreign key with onDelete('set null')
• Timestamps on all tables
• Sample data (minimum 5 records each)
