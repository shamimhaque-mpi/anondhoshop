import Vue from 'vue';


class Message {
	constructor() {
		console.log('API-V1.0 (alert-message)');
		Vue.prototype.$message = Message.result();
		return Message.result();
	}

	// Success Message
	static success(title) {
		Message.process(title, 'success');
	}

	// Warning Message
	static warning(title) {
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

	// Result 
	static result() {
		return { 
			success: (x)=>{ this.success(x);},
			warning: (x)=>{ this.warning(x);},
		}
	}
}


export const alert_message = new Message();

window.success = function success(title){
	alert_message.success(title);
}
window.warning = function warning(title){
	alert_message.warning(title);
}