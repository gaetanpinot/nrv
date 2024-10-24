
export const URL_API = 'http://localhost:44010';


function signupUser(fullName, email, password) {
    console.log("signining")
    fetch(URL_API + URI_SIGNUP, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ fullName, email, password })
    })
    .then(resp => resp.json())
    .then(data => {
        if (data.success) {
            console.log('Signup successful', data);
            window.location.href = '/dashboard';
        } else {
            console.error('Signup failed', data.message);
            alert('Signup failed ' + data.message);
        }
    })
    .catch(err => console.error('Signup failed:', err));
}


export function compteMain(){
    console.log("compte");
    const loginButton = document.getElementById('login-btn');
    const signupButton = document.getElementById('signup-btn');

    const signupForm = document.getElementById("signup-form");

    loginButton.addEventListener('click', showLogin);
    signupButton.addEventListener('click', showSignup);

    signupForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const fullName = signupForm.querySelector("input[type='text']").value;
        const email = signupForm.querySelector("input[type='email']").value;
        const password = signupForm.querySelector("input[type='password']").value;

        signupUser(fullName, email, password);
    });

    function showLogin() {
        document.getElementById('login-form').classList.add('active');
        document.getElementById('signup-form').classList.remove('active');
        document.getElementById('login-btn').classList.add('active');
        document.getElementById('signup-btn').classList.remove('active');
    }
    
    function showSignup() {
        document.getElementById('signup-form').classList.add('active');
        document.getElementById('login-form').classList.remove('active');
        document.getElementById('signup-btn').classList.add('active');
        document.getElementById('login-btn').classList.remove('active');
    }

    
}
