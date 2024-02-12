let barToast = {
    success: function(config){
        let toastBackground = document.createElement('div');
        let toastContainer  = document.createElement('div');
        let toastBody       = document.createElement('div');
    
        let toastIcon       = document.createElement('div');
        let toastText       = document.createElement('div');
    
        toastBackground .appendChild(toastContainer);
        toastContainer  .appendChild(toastBody);
        toastBody       .appendChild(toastIcon);
        toastBody       .appendChild(toastText);

        if(config.position == 'top'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.top       = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else if(config.position == 'bottom'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else{
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }

        toastText.innerText = config.text;
        toastIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Checkmark</title><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M416 128L192 384l-96-96"/></svg>`;
    
        toastContainer.setAttribute("style",`max-width: 300px; min-width: 210px; overflow: hidden; background-color: ${config.bgColor ? config.bgColor : 'white'}; color: ${config.color}; box-shadow: 0px 1px 2px 0px #0000000d; border-left: 5px solid #3BE234; border-radius: 5px`);
        toastBody     .setAttribute("style","height: 100%; box-sizing: border-box; padding: 10px; display: flex; align-items: center;");
        toastText     .setAttribute("style","font-size: 15px; font-family: Arial; margin-left: 10px");
        toastIcon     .setAttribute("style","width: 15px; min-width: 15px; height: 15px; min-height: 15px; padding: 3px; border-radius: 50%; background-color: #3BE234");
    
        let parent = config.parent ? document.getElementById(config.parent) : document.body;
        parent.appendChild(toastBackground);

        setTimeout(()=>{
            toastBackground.remove();
        }, 3000);
    },

    error: function(config){
        let toastBackground = document.createElement('div');
        let toastContainer  = document.createElement('div');
        let toastBody       = document.createElement('div');
    
        let toastIcon       = document.createElement('div');
        let toastText       = document.createElement('div');
    
        toastBackground .appendChild(toastContainer);
        toastContainer  .appendChild(toastBody);
        toastBody       .appendChild(toastIcon);
        toastBody       .appendChild(toastText);

        if(config.position == 'top'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.top       = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else if(config.position == 'bottom'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else{
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }

        toastText.innerText = config.text;
        toastIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Close</title><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>`;
    
        toastContainer  .setAttribute("style",`max-width: 300px; min-width: 210px; overflow: hidden; background-color: ${config.bgColor ? config.bgColor : 'white'}; color: ${config.color}; box-shadow: 0px 1px 2px 0px #0000000d; border-left: 5px solid #E23434; border-radius: 5px`);
        toastBody       .setAttribute("style","height: 100%; box-sizing: border-box; padding: 10px; display: flex; align-items: center;");
        toastText       .setAttribute("style","font-size: 15px; font-family: Arial; margin-left: 10px");
        toastIcon       .setAttribute("style","width: 15px; min-width: 15px; height: 15px; min-height: 15px; padding: 3px; border-radius: 50%; background-color: #E23434");
    
        let parent = config.parent ? document.getElementById(config.parent) : document.body;
        parent.appendChild(toastBackground);

        setTimeout(()=>{
            toastBackground.remove();
        }, 3000);
    },

    info: function(config){
        let toastBackground = document.createElement('div');
        let toastContainer  = document.createElement('div');
        let toastBody       = document.createElement('div');
    
        let toastIcon       = document.createElement('div');
        let toastText       = document.createElement('div');
    
        toastBackground .appendChild(toastContainer);
        toastContainer  .appendChild(toastBody);
        toastBody       .appendChild(toastIcon);
        toastBody       .appendChild(toastText);

        if(config.position == 'top'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.top       = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else if(config.position == 'bottom'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else{
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }

        toastText.innerText = config.text;
        toastIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Information</title><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="40" d="M196 220h64v172"/><path fill="none" stroke="white" stroke-linecap="round" stroke-miterlimit="10" stroke-width="40" d="M187 396h138"/><path fill="white" d="M256 160a32 32 0 1132-32 32 32 0 01-32 32z"/></svg>`;
    
        toastContainer  .setAttribute("style",`max-width: 300px; min-width: 210px; overflow: hidden; background-color: ${config.bgColor ? config.bgColor : 'white'}; color: ${config.color}; box-shadow: 0px 1px 2px 0px #0000000d; border-left: 5px solid #34C1E2; border-radius: 5px`);
        toastBody       .setAttribute("style","height: 100%; box-sizing: border-box; padding: 10px; display: flex; align-items: center;");
        toastText       .setAttribute("style","font-size: 15px; font-family: Arial; margin-left: 10px");
        toastIcon       .setAttribute("style","width: 15px; min-width: 15px; height: 15px; min-height: 15px; padding: 3px; border-radius: 50%; background-color: #34C1E2");
    
        let parent = config.parent ? document.getElementById(config.parent) : document.body;
        parent.appendChild(toastBackground);

        setTimeout(()=>{
            toastBackground.remove();
        }, 3000);
    },

    warning: function(config){
        let toastBackground = document.createElement('div');
        let toastContainer  = document.createElement('div');
        let toastBody       = document.createElement('div');
    
        let toastIcon       = document.createElement('div');
        let toastText       = document.createElement('div');
    
        toastBackground .appendChild(toastContainer);
        toastContainer  .appendChild(toastBody);
        toastBody       .appendChild(toastIcon);
        toastBody       .appendChild(toastText);

        if(config.position == 'top'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.top       = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else if(config.position == 'bottom'){
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }
        else{
            toastBackground.style.position  = "absolute";
            toastBackground.style.left      = "50%";
            toastBackground.style.bottom    = "5%";
            toastBackground.style.transform = "translate(-50%, -5%)";
        }

        toastText.innerText = config.text;
        toastIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Alert</title><path d="M256 80c-8.66 0-16.58 7.36-16 16l8 216a8 8 0 008 8h0a8 8 0 008-8l8-216c.58-8.64-7.34-16-16-16z" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="416" r="16" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>`;
    
        toastContainer  .setAttribute("style",`max-width: 300px; min-width: 210px; overflow: hidden; background-color: ${config.bgColor ? config.bgColor : 'white'}; color: ${config.color}; box-shadow: 0px 1px 2px 0px #0000000d; border-left: 5px solid #F9C83D; border-radius: 5px`);
        toastBody       .setAttribute("style","height: 100%; box-sizing: border-box; padding: 10px; display: flex; align-items: center;");
        toastText       .setAttribute("style","font-size: 15px; font-family: Arial; margin-left: 10px");
        toastIcon       .setAttribute("style","width: 15px; min-width: 15px; height: 15px; min-height: 15px; padding: 3px; border-radius: 50%; background-color: #F9C83D");
    
        let parent = config.parent ? document.getElementById(config.parent) : document.body;
        parent.appendChild(toastBackground);

        setTimeout(()=>{
            toastBackground.remove();
        }, 3000);
    },
}