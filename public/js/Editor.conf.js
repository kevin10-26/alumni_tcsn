const editor = new EditorJS({
    holder: 'privacy-question-content',
    readOnly: false,

    tools: { 
        header: {
          class: Header, 
          inlineToolbar: ['link'] 
        },

        List: {
            class: EditorjsList,
            inlineToolbar: true,
            config: {
              defaultStyle: 'unordered'
            },
        }
    },

    placeholder: 'Entrez le contenu de votre demande',

    onReady: () => {
        console.debug('Editor ready!');
    }
});