(function(window, angular) {
	
	//Module
	var app = angular.module('TextToSpeechApp', []);
	
	//Directives
	app.directive('textToSpeech', function() {
		return {
			restrict: 'A',
			templateUrl: 'templates/text-to-speech.html',
			/*
			link: function($scope, $element, $attrs) {
				
			},
			*/
			controller: function($scope, $element, $attrs, $transclude) {
				
				$scope.supported = 'Supported: ' + ('speechSynthesis' in window);
				
				var voices;
				var voiceSelect = $('#voice');
				var languageSelect = $('#language');
				
				var langVector = [
                    "en-UK",
					"en-US",
					"de-DE",
					"es-ES",
					"fr-FR",
					"it-IT"
				];
				
				$scope.volume = 1;
				$scope.rate = 1;
				$scope.pitch = 1;
				
				var moduleText = function(source, result, mod) {
					
					if (source.length > mod) {
						
						var splitLen = 2;
						
						var index = source.lastIndexOf('. ', mod);
						if (index === -1) {
							index = source.lastIndexOf(', ', mod);
							if (index === -1) {
								index = source.lastIndexOf(' ', mod);
								splitLen = 1;
							}
						}
						
						if (index > 0) {
							result.push(source.substring(0, index + splitLen));
							moduleText(source.substring(index + splitLen), result, mod);
						} else {
							result.push(source);
						}
					} else {
						result.push(source);
					}
					
					return result;
				};
				
				var readText = function(value, lang) {
					console.log('readText:', value, value.length);
					var msg = new SpeechSynthesisUtterance();
					
					msg.text = value;
					msg.lang = lang;
					
					msg.volume = parseFloat($scope.volume); // 0 to 1
					msg.rate = parseFloat($scope.rate); // 0.1 to 10
					msg.pitch = parseFloat($scope.pitch); //0 to 2
					
					msg.voice = voiceSelect[0].value;
					//msg.voiceURI = voiceSelect[0].value;
					
					msg.onend = function(event) {
						//console.log('onEndMesg');
					};
					
					window.speechSynthesis.speak(msg);
					
				};
				
				var loadVoices = function() {
					voices = window.speechSynthesis.getVoices();
					
					voices.forEach(function(voice, i) {
						var option = $('<option>');
						option.html(voice.name);
						voiceSelect.append(option);
					});
					
				};

				$scope.onClick = function(event) {
					var messages = moduleText( $('#input-text')[0].value, [], 430 );
					
					for ( var i = 0; i < messages.length; i++) {
						readText(messages[i], languageSelect[0].value);
					}
				};
				
				$scope.onCancelClick = function(event) {
					window.speechSynthesis.cancel();
				};
				
				if (window.speechSynthesis !== undefined) {
					window.speechSynthesis.onvoiceschanged = function(event) {
						loadVoices();
					};
				}
				
				var init = function() {
					
					$.each(langVector, function(index, value) {
						var option = $('<option>');
						option.html(value);
						languageSelect.append(option);
					});
					
				};
				
				init();
				
			},
			replace: true
		};
	});
	
	
	//Controllers
	app.controller('MainController', function ($scope) {
		
	});
	
	
})(window, window.angular);