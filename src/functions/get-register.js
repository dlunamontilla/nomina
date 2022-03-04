/**
 * 
 * @param {HTMLFormElement} form Formulario HTML
 * 
 * Guardar datos del formulario al servidor.
 */
const saveFormDataToServer = async (form, jsonFormat = false) => {
    const { action, method } = form;
    const formData = new FormData(form);

    const methods = {
        get: async function() {
            /** @type { Array<string> } */
            const fields = [];
            formData.forEach((value, index) => {
                fields.push(`${index}=${value}`);
            });

            /** @type { string } */
            const queryString = `?${fields.join("&")}`;

            const response = await fetch(`${action}${queryString}`, {method});
            if (!response.ok) console.error(response.status);

            if (jsonFormat) {
                const data = await response.json();
                return data;
            }

            const data = await response.text();
            return data;
        },

        post: async function() {
            const response = await fetch(action, {
                method,
                body: formData
            });

            if (!response.ok) console.error(response.status);

            if (jsonFormat) {
                const data = await response.json();
                return data;
            }

            const data = await response.text();
            return data;
        }
    };

    if (typeof methods[method] === "function") {
        const data = await methods[method]();
        return data;
    }
}

export {
    saveFormDataToServer
};