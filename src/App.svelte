<script>
    import { saveFormDataToServer } from "./functions/get-register";

    // Layers
    import Header from "./components/Header.svelte";
    import Content from "./components/Content.svelte";
    import Footer from "./components/Footer.svelte";

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

<Header />
<Content />
<Footer />
