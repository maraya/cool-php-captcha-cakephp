<?php

/**
 * Componente para elemento de captcha
 *
 * @author maraya-gómez
 * @since 2014-03-03
 */
 
App::import('Vendor', 'CoolPHPCaptcha.Captcha', array('file' => 'cool-php-captcha-0.3.1' . DS . 'captcha.php')); 
 
class CaptchaComponent extends Component {
	/**
 	 * Componentes a usar
 	 * @var array
	 */
	public $components = array('Session');
	
	/**
 	 * Objeto SimpleCaptcha
 	 * @var SimpleCaptcha
	 */
    private $captcha;
	
    /**
	 * Sobrescritura de constructor
	 *
	 * @param ComponentCollection $collection
	 * @param array $settings
	 * @return void
	 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->captcha = new SimpleCaptcha();
		$this->captcha->resourcesPath = ROOT . DS . APP_DIR . DS . 'Plugin' . DS . 'CoolPHPCaptcha' . DS . 'Vendor' . DS . 'cool-php-captcha-0.3.1'. DS . 'resources';
		parent::__construct($collection, $settings);
	}
	
	/**
	 * Set options
	 *
	 * @return void
	 */
	public function setOptions($options) {
		$this->captcha->imageFormat = $options['imageFormat'];
		$this->captcha->session_var = $options['sessionVar'];
		$this->captcha->wordsFile = 'words/'. $options['words'] .'.php';
		$this->captcha->lineWidth = $options['lineWidth'];
		$this->captcha->scale = $options['scale'];
		$this->captcha->blur = $options['blur'];
	}
	
	/**
	 * Retorna imagen captcha
	 *
	 * @return string
	 */
	public function createImage() {
    	ob_start ();
    	$this->captcha->CreateImage();
		$image_data = ob_get_contents(); 
		ob_end_clean ();
		
		return base64_encode($image_data);
	}
	
	/**
	 * Método valida si la frase captcha ingresada es correcta o no
	 *
	 * @param string $texto
	 * @return boolean
	 */
	public function check($texto) {
		if ($texto === $this->Session->read($this->captcha->session_var)) {
			$this->Session->delete($this->captcha->session_var);
			return true;	
		}
		return false;
	}
}
