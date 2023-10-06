<?php

//Status codes

function r201($record_id){
    http_response_code(201);
    $res = [
        "status" => true,
        "record_id" => $record_id
    ];
    echo json_encode($res);
}

function r400(){
    http_response_code(400);
    $res = [
        "status" => false,
        "message" => 'Bad data'
    ];
    echo json_encode($res);
}

function r404($element){
    http_response_code(404);
    $res = [
        "status" => false,
        "message" => $element.' not found'
    ];
    echo json_encode($res);
}

function r405(){
    http_response_code(405);
    $res = [
        "status" => false,
        "message" => 'There is no method'
    ];
    echo json_encode($res);
}

function r416(){
    http_response_code(416);
    $res = [
        "status" => false,
        "message" => 'Parameter range not satisfiable'
    ];
    echo json_encode($res);
    exit();
}

function update($element){
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => $element.' is updated'
    ];
    echo json_encode($res);
}

function deleted($element){
    http_response_code(200);
    $res = [
        "status" => true,
        "message" => $element.' is deleted'
    ];
    echo json_encode($res);
}

//GET

function getTasks($connect)
{
    $tasks = mysqli_query($connect, "SELECT * FROM `Tasks`");

    if(mysqli_num_rows($tasks) < 1){
        r404('Tasks');
    }
    else{
        $tasksList = [];


        while($task = mysqli_fetch_assoc($tasks)){
            $tasksList[] = $task;
        }

        echo json_encode($tasksList);
    }
}

//POST

function postTask($connect, $data){
    $text = $data['Text'];
    $status = $data['Status'];

    mysqli_query($connect, "INSERT INTO `Tasks`(`id`, `text`, `status`) VALUES ('', '$text', '$status')");

    r201(mysqli_insert_id($connect));
}

function updateTask($connect, $id, $data){
    $text = $data['Text'];
    $status = $data['Status'];

    $post = mysqli_query($connect, "SELECT * FROM Tasks WHERE `id` = $id");

    if(mysqli_num_rows($post) < 1){
        r404('Tasks');
    }
    else{
        mysqli_query($connect, "UPDATE `Tasks` SET `text`='$text',`status`='$status' WHERE `id`= $id");
        update('Tasks');
    }
    
}

function deleteTask($connect, $id){

    $post = mysqli_query($connect, "SELECT * FROM `Tasks` WHERE `id` = $id");
    if(mysqli_num_rows($post) < 1){
        r404('Task');
    }
    else{
        mysqli_query($connect, "DELETE FROM `Tasks` WHERE `id`= $id");
        deleted('Task');
    }
}

?>