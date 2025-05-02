CREATE DATABASE movie_streaming;

USE movie_streaming;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    dob DATE NOT NULL,
    avatar VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0, -- Indicate if the user is an admin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert an admin user
INSERT INTO users (username, email, dob, avatar, password, is_admin) 
VALUES ('Admin', 'admin@example.com', '2000-01-01', 'avatar1.gif', '$2a$12$uo9eAnC0vWwtc2sfJKrYWu7wpUnetlPbHzylAtEW2zThJomC/fUpG', 1);

-- Create the movies table
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(255) NOT NULL,
    movie_poster VARCHAR(255) NOT NULL,
    movie_file VARCHAR(255) NOT NULL,
    movie_genres VARCHAR(255) NOT NULL,
    release_year INT NOT NULL,
    imdb_rating FLOAT NOT NULL,
    language VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    upload_date DATETIME NOT NULL
);

-- Alter the movies table to add a new column for additional movie information
ALTER TABLE movies ADD COLUMN about_movie TEXT;

-- Create the history table
CREATE TABLE history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    progress INT NOT NULL, -- Progress in percentage
    last_watched DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);

-- Create the watch_history table
CREATE TABLE watch_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    watched_percentage DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
    watched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Alter the watch_history table to add new columns for watch percentage and last watched timestamp
ALTER TABLE watch_history
ADD COLUMN watch_percentage INT DEFAULT 0,
ADD COLUMN last_watched TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Query to fetch id, movie_name, and movie_poster from the movies table
SELECT id, movie_name, movie_poster FROM movies;
