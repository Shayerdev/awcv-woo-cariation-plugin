class Ajax
{
    static async post(url, action, data) {
        return fetch(`${url}?action=${action}`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }
}

export default Ajax;