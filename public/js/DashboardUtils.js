'use strict'

function modifyUserField(fieldId) {
    const field = document.getElementById(fieldId);

    // Only add the listener once
    if (!field.dataset.listenerAdded) {
        field.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                field.blur();
            }
        });
        field.dataset.listenerAdded = 'true';
    }

    field.contentEditable = true;
    field.classList.add('bg-gray-50', 'border-solid', 'border-2', 'border-gray-400');
    field.focus();

    const handleBlur = (event) => {
        field.contentEditable = false;
        field.classList.remove('bg-gray-50', 'border-2', 'border-gray-400');
        field.removeEventListener('blur', handleBlur);

        updateUserProfile(event); // pass the fieldId
    };

    field.addEventListener('blur', handleBlur);
}

const checkPasswordsMatchBeforeSubmitting = e => {
    if (e.key === 'Enter')
    {
        if (document.getElementById('settings-password').value === document.getElementById('settings-confirm-password').value && e.target.value.length > 6)
        {
            updateUserProfile(e);
        } else {
            // snackbar (password must match and be at least 6-char long)
        }
    }
}

const updateUserAvatar = async (e) => {
    let formData = new FormData();
    formData.append('avatar', e.target.files[0]);

    let authManager = new AuthManager();
    let xhr = await authManager.makeAuthenticatedRequest('./dashboard/user/updateAvatar', {
        method: 'POST',
        body: formData
    });

    const response = await xhr.json();
    document.getElementById('user-avatar-dashboard').src = response.avatarPath;
    //snackbar
}

const updateUserProfile = async (e) => {
    const target = e.target;
    const isCheckbox = target.type === 'checkbox';

    const value = isCheckbox
        ? target.checked
        : (target.value ?? target.textContent);

    let authManager = new AuthManager();
    let xhr = await authManager.makeAuthenticatedRequest('./dashboard/user/update', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            field: target.id,
            value: value
        })
    });

    const response = await xhr.json();
    // snackbar
};

const gatherUserData = async () => {
    let authManager = new AuthManager();
    let xhr = await authManager.makeAuthenticatedRequest('./legal/portability', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
    });

    const response = await xhr.text();
    document.getElementById('portability-document').innerHTML = response;
}

const deactivateAccount = async (e) => {

    let numberOfDays = prompt('Entrez le nombre de jours pendant lesquels votre compte sera désactivé.');

    if (parseInt(numberOfDays) === NaN)
    {
        alert('Veuillez recommencer et entrer un nombre valide');

    } else {
        let authManager = new AuthManager();
        let xhr = await authManager.makeAuthenticatedRequest('./dashboard/user/deactivate', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                daysDeactivated: numberOfDays
            })
        });

        let response = await xhr.json();
        if (response.status === 200)
        {
            window.location.href = './login';
        } else {
            // snackbar, it failed
        }
    }
}