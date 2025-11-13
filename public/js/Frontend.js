class Frontend
{
    openModal(modalId)
    {
        let targetedModal = document.getElementById(modalId);
        targetedModal.style.display = 'block';

        document.getElementById('close-' + modalId).onclick = () => targetedModal.style.display = 'none';
        
        return {
            'openedAt': Date.now(),
            'obj': this,
            'state': this.#getState(modalId)
        }
    }

    openTab(tablinks, tabcontent, tabName)
    {
        let tablinksNodes = document.getElementsByClassName(tablinks),
            tabcontentNodes = document.getElementsByClassName(tabcontent),
            i;

        for(i = 0; i < tablinksNodes.length; i++)
        {
            tablinksNodes[i].classList.remove(tablinks + "-active");
        }

        for(i = 0; i < tabcontentNodes.length; i++)
        {
            tabcontentNodes[i].style.display = 'none';
        }

        let targetedTab = document.getElementById(tabName);
        
        targetedTab.style.display = 'block';

        return {
            'tab': targetedTab,
            'obj': this
        };
    }
    
    /**
     * Fills an element with HTML content only.
     * 
     * For plain text:
     * @see this addText()
     * 
     * @param {int} nodeId : the node to fill the HTML in
     * @param {string} data : the HTML data to fill.
     */
    fill(nodeId, data)
    {
        this.emptyNode(`#${nodeId}`);
        document.getElementById(nodeId).innerHTML = data;
    }

    replace(nodeId, data)
    {
        const node = document.getElementById(nodeId);
        if (typeof data === 'string') {
            // Replace the entire element with parsed HTML string (not a text node)
            node.outerHTML = data;
        } else {
            node.replaceWith(data);
        }
    }

    addText(nodeId, data)
    {
        document.getElementById(nodeId).textContent = data;
    }
    
    emptyNode(nodeId)
    {
        let node = document.querySelector(nodeId);
        while (node.lastChild)
        {
            node.removeChild(node.lastChild);
        }
    }

    #getState(nodeId)
    {
        return {
            'open': () => document.getElementById(nodeId).style.display = 'block',
            'close': () => document.getElementById(nodeId).style.display = 'none'
        }
    }
}