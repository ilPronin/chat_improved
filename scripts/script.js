function toggleImage(){
    let image = document.getElementById('toggleImage');
    let addUserComponent = document.getElementById('addUserComponent');
    if (image.src === 'http://chatoop/assets/icons/plus.png'){
        image.src = '/assets/icons/minus.png';
        addUserComponent.classList.remove('hidden');
    } else if (image.src === 'http://chatoop/assets/icons/minus.png'){
        image.src = '/assets/icons/plus.png';
        addUserComponent.classList.add('hidden');
    }
}