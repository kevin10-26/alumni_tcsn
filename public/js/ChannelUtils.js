'use strict'

const leaveChannel = async (channelId, container = null) => {
    if (confirm('Vous vous apprêtez à quitter ce channel. Si vous confirmez, vous pourrez le rejoindre à nouveau à tout moment.'))
    {
        let authManager = new AuthManager() ?? null;
        if (authManager === null)
        {
            console.error('Fatal error: Not all libraries are loaded.');
            let snackbar = new Snackbar();

            snackbar.init({
                'msg': 'Erreur fatale. Rechargez la page ou contacter l\'administrateur si l\'erreur persiste (code: ASYNC-MISSING-01)',
                'state': 'error',
                'ttl': 5000
            });
        } else {
            let xhr = new AuthManager(),
                request = await xhr.makeAuthenticatedRequest('/channels/actions/quit', {
                    method: 'POST',
                    header: {
                        "Content-Type": 'application/json'
                    },
                    body: JSON.stringify({targetedChannel: channelId})
                });

            let response = await request.json();

            if (response.status)
            {
                if (container === null)
                {
                    window.location.href = './channels/list';
                    return false;
                }

                snackbar.init({
                    'msg': 'Vous avez quitté le channel ' + channelName,
                    'state': 'success',
                    'ttl': 5000
                });

                reloadContainer({
                    endpoint: './api/channels/list',
                    targetedNode: container
                });

            } else {
                snackbar.init({
                    'msg': 'Erreur : veuillez réessayer',
                    'state': 'error',
                    'ttl': 5000
                });
            }
        }
    }    
}

const joinChannelConfirmation = async (channelName) => {
    if (confirm('Voulez-vous rejoindre ce channel ?'))
    {
        let authManager = new AuthManager() ?? null;
        if (authManager === null)
        {
            console.error('Fatal error: Not all libraries are loaded.');
            let snackbar = new Snackbar();

            snackbar.init({
                'msg': 'Erreur fatale. Rechargez la page ou contacter l\'administrateur si l\'erreur persiste (code: ASYNC-MISSING-01)',
                'state': 'error',
                'ttl': 5000
            });
        } else {
            console.debug(channelName);
            let xhr = new AuthManager(),
                request = await xhr.makeAuthenticatedRequest('/channels/actions/join', {
                    method: 'POST',
                    header: {
                        "Content-Type": 'application/json'
                    },
                    body: JSON.stringify({targetedChannel: channelName})
                });

            let response = await request.json();

            if (response.status)
            {
                window.location.href = './channels/' + response['channelId'];

            } else {
                snackbar.init({
                    'msg': 'Erreur : veuillez réessayer',
                    'state': 'error',
                    'ttl': 5000
                });
            }
        }
    }
}

const updateChannelData = async(e, channelId) =>
{
    if (e.key !== 'Enter')
    {
        return false;
    }

    let authManager = new AuthManager() ?? null;
    if (authManager === null)
    {
        console.error('Fatal error: Not all libraries are loaded.');
        let snackbar = new Snackbar();

        snackbar.init({
            'msg': 'Erreur fatale. Rechargez la page ou contacter l\'administrateur si l\'erreur persiste (code: ASYNC-MISSING-01)',
            'state': 'error',
            'ttl': 5000
        });
    } else {
        let xhr = await authManager.makeAuthenticatedRequest('./channels/update', {
            method: 'POST',
            header: {
                "Content-Type": 'application/json'
            },
            body: JSON.stringify({
                targetedChannel: channelId,
                field: e.target.name,
                value: e.target.value
            })
        });

        let response = await xhr.json();

        snackbar.init({
            'msg': response.msg,
            'state': response.state,
            'ttl': 5000
        });
    }
}

const updateChannelThumbnail = async(e, channelId) => {

    let authManager = new AuthManager() ?? null;
    if (authManager === null)
    {
        console.error('Fatal error: Not all libraries are loaded.');
        let snackbar = new Snackbar();

        snackbar.init({
            'msg': 'Erreur fatale. Rechargez la page ou contacter l\'administrateur si l\'erreur persiste (code: ASYNC-MISSING-01)',
            'state': 'error',
            'ttl': 5000
        });
    } else {
        
        let thumbnail = new FormData();
        thumbnail.append('file', e.target.files[0]);
        thumbnail.append('targetedChannel', channelId);

        let xhr = await authManager.makeAuthenticatedRequest('./channels/update-thumbnail', {
            method: 'POST',
            header: {
                "Content-Type": 'multipart/form-data'
            },
            body: thumbnail
        });

        let response = await xhr.json();

        if (response.status === 200)
        {
            document.getElementById('thumbnail-settings-preview').src = response.relativePath;
        }

        snackbar.init({
            'msg': response.msg,
            'state': response.state,
            'ttl': 5000
        });
    }
}

const openChannelDeletion = () => {
    let frontend = new Frontend();
    
    frontend.openModal('confirm-channel-deletion');
}

const deleteChannel = async (e, channelId) => {
    e.preventDefault();

    let authManager = new AuthManager();

    let xhr = await authManager.makeAuthenticatedRequest('./channels/actions/remove', {
        method: 'POST',
        header: {
            "Content-Type": 'application/json'
        },
        body: JSON.stringify({
            targetedChannel: channelId,
            userPassword: document.getElementById('remove-channel-user-password').value
        })
    });

    let response = await xhr.json();

    if (response.status === 200 && response.channelHasBeenRemoved)
    {
        window.location.href = './channels/list#channelRemoved';

    } else {
        snackbar.init({
            'msg': response.msg,
            'state': response.state,
            'ttl': 5000
        });
    }
}

const openPostReportModal = (postId) => {
    console.debug(postId);
    let frontend = new Frontend();
    frontend.openModal('create-report-post');

    document.getElementById('report-channel-post-id').value = postId;
}

const checkIfOther = (e, otherInputId) => {
    document.getElementById(otherInputId).style.display = (e.target.selectedOptions[0].value === 'Autre') ? 'block' : 'none';
}

const moveToChannelPosts = postId => {
    let frontend = new Frontend();
    frontend.openTab('channel-tablink', 'channel-tabcontent', 'overview');

    let postElement = document.getElementById(`post-card-${postId}`);
    postElement.scrollIntoView({behavior: 'smooth'});

    postElement.animate([
        { boxShadow: '0 0 0px rgba(0,0,0,0)' },
        { backgroundColor: 'transparent' },
        { boxShadow: '0 0 10px rgba(41, 37, 36, 0.8)' }, // bg-stone-800
        { backgroundColor: 'rgb(243 244 246)' }, // bg-gray-100
        { backgroundColor: 'rgb(229 231 235)' }, // bg-gray-200
        { boxShadow: '0 0 10px rgba(41, 37, 36, 0.8)' }, // bg-stone-800
        { backgroundColor: 'transparent' },
        { boxShadow: '0 0 0px rgba(0,0,0,0)' }
    ], {
        duration: 2000,
        iterations: 1,
        easing: 'ease-in-out'
    });
}

const withdrawUserFromChannel = async (userId, channelId, isBan) => {
    if (confirm('Cette action est irréversible.'))
    {
        let xhr = new AuthManager(),
            request = await xhr.makeAuthenticatedRequest('/channels/actions/quit', {
                method: 'POST',
                header: {
                    "Content-Type": 'application/json'
                },
                body: JSON.stringify({
                    userId: userId,
                    targetedChannel: channelId
                })
            });

        let response = await request.json();

        if (response.status)
        {
            (isBan) ? document.getElementById(`membership-card-${userId}`).remove() : window.location.href = './channels/list/#left';
            return false;
        }
    }
}