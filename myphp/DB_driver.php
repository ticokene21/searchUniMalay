<?php

/**
 * Created by PhpStorm.
 * User: dovietliemtv
 * Date: 3/19/2016
 * Time: 10:26 AM
 */
class DB_driver
{
    private $__connect;
    private $sql;
    private $res;

    function open_connect()
    {
        $this->__connect = mysql_connect("localhost", "root", "") or die ("Can not connect to Database");
        $this->__connect = mysql_select_db("uni") or die("not exist Database");
        mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    }

}