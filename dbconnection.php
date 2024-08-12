<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "M-Theater";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<html><body>server error</body></html>";
    exit();
}

// Try to create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if ($conn->query($sql) !== TRUE) {
    echo "<html><body>server error</body></html>";
    exit();
}

$conn->select_db($dbname);

// Create tables if they do not exist
$userTable = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(200) NOT NULL UNIQUE,
    `password` TEXT NOT NULL,
    `usertype` VARCHAR(50) DEFAULT 'user',
    `status` VARCHAR(20) DEFAULT 'active'
)";

$moviesTable = "CREATE TABLE IF NOT EXISTS `movies` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `movie_id` VARCHAR(100) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `image` TEXT NOT NULL,
    `startdate` DATE NOT NULL,
    `enddate` DATE NOT NULL,
    `showtimes` TEXT NOT NULL,
    `banner` TEXT NOT NULL
)";

$bookingsTable = "CREATE TABLE IF NOT EXISTS `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `movie_id` VARCHAR(100) NOT NULL,
    `date` DATE NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `time` TIME NOT NULL,
    `seats` INT NOT NULL,
    `car_park` VARCHAR(10),
    `booking_at` TIMESTAMP NOT NULL,
     `price` int NOT NULL,
    FOREIGN KEY (`movie_id`) REFERENCES `movies`(`movie_id`),
    FOREIGN KEY (`username`) REFERENCES `users`(`username`)
)";

if (
    $conn->query($userTable) !== TRUE ||
    $conn->query($moviesTable) !== TRUE ||
    $conn->query($bookingsTable) !== TRUE
) {
    echo "<html><body>server error</body></html>";
    exit();
}
// Insert admin if not exists
$username = 'admin';
$email = 'admin6@mtheater.com';
$password = '$2y$10$UGFx2nGa.MRY5Vu/Z5OdV.X2gbprC0w0dgHpD/K297rdiTufyNHn.'; //1234
$userCheck = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
$userCheck->bind_param("s", $username);
$userCheck->execute();
$userCheck->store_result();

if ($userCheck->num_rows == 0) {
    $userCheck->close();
    $stmt = $conn->prepare("INSERT INTO `users` (username, email, password,usertype) VALUES (?, ?, ?,'admin')");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute() !== TRUE) {
        echo "<html><body>server error</body></html>";
        exit();
    }
    $stmt->close();
} else {
    $userCheck->close();
}

