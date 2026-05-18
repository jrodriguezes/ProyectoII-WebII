# Project Documentation: Aventones

## Overview
**Aventones** is a web application developed in **Laravel** designed to facilitate *carpooling* (shared rides). The platform connects drivers who have available seats in their vehicles with passengers looking to travel to the same destinations.

## Architecture and Technologies
- **Backend Framework:** Laravel (PHP)
- **Database:** MySQL / Relational (uses Eloquent ORM)
- **Frontend:** Blade Templates with Tailwind CSS.
- **Authentication:** Custom user system with traditional sessions, email verification, and a *Magic Links* system (passwordless login).

---

## Main Models (Database Entities)

The system revolves around several key entities, reflected in their respective models (`app\Models`):

1. **User:**
   - **User types:** Can be a `passenger`, driver, or administrator.
   - **Key fields:** Unique alphanumeric ID (`char(9)`), profile picture, account status (`pending`, `active`, `inactive`), and token management for email verification.
   - **Relationships:** A user can have multiple vehicles (if they are a driver), publish multiple `rides`, and make multiple `reservations`.

2. **Vehicle:**
   - Represents the cars registered by drivers.
   - They are linked to the driver through the `driver_id`.

3. **Ride:**
   - Created by the drivers.
   - Contains the ride information: origin, destination, date, time, and available seats.

4. **Reservation:**
   - The link between a Passenger and a `Ride`.
   - Has dynamic states: a passenger "books" a seat, and the driver can "accept" or "reject" said reservation. The passenger can also "cancel" it.

5. **SearchLog:**
   - Stores information about the ride searches performed by users.
   - Helps administrators generate reports and understand route demand.

6. **MagicLoginToken:**
   - Manages secure temporary tokens sent via email to allow users to log in with a magic link.

---

## User Flows and Key Features

### 1. Authentication and Accounts System
- **User Registration:** Users provide their basic details and a profile picture. The account starts in a `pending` state.
- **Email Verification:** Upon registration, an email is sent with a unique token. Clicking the link changes the account to an `active` state.
- **Traditional Login:** Using conventional credentials.
- **Magic Login (Magic Link):** A modern alternative where the user requests access via email, receives a temporary link, and upon clicking, logs directly into their account without a password.
- **Profile Management:** Users can modify their personal information and profile picture (`/edit-profile`).

### 2. Driver Flow
- **Vehicle Management:** They can add, edit, or delete vehicles they own.
- **Publishing Rides:** They can publish new rides, specifying route details and vehicle capacity.
- **Passenger Management:** They receive reservation requests and have the authority to accept or reject passengers on their published rides.

### 3. Passenger Flow
- **Ride Search:** They can search for available rides to their destination on the main screen (`/home/ride`).
- **Reservation:** They request a seat on the ride they are interested in.
- **Reservation Management:** They can view their reservations and cancel them if they are no longer traveling.

### 4. Administrative Features
- **Reports:** Reports dashboard (`/home/report`) to analyze route demand using the `SearchLog`.
- **Account Moderation:** Ability to activate or deactivate user accounts (`/home/user/activate` and `/home/user/deactivate`).

---

## Main Routes and Controllers

- **`UserController`**: Handles account creation (registration), updating, deletion, activation/deactivation, and email verification.
- **`LoginController` & `MagicLoginController`**: Manage sessions and passwordless authentication.
- **`HomeController`**: Controls the main view and ride search logic.
- **`VehicleController`**: Maintenance (CRUD) for users' vehicles.
- **`RideController`**: Maintenance (CRUD) for published routes/rides.
- **`ReservationController`**: Handles the reservation lifecycle (`book`, `cancel`, `accept`, `reject`).
- **`BookingController`**: To view current reservations.
- **`SearchLogController`**: Manages search analytics.
