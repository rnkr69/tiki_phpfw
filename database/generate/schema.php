<?php

$schema = ENV("MYSQL_SCHEMA");
if (!is_string($schema) || !preg_match('/^[a-zA-Z0-9_]+$/', $schema)) {
    throw new InvalidArgumentException('MYSQL_SCHEMA must contain only letters, digits and underscores');
}

$sql_generate[] = "CREATE SCHEMA `".$schema."`;";


