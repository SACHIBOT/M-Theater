<?php
include('dbconnection.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT title, movie_id FROM movies WHERE title LIKE ? AND enddate >= ?";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$today = date('Y-m-d');

$stmt->bind_param('ss', $searchTerm, $today);

$stmt->execute();
$result = $stmt->get_result();

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($movies);
