# M-Theater Website

![M-Theater](https://telegra.ph/file/7e85ba5830cd87d06a64d.jpg)

M-Theater Website is a PHP-based application that allows users to book movie tickets online. The site features a database-driven system for managing movies, showtimes, and bookings. This project was created for educational purposes to learn how to work with PHP, HTML, and manage a database.

## Features

- **User Registration and Login System**: Allows users to create accounts and log in to book tickets.
- **Admin User with Elevated Privileges**: Admins have additional rights to manage movies and bookings.
- **Movie Database**: Store and manage movies with details including title, image, start date, end date, showtimes, and banner.
- **Booking System**: Users can select seats and optionally choose a car park option while booking tickets.

## Database Schema

The database schema consists of three main tables:

1. **`users`**: Stores user information.
   - `username`: User's username.
   - `email`: User's email address.
   - `password`: User's password (ensure to hash this in production).
   - `user_type`: User type (admin, user, or staff member).

2. **`movies`**: Stores movie information.
   - `movie_id`: Unique identifier for each movie.
   - `title`: Movie title.
   - `image`: Path to the movie's image.
   - `start_date`: Movie's start date.
   - `end_date`: Movie's end date.
   - `showtimes`: Showtimes available for the movie.
   - `banner`: Banner image for the movie.

3. **`bookings`**: Stores booking information.
   - `movie_id`: The ID of the booked movie.
   - `date`: Booking date.
   - `username`: Username of the user who made the booking.
   - `time`: Showtime selected.
   - `seatscount`: Number of seats booked.
   - `car_park`: Indicates if the user opted for a car park.
   - `timestamp`: The time when the booking was made.

## Known Issues

- **Payment System**: The payment system is not yet implemented.
- **Error Handling and Validation**: Error handling and input validation need improvements.
- **Security**: Additional security measures such as input sanitization and encryption are required.

## Note

- This project was created for educational purposes, to learn how to work with PHP, HTML, and manage a database.