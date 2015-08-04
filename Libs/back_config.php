if ($mysql->NumRows($sql)>1) {
            $method = $mysql->FetchObject($sql);
            if (!empty($method)) {
                $array_uri['controller'] = $method->method;
                $array_uri['method'] = $array_tmp_uri[0];
            } else {
                $array_uri['controller'] = $array_tmp_uri[0];
                $array_uri['method'] = $array_tmp_uri[1];
            }
        } else {
            $array_uri['controller'] = $array_tmp_uri[0];
            $array_uri['method'] = $array_tmp_uri[1];
        }
        if ((!empty($array_uri['method'])) && (!empty($array_uri['controller']))) {
            define('MODELCLASS', $array_uri['method']);
            define('CONTROLLERCLASS', $array_uri['controller']);
        }
        echo MODELCLASS;
        echo CONTROLLERCLASS;
        print_r($array_tmp_uri);