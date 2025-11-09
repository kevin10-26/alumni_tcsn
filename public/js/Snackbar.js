/**
 * @file Snackbar.js
 * @description A module to handle snackbar feature
 * @license LGPL2-1
 */

'use strict'

class Snackbar {
    #stateColors = {
        error: {
            background: '#9F0712',
            text: '#FEFEE2'
        },
        warning: {
            background: '#FDC700',
            text: '#292524'
        },
        success: {
            background: '#00A63E',
            text: '#292524'
        },
        info: {
            background: '#44403B',
            text: '#FEFEE2'
        },
    };

    #snackbarParentId = '#snackbar-container';
    #snackbarContainerClass = 'snackbar-container';

    /**
     * Initializes the snackbar with the provided data.
     * @param {Object} data - The snackbar data containing the message and state.
     */
    init(data) {
        if (!this.#isValidData(data)) {
            console.error('No message specified');
            return;
        }

        return this.#fillSnackbar(data);
    }

    /**
     * Updates an existing snackbar with new data.
     * @param {Object} data - The snackbar data containing the message and state.
     */
    alter(data) {
        this.destroy(data['origin']);
        return this.init(data);
    }

    /**
     * Destroys the snackbar with the specified id.
     * @param {string} id - The id of the snackbar to remove.
     */
    destroy(id) {
        const snackbarElement = document.getElementById(id);

        if (snackbarElement) {
            console.info('Deleted ' + id + ' (snackbar)');
            snackbarElement.remove();
        }
    }

    /**
     * Creates and fills the snackbar with the specified data.
     * @param {Object} data - The snackbar data containing the message and state.
     * @returns {Object} The created snackbar element data.
     * @private
     */
    #fillSnackbar(data) {
        const snackbarParent = this.#getSnackbarParent();

        const container = this.#createSnackbarContainer(); // Create the container with an ID based on its time of creation, making it unique
        container.classList.add(this.#snackbarContainerClass);
        
        // Set up the container styles
        this.#setupContainerStyles(container);

        snackbarParent.appendChild(container);

        // Set the container's content and styles based on the state
        this.#setSnackbarStyles(container, data);

        // Trigger the animation with a 10ms delay to make the animation work.
        setTimeout(() => this.#animateSnackbar(container), 10);

        this.#displaySnackbar(data, container);

        return {
            element: container,
            id: container.id,
            timestamp: Date.now()
        };
    }

    /**
     * Gets the snackbar parent element, creating it if necessary.
     * @returns {HTMLElement} The snackbar parent element.
     * @private
     */
    #getSnackbarParent() {
        let snackbarParent = document.querySelector(this.#snackbarParentId);
        if (!snackbarParent) {
            snackbarParent = document.createElement('div');
            snackbarParent.id = 'snackbar-container';
            document.body.appendChild(snackbarParent);
        }
        return snackbarParent;
    }

    /**
     * Creates a new snackbar container element.
     * @returns {HTMLElement} The created snackbar container.
     * @private
     */
    #createSnackbarContainer() {
        const container = document.createElement('div');
        container.classList.add(this.#snackbarContainerClass);
        container.id = `snackbar-${Date.now()}`; // Assign a unique ID to the container
        return container;
    }

    /**
     * Sets up the initial styles for the snackbar container.
     * @param {HTMLElement} container - The snackbar container element.
     * @private
     */
    #setupContainerStyles(container) {
        container.style.display = 'flex';
        container.style.transition = 'all 0.5s';
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
    }

    /**
     * Sets the styles for the snackbar based on its state.
     * @param {HTMLElement} container - The snackbar container element.
     * @param {Object} data - The snackbar data containing the message and state.
     * @private
     */
    #setSnackbarStyles(container, data) {
        container.style.backgroundColor = this.#stateColors[data.state]?.background ?? this.#stateColors.info.background;
        container.style.color = this.#stateColors[data.state]?.text ?? this.#stateColors.info.text;
        container.textContent = data.msg;
    }

    /**
     * Animates the snackbar into view.
     * @param {HTMLElement} container - The snackbar container element.
     * @private
     */
    #animateSnackbar(container) {
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }

    /**
     * Displays the snackbar for a specified duration before removing it.
     * @param {Object} data - The snackbar data containing the duration.
     * @param {HTMLElement} container - The snackbar container element.
     * @private
     */
    #displaySnackbar(data, container) {
        const duration = data.ttl ?? 33000;
        setTimeout(() => {
            container.remove();
        }, duration);
    }

    /**
     * Validates the snackbar data.
     * @param {Object} data - The snackbar data to validate.
     * @returns {boolean} Whether the data is valid.
     * @private
     */
    #isValidData(data) {
        return data.msg !== undefined && data.msg.length > 0;
    }
}
