<script>
    import { get } from "svelte/store";
    import { saveFormDataToServer } from "./functions/get-register";

    export let name;

    /** @type { Promise<any> } */
    let datos;

    async function enviarFormulario(e) {
        e.preventDefault();
        datos = await saveFormDataToServer(this, false);
    }

    let data = datos;
    $: data = datos;

    async function getData(path) {
        const response = await fetch(path);
        const data = await response.text();
        return data;
    }

    let path = "";
    let requestData = getData(`./api/?${path}`);
    $: requestData = getData(`./api/?${path}`);
</script>

<header>{name}</header>

<main id="wrapper">
    <h3>Un pequeño experimento</h3>
    <hr />

    <form
        action="./api/"
        method="post"
        on:submit={enviarFormulario}
        enctype="multipart/form-data"
    >
        <input type="text" name="name" id="name" value="Ciencia" />
        <input type="text" name="probar" id="probar" value="Probar" />
        <input type="text" name="gipsemar" id="gipsemar" />
        <button type="submit">Realizar una prueba</button>
    </form>

    <h4>Resultados de la búsqueda</h4>
    <hr />

    <div class="busqueda">
        {#await data}
            Ciencia de datos...
        {:then value}
            <pre>{value ? value : ""}</pre>
        {/await}
    </div>

    <h3>Rutas de prueba</h3>
    <hr />

    <input type="text" name="resultados" id="resultados" bind:value={path} />
    <div class="busqueda">
        {#await requestData}
            Esperando datos...
        {:then datos}
            <pre>{datos}</pre>
        {/await}
    </div>
</main>

<footer class="footer">
    Todos los derechos reservados
    <div class="footer__inner" />
</footer>
