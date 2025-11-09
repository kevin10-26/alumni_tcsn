'use strict'

const postsViews = {};

const editor = new EditorJS({
    holder: 'channel-editor',
    readOnly: false,
    placeholder: 'Un mot à dire ?',

    tools: {

        List: {
            class: EditorjsList,
            inlineToolbar: true,
            config: {
              defaultStyle: 'unordered'
            },
        },

        attaches: {
            class: AttachesTool,
            config: {
              endpoint: './channels/post/uploadFile/attachment',
            }
        },

        image: {
            class: ImageTool,
            config: {
              endpoints: {
                byFile: './channels/post/uploadFile/picture',
              }
            }
        }
    },

    onReady: () => {
        console.debug('Editor ready!');
    }
});

const sendPost = async (e, channelId) => {
    e.preventDefault();

    editor.save().then(async (content) => {
       let authManager = new AuthManager();

       let xhr = await authManager.makeAuthenticatedRequest('./channels/post/send', {
            method: 'POST',
            headers: {
                "Content-Type": 'application/json'
            },
            body: JSON.stringify({
                channelId: channelId,
                postContent: content
            })
        });

        let response = await xhr.json();

        if (response.status === 200)
        {
            refreshPosts(channelId);
        } else {
            console.error('Can\'t save your post.');
        }

        // Snackbar
    });
}

const refreshPosts = async (channelId) => {
    let authManager = new AuthManager(),
        postsContainer = 'posts-list';

    let xhr = await authManager.makeAuthenticatedRequest('./channels/post/refresh', {
        method: 'POST',
        header: {
            "Content-Type": 'text/html'
        },
        body: JSON.stringify({channelId: channelId})
    });

    let response = await xhr.text();

    let frontend = new Frontend();
    frontend.replace(postsContainer, response);

    const posts = document.getElementById(postsContainer);
    const contentNodes = posts.querySelectorAll('[id^="post-"][id$="-content"]');
    
    for (const node of contentNodes) {
        let data;
        try {
            data = JSON.parse(node.textContent.trim());
        } catch (e) {
            console.error('Invalid post content JSON for', node.id, e);
            continue;
        }
        // Clear raw JSON text before rendering
        node.textContent = '';
        Object.assign(postsViews, {
            [node.id]: {
                editor: createReadOnlyEditor(data, node.id),
                originalContent: data
            }
        });
    }

    // snackbar.
}

const createReadOnlyEditor = (content, holder) => {
    return new EditorJS({
        holder: holder,
        readOnly: true,
        tools: {
            List: {
                class: EditorjsList,
                inlineToolbar: true,
                config: {
                  defaultStyle: 'unordered'
                },
            },
    
            attaches: {
                class: AttachesTool,
                config: {
                  endpoint: './channels/post/uploadFile/attachment',
                }
            },
    
            image: {
                class: ImageTool,
                config: {
                  endpoints: {
                    byFile: './channels/post/uploadFile/picture',
                  }
                }
            }
        },
        data: content
    });
}

const editChannelPost = async (nodeId, channelId, postId) => {
    postsViews[nodeId].editor.readOnly.toggle();
    let savedContent;

    const post = document.getElementById(nodeId);
    post.classList.add('bg-gray-50', 'p-4');

    const handleFocusOut = async (event) => {
        const relatedTarget = event.relatedTarget;

        if (!relatedTarget || !post.contains(relatedTarget)) {
            console.debug('Editor lost focus, saving...');

            postsViews[nodeId].editor.readOnly.toggle();
            post.classList.remove('bg-gray-50', 'p-4');
        }
    };

    const handleEscape = (event) => {
        if (event.key === 'Escape') handleFocusOut(event);
    };

    document.addEventListener('keyup', handleEscape);

    const handleEnter = async (event) => {
        if (event.key === 'Enter') {
            console.debug('here');

            let authManager = new AuthManager(),
                xhr = await authManager.makeAuthenticatedRequest(`./channels/post/update/${channelId}`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        channelId: channelId,
                        postId: postId,
                        postContent: await postsViews[nodeId].editor.save().then((content) => {return content})
                    })
                });

            let response = await xhr.json();
            // snackbar            

            handleFocusOut(event);

            post.removeEventListener('keyup', handleEnter);
        }
    };

    post.addEventListener('keyup', handleEnter);
}

const deletePost = async (postId, channelId) => {
    if (confirm('Voulez-vous supprimer cette publication ? Cette action est irréversible.'))
    {
        let authManager = new AuthManager();
        let xhr = await authManager.makeAuthenticatedRequest('./channels/post/remove', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                postId, postId,
                channelId: channelId
            })
        });

        let response = await xhr.json();
        console.debug(response);

        if(response.status === 200)
        {
            refreshPosts(channelId);
        }

        // snackbar
    }
}