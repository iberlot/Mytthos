/* Text Reader v. 1.0 by Matthew M. */
$.textReader = {
	
	'init': function (settings){
		
		if(typeof settings === 'undefined'){
			
			settings = {};
		}
		
		$('body').prepend('<div id="text-reader-root"><audio id="text-reader-player" type="audio/mpeg"></audio></div>');
		
		if((settings.volume !== undefined) || (settings.volume >= 0) && (settings.volume <= 1)){
			
			$.textReader.setVolume(settings.volume);
		}
		else{
			
			$.textReader.setVolume($.textReader.settings.volume);
		}
		
		if(settings.speed !== undefined){
			
			$.textReader.setSpeed(settings.speed);
		}
		else{
			
			$.textReader.setSpeed($.textReader.settings.speed);
		}
		
		if(settings.muted !== undefined){
			
			if(settings.muted == true){
				
				$.textReader.mute();
			}
			else if(settings.muted == false){
				
				$.textReader.unmute();
			}
		}
		else{
			
			if($.textReader.settings.muted == true){
				
				$.textReader.mute();
			}
			else if($.textReader.settings.muted == false){
				
				$.textReader.unmute();
			}
		}
	},
	'read': function (text, lang, oncomplete){
		
		player = $.textReader.player();
		
		//player.pause();
		player.src = '';
		
		player.src = '../reader.php?text='+text+'&lang='+lang;
		
		function onendedfn(){
			
			player.removeEventListener('ended', onendedfn);
			
			player.pause();
			player.src = '';
			
			if(typeof oncomplete === 'function'){
				
				oncomplete();
			}
		}
		
		endedEventListener = player.addEventListener('ended', onendedfn);
		
		player.play();
	},
	'player': function (){
		
		return document.getElementById('text-reader-player');
	},
	'setVolume': function (value){
		
		$.textReader.player().volume = value;
		$.textReader.settings.volume = value;
	},
	'setSpeed': function (value){
		
		$.textReader.player().defaultPlaybackRate = value;
		$.textReader.settings.speed = value;
	},
	'mute': function (){
		
		$.textReader.player().volume = 0;
		$.textReader.settings.muted = true;
		
	},
	'unmute': function (){
		
		$.textReader.player().volume = $.textReader.settings.volume;
		$.textReader.settings.muted = false;
	},
	'settings': {
		
		'volume': 0.5,
		'muted': false,
		'speed': 1
	}
}