import { css } from "./setAttributes";

/**
 * 
 * @param {MouseEvent} e Evento de Mouse
 */
function buttonActive(e) {
    const { layerX, layerY, target } = e;
    const element = target;

    if (element.classList.contains("button")) {
        element.removeAttribute("style");

        const size = element.getBoundingClientRect()
        const { width, height } = size;

        const posX = layerX / width;
        const posY = layerY / height;


        /**
         * Devuelve el tiempo que demora la animación en función
         * de la posición del mouse.
         * 
         * @param {number} number Posición numérica de 0 100.
         * @returns string
         */
        const getTime = number => {
            let currentValue = 0;


            currentValue = number > 50
                ? Math.round(100 - number)
                : number;

            currentValue = currentValue < 0 || currentValue >= 100
                ? 0
                : currentValue;

            currentValue = Math.round(currentValue);
            currentValue = Math.round(300 * (currentValue / 100 + 1.2));

            const time = `${currentValue}ms`;
            return time;
        }
        /**
         * Duracción de la animación
         */
        let time = getTime(Math.round(posX * 100));

        css(element, {
            "--x": `${layerX}px`,
            "--y": `${layerY}px`,
            "--animation": `${time} cubic-bezier(0, 0, 0, 0.4) expanded 1`
        });
    }
}

/**
 * 
 * @param {AnimationEvent} e Evento de animación
 */
function removeAttribute(e) {
    const element = e.target;
    element.removeAttribute("style");
}

document.body.addEventListener("click", buttonActive);
document.body.addEventListener("animationend", removeAttribute);

export { }