<?php
$request = $app->request;
$response = $app->response;
/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    echo $app['view']->getRender(null, 'index');
});

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->getRender(null, '404');
});

/**
 * get all users
 */
$app->get('/user', function () use ($app) {
    $data = array();
    $user = user::find(array(
    "order" => "name"
        ));
        foreach ($user as $user) {
             $data[] = array(
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail()
            );
        }
    echo json_encode($data);
});

/**
 * search user by email
 */
$app->post('/user/search', function () use ($app, $request, $response) {
    $email = $request->getPost('email', null);
    $result = array(
        'success' => false,
    );
    try {
        if ($email) {
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            if ($user = User::findFirst("email = '$email'")) {
                $result['data'][] = array(
                     'id' => $user->getId(),
                     'name' => $user->getName(),
                     'email' => $user->getEmail()
                );
            }
        } else {
            throw new Exception("Email parametter is necesary");
        }
        $result['success'] = true;
    } catch (Exception $e) {
        $result['success'] = false;
        $result['error'] = $e->getMessage();
    }
    $response->setHeader("Content-Type", "application/json");
    $response->setJsonContent($result, JSON_NUMERIC_CHECK);
    $response->send();
});

/**
 *  search user by primary key
 */
$app->post('/user/id', function () use ($app, $request, $response) {
    $id = $request->getPost('id', null);
    $result = array(
        'success' => false,
    );
    try {
        if ($id) {
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            if ($user = User::findFirst("id = '$id'")) {
                $result['data'][] = array(
                     'id' => $user->getId(),
                     'name' => $user->getName(),
                     'email' => $user->getEmail()
                );
            }
        } else {
            throw new Exception("Id parametter is necesary");
        }
        $result['success'] = true;
    } catch (Exception $e) {
        $result['success'] = false;
        $result['error'] = $e->getMessage();
    }
    $response->setHeader("Content-Type", "application/json");
    $response->setJsonContent($result, JSON_NUMERIC_CHECK);
    $response->send();
});


// adds a new user
$app->post('/user/add', function () use ($app, $request, $response) {
    $result = array(
        'success' => false,
    );
   try {
        $data = array();
        foreach (explode("|", "name|email") as $field) {
            if ($value = $request->getPost($field, null)) $data[$field] = $value;
        }
        if (count($data) <= 0) throw new Exception("Params are required", 1);    
        $user = new \User();
        $user->assign($data);
        $user->save();
        $result['data'] = $user->toArray();
        $result['success'] = true;
    } catch (Exception $e) {
        $result['success'] = false;
        $result['error'] = $e->getMessage();
    }
    $response->setHeader("Content-Type", "application/json");
    $response->setJsonContent($result, JSON_NUMERIC_CHECK);
    $response->send();
});


// update user based on primary key
$app->post('/user/up', function () use ($app, $request, $response) {
    $id = $request->getPost('id', null);
    $result = array(
        'success' => false,
    );
    try {
        if (!(is_null($id) || strlen(trim($id)) <= 0)) {//validacion de si el campo esta vacio
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            if ($user = User::findFirst("id = '{$id}'")) {//me permite realizar la busqueda en la base de datos
                $data = array();//crea un array
                foreach (explode("|", "name|email") as $field) {//validacion de que los campos email y name no pueden ser vacios
                    if ($value = $request->getPost($field, null)) $data[$field] = $value;
                }
                extract($data);//para convertir los datos de una array en variables
                if (count($data) > 0) {
                    $user->name=$name;
                    $user->email=$email;
                    $user->save();//tambien me sirve el update()
                }
                $result['data'] = $user->toArray();
            }
        } else {
            throw new Exception("Id parametter is necesary");
        }
        $result['success'] = true;
        $result['data'] = $user->toArray();
    } catch (Exception $e) {
        $result['success'] = false;
        $result['error'] = $e->getMessage();
    }
    $response->setHeader("Content-Type", "application/json");
    $response->setJsonContent($result, JSON_NUMERIC_CHECK);
    $response->send();
});


// delete user based on primary key
$app->post('/user/del', function () use ($app, $request, $response) {
    $id = $request->getPost('id', null);
    $result = array(
        'success' => false,
    );
    try {
        if ($id) {
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            if ($user = User::findFirst("id = '{$id}'")) {
                 $result["borrados"][] = array(
                     'id' => $user->getId(),
                     'name' => $user->getName(),
                     'email' => $user->getEmail()
                );

                $user->delete();
            }
        } else {
            throw new Exception("Id parametter is necesary");
        }
        $result['success delete'] = true;
    } catch (Exception $e) {
        $result['success'] = false;
        $result['error'] = $e->getMessage();
    }
    $response->setHeader("Content-Type", "application/json");
    $response->setJsonContent($result, JSON_NUMERIC_CHECK);
    $response->send();
});