<?php

$klein = new \Klein\Klein();

//This is where all the routes are mapped
//The home page of the website
$klein->respond('GET', '/', function () {
            $home = new Home_Controller();
            $get_index = $home->get_index();
            echo $get_index;
        });


//The route for adding a paste
$klein->respond('POST', '/add', function () {
            $add = new Add_Controller();
            $post_index = $add->post_index();
            echo $post_index;
        });

//Viewing a paste
$klein->respond('GET', '/[:id]', function ($request, $response, $service) {
                $paste_id = $request->id;
                $paste_view = new View_Controller();
                $get_index = $paste_view->get_index($paste_id);
                if (false !== $get_index) {
                    echo $get_index;
                }
                //Set our session data for the delete ID to null after displaying it once
                $_SESSION['delete_id'] = null;
        });

//Viewing a paste in a raw format
$klein->respond('GET', '/[:id]/raw', function ($request, $response, $service) {
                $paste_id = $request->id;
                $paste_view = new View_Controller();
                $get_raw = $paste_view->get_raw($paste_id);

                if (false !== $get_raw ) {
                    echo $get_raw;
                } else {
                    $_SESSION['error'] = serialize('invalid paste number!');
                    return header('Location: /');
                }
        });

//Diff a forked and parent paste
$klein->respond('GET', '/[:id]/diff/[:parent]', function ($request, $response, $service) {
                $paste_id = $request->id;
                $parent_id = $request->parent;

                $paste_view = new View_Controller();
                $get_diff = $paste_view->get_diff($paste_id, $parent_id);

                //TODO: there must be an easier way to do this
                if (false !== $get_diff) {
                    echo $get_diff;
                } else {
                    $_SESSION['error'] = serialize('invalid paste!');
                    return header('Location: /');
                }
        });



//Force the user to download the paste
$klein->respond('GET', '/[:id]/download', function ($request, $response, $service) {
                $paste_id = $request->id;
                $paste_view = new View_Controller();
                $get_download = $paste_view->get_download($paste_id);
                if (false !== $get_download) {
                    echo $get_download;
                } else {
                    $_SESSION['error'] = serialize('invalid paste number!');
                    return header('Location: /');                    
                }
        }
);

//View tagged pastes tagged with a uhm tag!
$klein->respond('GET', '/tag/[:id]', function ($request, $response, $service) {
                $tag_id = $request->id;
                $tag_view = new Tag_Controller();
                $get_index = $tag_view->get_index($tag_id);
                if (false !== $get_index) {
                    echo $get_index;
                } else {
                    $_SESSION['error'] = serialize('no such tag!');
                    return header('Location: /');                    
                }
        });

//Delete a paste
$klein->respond('GET', '/[:id]/delete/[:del_id]', function ($request, $response, $service) {
                $paste_id = $request->id;
                $delete_id = $request->del_id;

                $paste_delete = new Delete_Controller();
                $get_delete = $paste_delete->get_index($paste_id, $delete_id);
                if (false !== $get_delete) {
                    return header('Location: /');      
                } else {
                    $_SESSION['error'] = serialize('invalid paste number!');
                    return header('Location: /');                    
                }
        }
);



//Change the text highlighting colour
$klein->respond('POST', '/changetheme', function ($request) {
            //Set cookie for 30 days
            setcookie('csstheme', $_POST['csstheme'], time() + 60 * 60 * 24 * 30);
            $paste_id = $_POST['id'];
            return header("Location: /$paste_id");
        });



$klein->respond('GET', '/api', function () {
            $api = new Api_Controller();
            $get_index = $api->get_index();
            echo $get_index;
        });

$klein->respond('POST', '/api/v1/create', function () {
            $api = new Api_Controller();
            $post_create = $api->post_create();
            echo $post_create;
        });

$klein->respond('POST', '/api/v1/get', function () {
            $api = new Api_Controller();
            $post_get = $api->post_get();
            echo $post_get;
        });

$klein->respond('POST', '/api/v1/simplecreate', function () {
            $api = new Api_Controller();
            $post_simplecreate = $api->post_simplecreate();
            echo $post_simplecreate;
        });

$klein->respond('GET', '/diff', function () {
            $diff = new Diff_Controller();
            $get_index = $diff->get_index();
            echo $get_index;
        });

$klein->respond('GET', '/stats', function () {
            $stats = new Stats_Controller();
            $get_index = $stats->get_index();
            echo $get_index;
        });

//If nothing matches, respond as a 404 error.
$klein->respond('404', function () {
            echo "Blerg. It looks like the page your are accessing doesn't exist.<br> Go <a href='/'>home</a>.";
        });
