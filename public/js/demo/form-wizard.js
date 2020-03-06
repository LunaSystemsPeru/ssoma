
// Form-Wizard.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


$(document).ready(function() {
	
	
	
	// FORM WIZARD
	// =================================================================
	// Require Bootstrap Wizard
	// http://vadimg.com/twitter-bootstrap-wizard-example/
	// =================================================================
	
	
	// MAIN FORM WIZARD
	// =================================================================
	$('#demo-main-wz').bootstrapWizard({
		tabClass		: 'wz-steps',
		nextSelector	: '.next',
		previousSelector	: '.previous',
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onInit : function(){
			$('#demo-main-wz').find('.finish').hide().prop('disabled', true);
		},
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			var wdt = 100/$total;
			var lft = wdt*index;
			
			$('#demo-main-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});
			
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#demo-main-wz').find('.next').hide();
				$('#demo-main-wz').find('.finish').show();
				$('#demo-main-wz').find('.finish').prop('disabled', false);
				} else {
				$('#demo-main-wz').find('.next').show();
				$('#demo-main-wz').find('.finish').hide().prop('disabled', true);
			}
		}
	});
	
	
	
	
	// CLASSIC FORM WIZARD
	// =================================================================
	$('#demo-cls-wz').bootstrapWizard({
		tabClass		: 'wz-classic',
		nextSelector	: '.next',
		previousSelector	: '.previous',
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onInit : function(){
			$('#demo-cls-wz').find('.finish').hide().prop('disabled', true);
		},
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			var wdt = 100/$total;
			var lft = wdt*index;
			$('#demo-cls-wz').find('.progress-bar').css({width:$percent+'%'});
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#demo-cls-wz').find('.next').hide();
				$('#demo-cls-wz').find('.finish').show();
				$('#demo-cls-wz').find('.finish').prop('disabled', false);
				} else {
				$('#demo-cls-wz').find('.next').show();
				$('#demo-cls-wz').find('.finish').hide().prop('disabled', true);
			}
		}
	});
	
	
	
	
	// CIRCULAR FORM WIZARD
	// =================================================================
	$('#demo-step-wz').bootstrapWizard({
		tabClass		: 'wz-steps',
		nextSelector	: '.next',
		previousSelector	: '.previous',
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onInit : function(){
			$('#demo-step-wz').find('.finish').hide().prop('disabled', true);
		},
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = (index/$total) * 100;
			var wdt = 100/$total;
			var lft = wdt*index;
			var margin = (100/$total)/2;
			$('#demo-step-wz').find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});
			
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#demo-step-wz').find('.next').hide();
				$('#demo-step-wz').find('.finish').show();
				$('#demo-step-wz').find('.finish').prop('disabled', false);
				} else {
				$('#demo-step-wz').find('.next').show();
				$('#demo-step-wz').find('.finish').hide().prop('disabled', true);
			}
		},
		onNext: function(){
			isValid = null;
			$('#demo-step-wz').bootstrapValidator('validate');
			
			
			if(isValid === false)return false;
		}
	});
	
	
	
	
	// CIRCULAR FORM WIZARD
	// =================================================================
	$('#demo-cir-wz').bootstrapWizard({
		tabClass		: 'wz-steps',
		nextSelector	: '.next',
		previousSelector	: '.previous',
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onInit : function(){
			$('#demo-cir-wz').find('.finish').hide().prop('disabled', true);
		},
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = (index/$total) * 100;
			var margin = (100/$total)/2;
			$('#demo-cir-wz').find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});
			
			navigation.find('li:eq('+index+') a').trigger('focus');
			
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#demo-cir-wz').find('.next').hide();
				$('#demo-cir-wz').find('.finish').show();
				$('#demo-cir-wz').find('.finish').prop('disabled', false);
				} else {
				$('#demo-cir-wz').find('.next').show();
				$('#demo-cir-wz').find('.finish').hide().prop('disabled', true);
			}
		}
	})
	
	
	
	
	// FORM WIZARD WITH VALIDATION
	// =================================================================
	$('#demo-bv-wz').bootstrapWizard({
		tabClass		: 'wz-steps',
		nextSelector	: '.next',
		previousSelector	: '.previous',
		onTabClick: function(tab, navigation, index) {
			return false;
		},
		onInit : function(){
			$('#demo-bv-wz').find('.finish').hide().prop('disabled', true);
		},
		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = (index/$total) * 100;
			var margin = (100/$total)/2;
			$('#demo-bv-wz').find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});
			
			navigation.find('li:eq('+index+') a').trigger('focus');
			
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#demo-bv-wz').find('.next').hide();
				$('#demo-bv-wz').find('.finish').show();
				$('#demo-bv-wz').find('.finish').prop('disabled', false);
				} else {
				$('#demo-bv-wz').find('.next').show();
				$('#demo-bv-wz').find('.finish').hide().prop('disabled', true);
			}
		},
		onNext: function(){
			isValid = null;
			$('#demo-bv-wz-form').bootstrapValidator('validate');
			
			
			if(isValid === false)return false;
		}
	});
	
	
	
	
	// FORM VALIDATION
	// =================================================================
	// Require Bootstrap Validator
	// http://bootstrapvalidator.com/
	// =================================================================
	
	var isValid;
	$('#demo-step-wz').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'fa fa-check-circle fa-lg text-success',
			invalid: 'fa fa-times-circle fa-lg',
			validating: 'fa fa-refresh'
		},
		fields: {
			nro_dni: {
				message: 'Nro. de DNI Incorrecto',
				validators: {
					notEmpty: {
						message: 'Nro de DNI es requerido'
					},
					digits: {
						message: 'Solo numeros'
					},
					stringLength: {
						min: 8,
						max: 8,
						message: 'el numero de dni debe tener 8 digitos'
					}
				}
			},
			ruc: {
				message: 'Nro. de Ruc Incorrecto',
				validators: {
					notEmpty: {
						message: 'Nro de Ruc es requerido'
					},
					digits: {
						message: 'Solo numeros'
					},
					minlength: {
						message: 'el numero de ruc es de 11 digitos'
					}
				}
			},
			razon_social: {
				validators: {
					notEmpty: {
						message: 'Razon social no puede estar vacio'
					}
				}
			},
			pasajero: {
				validators: {
					notEmpty: {
						message: 'Este campo no puede estar vacio'
					},
					stringLength: {
						min: 8,
						max: 245,
						message: 'escriba nombre y apellidos completos'
					}
				}
			},
			corto: {
				validators: {
					notEmpty: {
						message: 'Nombre comercial es necesario'
					}
				}
			},
			direccion: {
				validators: {
					notEmpty: {
						message: 'Direccion es necesario'
					}
				}
			},
			telefono: {
				validators: {
					notEmpty: {
						message: 'Telefono o Celular Necesario'
					},
					digits: {
						message: 'Solo numeros'
					},
					minlength: {
						message: 'minimo debe tener 6 digitos'
					}
				}
			},
			ape_pat: {
				validators: {
					notEmpty: {
						message: 'Apellido Paterno requerido'
					},
					regexp: {
						regexp: /^[A-Z\s]+$/i,
						message: 'aqui solo se permiten letras y espacios'
					}
				}
			},
			ape_mat: {
				validators: {
					notEmpty: {
						message: 'Apellido Materno requerido'
					},
					regexp: {
						regexp: /^[A-Z\s]+$/i,
						message: 'aqui solo se permiten letras y espacios'
					}
				}
			},
			nombres: {
				validators: {
					notEmpty: {
						message: 'Nombres requerido'
					},
					regexp: {
						regexp: /^[A-Z\s]+$/i,
						message: 'aqui solo se permiten letras y espacios'
					}
				}
			},
			usuario: {
				validators: {
					notEmpty: {
						message: 'Usuario es requerido y no puede estar vacio'
					},
					stringLength: {
						min: 4,
						max: 30,
						message: 'el nombre de usuario debe ser entre 4 y 30 caracteres'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_]+$/,
						message: 'aqui solo se permiten letras, numeros y subguion'
					},
					different: {
						field: 'contrasena',
						message: 'el usuario no puede ser igual que la contrasena'
					}
				}
			},
			contrasena: {
				validators: {
					notEmpty: {
						message: 'la contraseña es obligatoria'
					},
					stringLength: {
						min: 4,
						max: 30,
						message: 'la contrasena debe ser entre 4 y 30 caracteres'
					},
					different: {
						field: 'usuario',
						message: 'la contrasena debe ser distinta al usuario'
					}
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: 'Email necesario'
					},
					emailAddress: {
						message: 'no es un email valido, ingrese nuevamente'
					}
				}
			},
			user_telefono: {
				validators: {
					notEmpty: {
						message: 'Telefono o Celular Necesario'
					},
					digits: {
						message: 'Solo numeros'
					},
					minlength: {
						message: 'minimo debe tener 6 digitos'
					}
				}
			},
			placa: {
				validators: {
					notEmpty: {
						message: 'Nro de Placa es obligatorio'
					},
					stringLength: {
						min: 6,
						max: 6,
						message: 'Nro de placa contiene 6 caracteres'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9]+$/,
						message: 'aqui solo se permiten letras y numeros'
					}
				}
			},
			denuncia: {
				validators: {
					notEmpty: {
						message: 'Texto requerido'
					}
				}
			}
		}
		}).on('success.field.bv', function(e, data) {
		// $(e.target)  --> The field element
		// data.bv      --> The BootstrapValidator instance
		// data.field   --> The field name
		// data.element --> The field element
		
		var $parent = data.element.parents('.form-group');
		
		// Remove the has-success class
		$parent.removeClass('has-success');
		
		
		// Hide the success icon
		//$parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
		}).on('error.form.bv', function(e) {
		isValid = false;
	});
	
	
	
});
