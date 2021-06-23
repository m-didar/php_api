<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog category object
    $category = new Category($db);

    // Category query
    $result = $category->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if ($num > 0) {
        // Category array
        $categories = array();
        $categories['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $post_item = array(
                'id' => $id,
                'name' => $name
            );
            
            // Push to 'data'
            array_push($categories['data'], $post_item);
        }

        // Turn to JSON & output
        echo json_encode($categories);
    } else {
        // No posts
        echo json_encode(
            array('message' => 'No categories found')
        );
    }

?>