// if movies table is empty add default movies for testing
$movieCheck = $conn->query("SELECT COUNT(*) as count FROM `movies`");
$movieCount = $movieCheck->fetch_assoc()['count'];
if ($movieCount == 0) {
    $stmt = $conn->prepare("INSERT INTO `movies` (movie_id, title, image, startdate, enddate, showtimes, banner) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $movies = [
        ['movie_id' => 'movie1', 'title' => 'Deadpool 3', 'image' => 'sam.png', 'startdate' => '2024-05-22', 'enddate' => '2024-07-22', 'showtimes' => '15:00 | 10:00 | 18:30', 'banner' => 'sam.png'],
        ['movie_id' => 'movie2', 'title' => 'Harry Potter 7 part 1', 'image' => 'sam2.png', 'startdate' => '2024-05-23', 'enddate' => '2024-07-23', 'showtimes' => '12:00 | 9:00 | 16:30', 'banner' => 'sam2.png'],
        ['movie_id' => 'movie3', 'title' => 'Avatar 1', 'image' => 'sam3.png', 'startdate' => '2024-05-24', 'enddate' => '2024-07-24', 'showtimes' => '15:00 | 10:00 | 18:30', 'banner' => 'sam3.png'],
        ['movie_id' => 'movie4', 'title' => 'Inception', 'image' => 'sam4.png', 'startdate' => '2024-05-25', 'enddate' => '2024-07-25', 'showtimes' => '12:00 | 9:00 | 16:30', 'banner' => 'sam4.png'],
        ['movie_id' => 'movie5', 'title' => 'Intersteller', 'image' => 'sam5.png', 'startdate' => '2024-06-23', 'enddate' => '2024-08-23', 'showtimes' => '15:00 | 10:00 | 18:30', 'banner' => 'sam5.png'],
        ['movie_id' => 'movie6', 'title' => 'Joker', 'image' => 'sam6.png', 'startdate' => '2024-06-24', 'enddate' => '2024-08-24', 'showtimes' => '12:00 | 9:00 | 16:30', 'banner' => 'sam6.png'],
        ['movie_id' => 'movie7', 'title' => 'The Dark Night', 'image' => 'sam7.png', 'startdate' => '2024-06-25', 'enddate' => '2024-08-25', 'showtimes' => '15:00 | 10:00 | 18:30', 'banner' => 'sam7.png'],
        ['movie_id' => 'movie8', 'title' => 'Avengers Endgame', 'image' => 'sam8.png', 'startdate' => '2024-06-26', 'enddate' => '2024-08-26', 'showtimes' => '12:00 | 9:00 | 16:30', 'banner' => 'sam8.png'],
        ['movie_id' => 'movie9', 'title' => 'The Matrix Resurrections', 'image' => 'matrix.png', 'startdate' => '2024-05-01', 'enddate' => '2024-08-15', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'matrix.png'],
        ['movie_id' => 'movie10', 'title' => 'Godzilla vs. Kong', 'image' => 'godzilla.png', 'startdate' => '2024-05-05', 'enddate' => '2024-08-20', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'godzilla.png'],
        ['movie_id' => 'movie11', 'title' => 'Mortal Kombat', 'image' => 'mortal.png', 'startdate' => '2024-06-01', 'enddate' => '2024-09-10', 'showtimes' => '12:00 | 15:00 | 19:00', 'banner' => 'mortal.png'],
        ['movie_id' => 'movie12', 'title' => 'Dune', 'image' => 'dune.png', 'startdate' => '2024-06-10', 'enddate' => '2024-09-15', 'showtimes' => '16:00 | 18:00 | 22:00', 'banner' => 'dune.png'],
        ['movie_id' => 'movie13', 'title' => 'The French Dispatch', 'image' => 'french.png', 'startdate' => '2024-06-15', 'enddate' => '2024-09-25', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'french.png'],
        ['movie_id' => 'movie14', 'title' => 'Free Guy', 'image' => 'freeguy.png', 'startdate' => '2024-07-01', 'enddate' => '2024-10-01', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'freeguy.png'],
        ['movie_id' => 'movie15', 'title' => 'Tenet', 'image' => 'tenet.png', 'startdate' => '2024-07-10', 'enddate' => '2024-10-10', 'showtimes' => '12:00 | 15:00 | 18:00', 'banner' => 'tenet.png'],
        ['movie_id' => 'movie16', 'title' => 'Black Widow', 'image' => 'blackwidow.png', 'startdate' => '2024-07-15', 'enddate' => '2024-10-15', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'blackwidow.png'],
        ['movie_id' => 'movie17', 'title' => 'No Time to Die', 'image' => 'notimetodie.png', 'startdate' => '2024-08-01', 'enddate' => '2024-11-01', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'notimetodie.png'],
        ['movie_id' => 'movie18', 'title' => 'A Quiet Place Part II', 'image' => 'quietplace2.png', 'startdate' => '2024-08-05', 'enddate' => '2024-11-05', 'showtimes' => '12:00 | 15:00 | 18:00', 'banner' => 'quietplace2.png'],
        ['movie_id' => 'movie19', 'title' => 'Spider-Man: Across the Spider-Verse', 'image' => 'spiderverse.png', 'startdate' => '2024-07-25', 'enddate' => '2024-11-30', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'spiderverse.png'],
        ['movie_id' => 'movie20', 'title' => 'Jurassic World: Dominion', 'image' => 'jurassic.png', 'startdate' => '2024-08-01', 'enddate' => '2024-12-01', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'jurassic.png'],
        ['movie_id' => 'movie21', 'title' => 'The Batman', 'image' => 'batman.png', 'startdate' => '2024-08-10', 'enddate' => '2024-12-10', 'showtimes' => '12:00 | 15:00 | 18:00', 'banner' => 'batman.png'],
        ['movie_id' => 'movie22', 'title' => 'Nope', 'image' => 'nope.png', 'startdate' => '2024-08-15', 'enddate' => '2024-12-15', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'nope.png'],
        ['movie_id' => 'movie23', 'title' => 'Shang-Chi and the Legend of the Ten Rings', 'image' => 'shangchi.png', 'startdate' => '2024-08-20', 'enddate' => '2024-12-20', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'shangchi.png'],
        ['movie_id' => 'movie24', 'title' => 'Encanto', 'image' => 'encanto.png', 'startdate' => '2024-09-01', 'enddate' => '2024-12-30', 'showtimes' => '12:00 | 15:00 | 18:00', 'banner' => 'encanto.png'],
        ['movie_id' => 'movie25', 'title' => 'The Suicide Squad', 'image' => 'suicide.png', 'startdate' => '2024-09-05', 'enddate' => '2024-12-31', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'suicide.png'],
        ['movie_id' => 'movie26', 'title' => 'Wonder Woman 1984', 'image' => 'wonderwoman.png', 'startdate' => '2024-09-10', 'enddate' => '2024-12-31', 'showtimes' => '13:00 | 17:00 | 21:00', 'banner' => 'wonderwoman.png'],
        ['movie_id' => 'movie27', 'title' => 'The Lion King', 'image' => 'lionking.png', 'startdate' => '2024-09-15', 'enddate' => '2024-12-31', 'showtimes' => '12:00 | 15:00 | 18:00', 'banner' => 'lionking.png'],
        ['movie_id' => 'movie28', 'title' => 'Cruella', 'image' => 'cruella.png', 'startdate' => '2024-09-20', 'enddate' => '2024-12-31', 'showtimes' => '14:00 | 16:00 | 20:00', 'banner' => 'cruella.png']
    ];

    foreach ($movies as $movie) {
        $stmt->bind_param("sssssss", $movie['movie_id'], $movie['title'], $movie['image'], $movie['startdate'], $movie['enddate'], $movie['showtimes'], $movie['banner']);
        if ($stmt->execute() !== TRUE) {
            echo "<html><body>server error</body></html>";
            exit();
        }
    }

    $stmt->close();
}
