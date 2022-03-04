<script>
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
</script>

<header>{name}</header>

<main id="wrapper">

    <h3>Un pequeño experimento</h3>
    <hr>

    <form action="./?probar" method="post" on:submit="{enviarFormulario}" enctype="multipart/form-data">
        <input type="text" name="name" id="name" value="Ciencia">
        <input type="text" name="probar" id="probar" value="Probar">
        <button type="submit">Realizar una prueba</button>
    </form>

    <h4>Resultados de la búsqueda</h4>
    <hr>

    <div class="busqueda">
        {#await data}
            Ciencia de datos...
        {:then value} 
            { value ? value: "" }
        {/await}
    </div>
</main>

<footer class="footer">
    <div class="footer__inner">
        Todos los derechos reservados
    </div>
</footer>