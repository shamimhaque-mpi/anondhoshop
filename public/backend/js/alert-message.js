class Message {
	constructor() {
		console.log('API-V1.0 (alert-message)');
	}

	// Success Message
	success(title) {
		Message.process(title, 'success');
	}

	// Warning Message
	warning(title) {
		Message.process(title, 'warning');
	}

	//Processing Message
	static process(title, smg_type) {
		let type = '';
		if(smg_type == 'success') {
			type = 'success';
		}
		else if(smg_type == 'warning') {
			type = 'warning';
		}
		let alert_content = `
			<div class="alert-message ${type}">
				<div class="message">
					<h3>
						<span class="text"> ${title} </span>
					</h3>
					<span class="time-label-aria"></span>
					<span class="time-label"></span>
				</div>
			</div>
		`;
		Message.oldMessageRemove();
		Message.append(alert_content);
		Message.timeContorl();
	}

	//Append in the body
	static append(content) {
		let element 		= document.createElement('div');
		let body 			= document.querySelector('body');

		element.innerHTML 	= content;
		body.append(element);

	}

	// Delete old message box
	static oldMessageRemove() {
		let alert_message = document.querySelector('.alert-message');
		if(alert_message) {
			alert_message.parentElement.remove();
		}
	}

	// Message time control
	static timeContorl() {
		let alert_message = document.querySelector('.alert-message');
		let time_label = document.querySelector('.time-label');
		if(time_label) {
			let width 		= 100;
			let strage 		= 0;

			let interval 	= setInterval(()=>{
				strage += 1;

				time_label.style.width = (width-=11)+'%';
				alert_message.style.opacity = 1 - (strage/10);

				if(strage == 11){
					alert_message.parentElement.remove();
					clearInterval(interval);
				}
			}, 500);
		}

	}
}
