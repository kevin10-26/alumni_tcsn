'use strict'

class ElementCreator
{
    #node;
    #nodeCreatedAt;

    generate(data)
    {
        this.#create(data['element']);
        this.#node.classList.add(...data['classes']);

        return this.#getNodeData();
    }

    append(container, node)
    {
        container = document.querySelector(container);
        
        if (typeof container !== undefined || typeof node['node'] !== undefined)
        {
            container.appendChild(node['node']);
        } else {
            console.error('The nodes are undefined.');
        }
    }

    #create(nodeName)
    {
        this.#node = document.createElement(nodeName);
        this.#nodeCreatedAt = Date.now();

        this.#node.id = this.#createID();
    }

    #getNodeData()
    {
        return {
            createdAt: this.#nodeCreatedAt,
            node: this.#node
        }
    }

    #createID() {
        return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
            (+c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +c / 4).toString(16)
        );
    }
}