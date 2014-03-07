<?php

/**
 * Controlador de captcha
 *
 * @author maraya-gómez
 * @since 2013-03-03
 */
 
class CaptchaController extends AppController {
	/**
 	 * Modelos a usar
 	 * @var array
	 */
	var $uses = null;
	
	/**
 	 * Componentes a usar
 	 * @var array 
	 */
    public $components = array('Auth', 'CoolPHPCaptcha.Captcha');
    
    /**
 	 * beforeFilter
 	 * @return void 
	 */
    public function beforeFilter() {
		$this->Auth->allow(array('reload'));
		parent::beforeFilter();
	}
	
	/**
	 * Método recarga imagen del captcha
	 *
	 * @return void
	 */
	public function reload() {
		$this->layout = 'ajax';
		$this->set('image', $this->Captcha->createImage());
	}
}

