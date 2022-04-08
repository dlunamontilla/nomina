/**
 * @param { HTMLElement } element Ingrese el elemento que le 
 * aplicará los attributos.
 * 
 * @param { Object<string, string> } attributes Seleccione los atributos
 * que establecerá sobre el elemento.
 */
function setAttributes(element, attributes) {
	if (!element || !attributes) {
		console.warn("Recuerda que debe pasar como parámetro un elemento y un objeto con los atributos que implementará sobre dicho elemento");
		return;
	}

	for (const attribute in attributes) {
		const valueAttribute = attributes[attribute];
		element.setAttribute(attribute, valueAttribute);
	}
}

/**
 * 
 * @param {HTMLElement} element Elementos HTML
 * @param {Object<string, string>} css Objectos
 */
function css(element, css) {
	if (!element || !css) return;

	/**
	 * @type Array<string> Se almacenan propiedades con sus valores.
	 */
	const properties = [];

	for (const property in css) {
		properties.push(`${property}: ${css[property]}`);
	}

	element.setAttribute("style", properties.join("; "));
}

export {
	setAttributes,
	css
}