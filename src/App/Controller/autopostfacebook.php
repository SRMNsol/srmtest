<?php

        $config = array();
        $config['appId'] = '117040755037895';
        $config['secret'] = '04ced89742cf2754a630775cdc956081';
        $config['fileUpload'] = false; // optional



        $RAW_QUERY = 'SELECT * FROM user WHERE uid="11952"';
        $statement = $connection->prepare($RAW_QUERY);
        $statement->execute();
        $users = $statement->fetchAll();

        $fb_access_auto= $users[0]['fb_access_token'];

        if($users[0]['facebook_auto']==1)
        {
            $params = array(
              "access_token" => $fb_access_auto,
              "message" => "ssssssssss",
              "description" => "ffffffff"
            );
             
            try 
            {
                $ret = $fb->api('/YOUR_FACEBOOK_ID/feed', 'POST', $params);
                echo 'Successfully posted to Facebook';
            }
            catch(Exception $e)
            {
                echo 'sssssssss';
                echo $e->getMessage();
            }

        }
        
     

 