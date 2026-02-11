Build a modern Daily Task Tracker Web Application using Laravel Blade, SQLite, and Vanilla JavaScript.

You are a senior Laravel developer, product designer, and UX engineer.

The goal is to create a premium-quality productivity web app similar to a habit tracker or daily task tracker with a clean modern interface.

🧱 Technical Stack Requirements

Backend:

Laravel (latest stable version)

Blade templating engine

SQLite database

Eloquent ORM

Frontend:

Blade templates for layout

TailwindCSS for styling

Vanilla JavaScript only (no Vue, React, Alpine, jQuery, or other frameworks)

Use Fetch API for AJAX requests

No page reloads for interactions where possible

Architecture:

MVC structure

Clean controller separation

RESTful route patterns

🎯 Application Overview

Users can:

Create recurring daily tasks

Mark tasks as complete/incomplete/exempt

View daily dashboard

Set notification times

Manage task categories

View monthly history calendar

Design should feel modern, minimal, and premium.

Inspired by:

Apple reminders

Linear.app

Notion minimal UI

Avoid generic Bootstrap-like appearance.

🎨 Design Guidelines

UI must include:

Rounded corners (large radius)

Soft shadows

Clean spacing

Subtle hover effects

Smooth transitions

Minimal color palette

Category color indicators

Inter or system font stack

Layout:

Centered content container

Card-based task rows

Minimal sidebar or header navigation

🗄️ Database Schema

Use normalized structure.

DO NOT store completion status inside tasks table.

Use separate table for daily entries.

Users

(Default Laravel auth structure)

Categories

Fields:

id

name

color

user_id

Tasks

Fields:

id

title

category_id

notification_time (nullable)

recurring_days (JSON array, example: ["mon","tue","wed"])

user_id

TaskEntries

Daily completion tracking.

Fields:

id

task_id

date

status enum:

complete

incomplete

exempt

Unique index:

task_id + date

🧭 Routes

Define routes like:

GET /

Dashboard (today's tasks)

POST /tasks

Create task

POST /tasks/{task}/toggle

Toggle daily completion

GET /history

Monthly history view

POST /categories

Manage categories

🖥️ Dashboard Features

Main page shows:

Today's date

Completion percentage

Progress bar

List of today's tasks

Each task row includes:

Category color dot

Task title

Optional time display

Status button

Clicking status cycles through:

blank → complete → incomplete → exempt

Use AJAX toggle without page reload.

⚡ Vanilla JavaScript Requirements

Use:

Event delegation

Fetch API

CSRF token handling

Optimistic UI updates

Example behaviors:

Toggle task completion instantly

Create tasks via modal form

Update UI without refreshing page

No frontend frameworks allowed.

📅 Monthly History Page

Calendar layout:

Grid of days

Each day shows status icon

Month navigation

Completion percentage summary

Clicking a day opens detailed list.

🔔 Notifications

Store notification time.

Frontend:

Use browser Notification API

Ask permission on first use

🧠 UX Requirements

Inline editing where possible

Smooth transitions

Minimal loading indicators

Responsive design

Keyboard accessible buttons

📂 Suggested Folder Structure

app/Http/Controllers:

DashboardController

TaskController

TaskEntryController

CategoryController

HistoryController

resources/views:

layouts/app.blade.php

dashboard.blade.php

history.blade.php

components/task-row.blade.php

components/modal.blade.php

🚀 Output Requirements

Generate:

Laravel migrations

Eloquent models with relationships

Controllers with full logic

Blade layouts and components

Tailwind styling

Vanilla JS interaction scripts

Example seed data

🎯 Important Constraints

Do NOT use SPA frameworks.

Do NOT introduce unnecessary complexity.

Focus on clean Blade + Vanilla JS architecture.

UI must look modern SaaS quality.