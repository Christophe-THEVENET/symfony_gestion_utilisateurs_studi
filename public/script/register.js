// ***************** COMPARAISON DES MOTS DE PASSE ***************************

let form = document.querySelector('#register-form');
let button = document.querySelector('#register-button');

function checkPassword() {
  let pass1 = document.querySelector('#registration_form_plainPassword').value;
  let pass2 = document.querySelector('#verifpass').value;
  let alert = document.querySelector('#alert');

  if (pass1.length != 0) {
    if (pass1 != pass2) {
      alert.style.display = 'block';
      setTimeout(() => {
        alert.style.display = 'none';
      }, 3000);
      return true;
    }
  }
}

button.addEventListener('click', (e) => {
  checkPassword();

  if (checkPassword()) {
    e.preventDefault();
  }
});

// ***************** AFFICHER / CACHER MOT DE PASSE ***************************

// vérification mot de passe 1

let input1 = document.querySelector('.mdp1 input');
let showBtn1 = document.querySelector('.mdp1 i');

showBtn1.addEventListener('click', (e) => {
  if (input1.type === 'password') {
    input1.type = 'text';
    showBtn1.classList.add('active');
  } else {
    input1.type = 'password';
    showBtn1.classList.remove('active');
  }
});

// vérification mot de passe 2

let input2 = document.querySelector('.mdp2 input');
let showBtn2 = document.querySelector('.mdp2 i');

showBtn2.addEventListener('click', (e) => {
  if (input2.type === 'password') {
    input2.type = 'text';
    showBtn2.classList.add('active');
  } else {
    input2.type = 'password';
    showBtn2.classList.remove('active');
  }
});

// ***************** ALERT PSEUDO DEJA PRIS ***************************



let alertPseudo = document.querySelector('#register-form li');

if ((alertPseudo.style.display = 'block')) {
  setTimeout(() => {
    alertPseudo.style.display = 'none';
    let alertPseudoInput = document.querySelector('#registration_form_username');
    alertPseudoInput.value = '';
    alertPseudoInput.reset();
  }, 3000);
}
