<?php

/**
 * Helper para elemento de captcha
 *
 * @author maraya-gómez
 */
 
App::uses('AppHelper', 'View/Helper');
App::import('Component', 'CoolPHPCaptcha.Captcha');

class CaptchaHelper extends AppHelper {
	/**
 	 * Helpers a usar
 	 * @var array
	 */
    public $helpers = array('Html', 'Form');
    
	/**
	 * Retorna elemento input con el captcha incorporado
	 * (se comporta igual que $this->Html->input)
	 *
	 * @param string $name - Nombre del campo
	 * @param array $options - Opciones
	 * @return string
	 */
    public function captcha($name, $options = array()) {
    	$defaults = array(
			'autocomplete' => 'off',
			'captcha' => array(
				'reloadTitle' => __('Recargar imagen'),
				'imageFormat' => 'png',
				'sessionVar' => 'captcha',
				'words' => 'es',
				'lineWidth' => 1,
				'scale' => 3,
				'blur' => true
			)
		);
		
		$options['autocomplete'] = isset($options['autocomplete'])? $options['autocomplete']: $defaults['autocomplete'];
		$options['captcha']['reloadTitle'] = isset($options['captcha']['reloadTitle'])? $options['captcha']['reloadTitle']: $defaults['captcha']['reloadTitle'];
		$options['captcha']['imageFormat'] = isset($options['captcha']['imageFormat'])? $options['captcha']['imageFormat']: $defaults['captcha']['imageFormat'];
		$options['captcha']['sessionVar'] = isset($options['captcha']['sessionVar'])? $options['captcha']['sessionVar']: $defaults['captcha']['sessionVar'];
		$options['captcha']['words'] = isset($options['captcha']['words'])? $options['captcha']['words']: $defaults['captcha']['words'];
		$options['captcha']['lineWidth'] = isset($options['captcha']['lineWidth'])? $options['captcha']['words']: $defaults['captcha']['lineWidth'];
		$options['captcha']['scale'] = isset($options['captcha']['scale'])? $options['captcha']['scale']: $defaults['captcha']['scale'];
		$options['captcha']['blur'] = isset($options['captcha']['blur'])? $options['captcha']['blur']: $defaults['captcha']['blur'];
		
		$captcha = new CaptchaComponent(new ComponentCollection());
		$captcha->setOptions($options['captcha']);
    	$src = 'data:image/png;base64,'. $captcha->createImage();	
    	
    	$uniqId = uniqid();
    	$script = "<script>
					   $('#recargar_captcha_". $uniqId ."').on('click', function() {
						   $.ajax({
							   type: 'POST',
							   url: '/captcha/reload',
							   cache: false,
							   dataType: 'json',
							   success: function(data) {
								   $('#captcha_image_". $uniqId ."').attr('src', 'data:image/png;base64,'+ data.image);
							   },
							   error: function() {
									console.error('Captcha error');
							   }
						   });
					   });
    			   </script>";
    			   
    	$span = "<span class=\"row12\">
    				<img id=\"captcha_image_". $uniqId ."\" alt=\"\" src=\"". $src ."\" /> <br />"
				   	  .  $this->Html->link($options['captcha']['reloadTitle'], 'javascript:void(0);', array('id' => 'recargar_captcha_' . $uniqId, 'escape' => false, 'title' => $options['captcha']['reloadTitle'])) .
				 "</span>";
		
		$options['after'] = $span;
    	$input = $this->Form->input($name, $options) . $script;
    	
		return $input;
    }
}
