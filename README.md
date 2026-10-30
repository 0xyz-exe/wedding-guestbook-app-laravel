# EverAfter - Wedding Guestbook & Digital RSVP Platform

Repository: https://github.com/0xyz-exe/wedding-guestbook-app-laravel

A digital wedding invitation, public RSVP portal, wishes guestbook wall, and reception attendance check-in platform built with Laravel 13, Blade, Tailwind CSS, and SQLite.

## Features

- ✅ **Public RSVP Portal**: Shareable invitation URL for family & friends to RSVP their attendance status (Attending, Declined, Tentative) with guest headcount.
- ✅ **Live Wishes Wall**: Reverse-chronological guestbook message feed displaying blessings, attendee relationship, and arrival verification.
- ✅ **Door Check-in Confirmation**: Front-desk reception toggle to mark guests as checked in as they arrive at the venue.
- ✅ **Admin CSV Export**: Streamed download of full guest manifest including names, contacts, RSVP status, headcounts, and wishes.
- ✅ **Multi-Event Management**: Couples or wedding planners can host and manage multiple wedding ceremonies from a unified dashboard.

## Tech Stack

Laravel 13.38.0 · Breeze 2.4 · SQLite · Tailwind CSS · Alpine.js

## Installation

```bash
git clone https://github.com/0xyz-exe/wedding-guestbook-app-laravel.git
cd wedding-guestbook-app-laravel
composer install && npm install && npm run build
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

### Demo Accounts

All accounts use the password: `password`

- **Couple / Host**: `test@example.com` (Olivia & Liam - seeded wedding event, wishes, and RSVPs)
- **Admin**: `admin@example.com`

### Public Demo Link

Once running locally, view the public wedding invitation and guestbook wall at:
`http://localhost:8000/invite/olivia-and-liam`

## Database Schema

- **users**: `id`, `name`, `email`, `password`, `is_admin`, `timestamps`
- **wedding_events**: `id`, `user_id`, `bride_name`, `groom_name`, `slug`, `event_date`, `event_time`, `venue_name`, `venue_address`, `story`, `timestamps`
- **guestbook_entries**: `id`, `wedding_event_id`, `guest_name`, `guest_email`, `relationship` (Friend/Family/Colleague/Relative/Other), `attendance_status` (attending/declined/tentative), `pax_count`, `wishes_message`, `is_confirmed`, `timestamps`

## License

MIT
