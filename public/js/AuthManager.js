/**
 * Frontend auth manager for Alumni TCSN Website
 */
class AuthManager
{
    constructor() {
        this.refreshEndpoint = '/auth/refresh';
        this.refreshInProgress = false;
        this.refreshQueue = [];
    }

    /**
     * Check whether cookie has expired or not.
     * @returns {boolean}
     */
    isTokenExpired() {
        const expiresAt = this.getCookie('token_expires_at');
        return expiresAt && Date.now() >= parseInt(expiresAt);
    }

    /**
     * Fetch cookie by its name
     * @param {string} name 
     * @returns {string|null}
     */
    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    /**
     * Refresh access token
     * @returns {Promise<void>}
     */
    async refreshToken() {
        if (this.refreshInProgress) {
            return new Promise((resolve) => {
                this.refreshQueue.push(resolve);
            });
        }

        this.refreshInProgress = true;

        try {
            const response = await fetch(this.refreshEndpoint, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Échec du rafraîchissement du token');
            }

            const data = await response.json();

            document.cookie = `token_expires_at=${Date.now() + (data.expires_in * 1000)}; path=/alumni_tcsn/; SameSite=Strict`;

            this.refreshQueue.forEach(resolve => resolve());
            this.refreshQueue = [];

        } catch (error) {
            console.error('Erreur lors du rafraîchissement du token:', error);
            //window.location.href = '/alumni_tcsn/login';
        } finally {
            this.refreshInProgress = false;
        }
    }

    /**
     * Effectue une requête authentifiée
     * @param {string} url 
     * @param {Object} options 
     * @returns {Promise<Response>}
     */
    async makeAuthenticatedRequest(url, options = {}) {
        if (this.isTokenExpired()) {
            await this.refreshToken();
        }

        return fetch(url, {
            ...options,
            credentials: 'include'
        });
    }
}