/**
 * 
 * @param {HTMLFormElement} form Formulario HTML
 * 
 * @param { boolean } jsonFormat
 * 
 * Guardar datos del formulario al servidor.
 */
const saveFormDataToServer = async (form, jsonFormat = false) => {
    const { action, method } = form;
    const formData = new FormData(form);

    const methods = {
        get: async function () {
            /** @type { Array<string> } */
            const fields = [];
            formData.forEach((value, index) => {
                fields.push(`${index}=${value}`);
            });

            /** @type { string } */
            const queryString = `?${fields.join("&")}`;

            const response = await fetch(`${action}${queryString}`, { method, mode: 'cors' });
            if (!response.ok) console.error(response.status);

            if (jsonFormat) {
                const data = await response.json();
                return data;
            }

            const data = await response.text();
            // form.reset();
            return data;
        },

        post: async function () {
            const response = await fetch(action, {
                method,
                body: formData,
                credentials: 'same-origin',
                mode: 'same-origin'
            });

            if (!response.ok) console.error(response.status);

            if (jsonFormat) {
                const data = await response.json();
                return data;
            }

            const data = await response.text();
            // form.reset();
            
            return data;
        }
    };

    if (typeof methods[method] === "function") {
        const data = await methods[method]();
        return data;
    }
}

/**
 * 
 * @param { string } path Ruta del servidor
 * @returns { Promise<any> }
 */
async function getToken(path) {
    const response = await fetch(path);
    const data = await response.json();
    return data;
}

export {
    saveFormDataToServer,
    getToken
};