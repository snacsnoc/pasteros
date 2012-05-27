<?php

//This is where all the routes are mapped
//The home page of the website
respond('GET', '/', function ($request) {
            $home = new Home_Controller();
            $get_index = $home->get_index();
            return $get_index;
        });


//The route for adding a paste
respond('POST', '/add', function ($request) {
            $add = new Add_Controller();
            $post_index = $add->post_index();
            return $post_index;
        });

//Viewing a paste
respond('GET', '/[i:id]', function ($request) {
            if ($request->validate('id')->isInt()) {
                $paste_id = $request->id;
                $paste_view = new View_Controller();
                $get_index = $paste_view->get_index($paste_id);
                if ($get_index == false) {
                    $_SESSION['error'] = 'invalid paste number!';
                    return header('Location: /');
                } else {
                    echo $get_index;
                }
            } else {
                $_SESSION['error'] = 'invalid paste number!';
                return header('Location: /');
            }
        });

//Viewing a paste in a raw format
respond('GET', '/[i:id]/raw', function ($request) {

            if ($request->validate('id')->isInt()) {
                $paste_id = $request->id;
                $paste_view = new View_Controller();
                $get_raw = $paste_view->get_raw($paste_id);

                if ($get_raw == false) {
                    $_SESSION['error'] = 'invalid paste number!';
                    return header('Location: /');
                } else {
                    echo $get_raw;
                }
            } else {
                $_SESSION['error'] = 'invalid paste number!';
                return header('Location: /');
            }
        });

//Diff a forked and parent paste
respond('GET', '/[i:id]/diff/[i:parent]', function ($request) {
            //Validate that the parent ID and forked ID are integers
            if ($request->validate('id')->isInt() && $request->validate('parent')->isInt()) {

                $paste_id = $request->id;
                $parent_id = $request->parent;

                $paste_view = new View_Controller();
                $get_diff = $paste_view->get_diff($paste_id, $parent_id);

                //TODO: there must be an easier way to do this
                if ($get_diff == false) {
                    $_SESSION['error'] = 'invalid paste number!';
                    return header('Location: /');
                } else {
                    echo $get_diff;
                }
            } else {
                $_SESSION['error'] = 'invalid paste number!';
                return header('Location: /');
            }
        });



//Force the user to download the paste
respond('GET', '/[i:id]/download', function ($request) {

            if ($request->validate('id')->isInt()) {
                $paste_id = $request->id;

                $paste_view = new View_Controller();
                $get_download = $paste_view->get_download($paste_id);
                if ($get_download === false) {
                    $_SESSION['error'] = 'invalid paste number!';
                    return header('Location: /');
                } else {
                    echo $get_download;
                }
            } else {
                $_SESSION['error'] = 'invalid paste number!';
                return header('Location: /');
            }
        }
);

//Change the text highlighting colour
respond('POST', '/changetheme', function ($request) {
            $_SESSION['csstheme'] = $_POST['csstheme'];
            $paste_id = intval($_POST['id']);
            return header("Location: /$paste_id");
        });




//If nothing matches, respond as a 404 error.
respond('404', function ($request) {
            $page = $request->uri();
            echo "Blerg. It looks like $page doesn't exist.<br> Go <a href='/'>home</a>.";
        });