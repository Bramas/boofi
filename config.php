<?php

DEFINE("PRIVATE_KEY", 'change me cause im not secure');

date_default_timezone_set('Europe/Paris');

\Boofi\Config::addFolders(array(
	'video' => '/Users/quentinbramas/Downloads'
	));

// password: admin
\Boofi\Authenticator::addUser('admin', '$2y$12$Y2hhbmdlIG1lIGNhdXNlI.vf2OkuzWMO.msg5G1LK7UvCBjrJSMUu');

