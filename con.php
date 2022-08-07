<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:16
 */

const hostname = 'localhost';
const user = 'root';
const password = '';
const databaseName = 'keuangan';
header('Content-Type: application/json; charset=utf-8');
$connect = mysqli_connect(hostname, user, password, databaseName) or die('Unable to Connect');
