



// radio 
let radio = document.querySelectorAll('input[name=api-mode]');
// API mode
let apidiv = document.getElementById('apistatus');
let tipodc = document.getElementById('tipodc');
// Manual mode
let manual = document.getElementById('manual');
// Redondeo
let redon = document.getElementById('redond');
let alcanc = document.getElementById('alcance');

for (let index = 0; index < radio.length; index++) {
    radio[index].addEventListener('click',function(){
       
        if(radio[index].value=='api'){
       
            apidiv.classList.remove('hide');
            tipodc.classList.remove('hide');
            redon.classList.remove('hide');
            alcanc.classList.remove('hide');
            manual.classList.add('hide');
            
        }
        if(radio[index].value=='manual'){
            apidiv.classList.add('hide');
            tipodc.classList.add('hide');
            manual.classList.remove('hide');
            redon.classList.remove('hide');
            alcanc.classList.remove('hide');
        }
        if(radio[index].value=='disabled'){
            apidiv.classList.add('hide');
            tipodc.classList.add('hide');
            manual.classList.add('hide');
            redon.classList.add('hide');
            alcanc.classList.add('hide');
        }
    });
    
}

 