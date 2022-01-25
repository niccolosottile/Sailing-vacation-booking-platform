const storageType = sessionStorage;
const consentPropertyName = 'edenj_consent';

const shouldShowPopup = () => !storageType.getItem(consentPropertyName);
const saveToStorage = () => storageType.setItem(consentPropertyName, true);

window.onload = () => {
    const consentPopup = document.getElementById('consent-popup');
    const acceptBtn = document.getElementById('accept');
    
    const acceptFn = event => {
        saveToStorage(sessionStorage);
        consentPopup.classList.add('hidden');
    };
    
    acceptBtn.addEventListener('click', acceptFn);
    
    if(shouldShowPopup(storageType)){
        setTimeout(() => {
            consentPopup.classList.remove('hidden');
        }, 2000);

    }
}