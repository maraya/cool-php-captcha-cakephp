<?php

Router::connect('/captcha/reload', array('controller'=> 'captcha', 'action' => 'reload', 'plugin' => 'CoolPHPCaptcha'));
Router::connect('/captcha/image', array('controller'=> 'captcha', 'action' => 'image', 'plugin' => 'CoolPHPCaptcha'));

